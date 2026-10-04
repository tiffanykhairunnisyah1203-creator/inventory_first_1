<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keuangan;
use App\Models\KeuanganArsip;
use App\Models\KeuanganRekap;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $bulanFilter = $request->input('bulan');

        if ($bulanFilter) {
            // MODE ARSIP: Ambil data dari tabel rekap
            $rekap = KeuanganRekap::where('periode', $bulanFilter)->first();

            // Gunakan null-safe operator agar tidak error jika rekap kosong
            $pemasukanManual = $rekap?->total_pemasukan ?? 0;
            $totalPenarikanSolar = $rekap?->total_solar ?? 0;
            $totalPenarikanPettyCash = $rekap?->total_petty_cash ?? 0;
            $saldoTersedia = $rekap?->saldo_akhir ?? 0;

            $query = KeuanganArsip::where('periode', $bulanFilter);
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('keterangan', 'like', '%' . $request->search . '%')
                      ->orWhere('nama_driver', 'like', '%' . $request->search . '%');
                });
            }
            $riwayat = $query->latest()->paginate(10);
        } else {
            // MODE AKTIF: Data bulan berjalan
            $rekapTerakhir = KeuanganRekap::orderBy('periode', 'desc')->first();
            $saldoAwal = $rekapTerakhir ? (float) $rekapTerakhir->saldo_akhir : 0;

            $pemasukanManual = Keuangan::where('jenis_transaksi', 'masuk')->sum('jumlah');
            $totalPenarikanSolar = Keuangan::where('jenis_transaksi', 'keluar')->where('jenis_penarikan', 'solar')->sum('jumlah');
            $totalPenarikanPettyCash = Keuangan::where('jenis_transaksi', 'keluar')->where('jenis_penarikan', 'petty_cash')->sum('jumlah');

            $saldoTersedia = $saldoAwal + $pemasukanManual - ($totalPenarikanSolar + $totalPenarikanPettyCash);

            $query = Keuangan::query();
            if ($request->search) {
                $query->where(function($q) use ($request) {
                    $q->where('keterangan', 'like', '%' . $request->search . '%')
                      ->orWhere('nama_driver', 'like', '%' . $request->search . '%');
                });
            }
            $riwayat = $query->latest()->paginate(10);
        }

        return view('admin.keuangan.index', compact(
            'saldoTersedia', 'pemasukanManual', 'totalPenarikanSolar', 'totalPenarikanPettyCash', 'riwayat'
        ));
    }

    public function createPencairan() { return view('admin.keuangan.pencairan'); }

    public function store(Request $request) {
        $request->merge([
            'jumlah' => $request->nominal ?? $request->jumlah,
            'jenis_penarikan' => $request->kategori ?? $request->jenis_penarikan
        ]);
        return $this->storePencairan($request);
    }

    public function storePencairan(Request $request) {
        if ($request->no_kendaraan === 'lainnya') {
            $request->merge(['no_kendaraan' => strtoupper($request->no_kendaraan_manual)]);
        }
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
            'jenis_penarikan' => 'required|in:solar,petty_cash',
        ]);

        // Langsung simpan ke tabel keuangans tanpa menyimpan ke withdrawals
        Keuangan::create([
            'jumlah' => $request->jumlah,
            'keterangan' => 'Pencairan saldo ' . str_replace('_', ' ', $request->jenis_penarikan),
            'jenis_transaksi' => 'keluar',
            'jenis_penarikan' => $request->jenis_penarikan,
            'nama_driver' => $request->nama_driver,
            'no_kendaraan' => $request->no_kendaraan, 
            'status' => 'verified',
        ]);
        
        return redirect()->route('admin.keuangan.index')->with('success', 'Penarikan saldo berhasil!');
    }

    public function createTopup() { return view('admin.keuangan.topup'); }

    public function storeTopup(Request $request) {
        $request->validate(['jumlah' => 'required|numeric|min:1', 'keterangan' => 'required|string']);
        Keuangan::create([
            'jumlah' => $request->jumlah,
            'keterangan' => "Top Up Saldo Bulan " . $request->keterangan . ($request->catatan ? " - " . $request->catatan : ""),
            'jenis_transaksi' => 'masuk', 
            'status' => 'verified',
        ]);
        return redirect()->route('admin.keuangan.index')->with('success', 'Saldo berhasil ditambahkan!');
    }

    public function arsipData(Request $request) {
        $periode = date('Y-m'); 
        $transaksiAktif = Keuangan::all();

        if ($transaksiAktif->isEmpty()) {
            return redirect()->back()->with('error', 'Tidak ada data transaksi aktif yang bisa diarsipkan.');
        }

        DB::beginTransaction();
        try {
            $pemasukanBaru = $transaksiAktif->where('jenis_transaksi', 'masuk')->sum('jumlah');
            $solarBaru = $transaksiAktif->where('jenis_transaksi', 'keluar')->where('jenis_penarikan', 'solar')->sum('jumlah');
            $pettyBaru = $transaksiAktif->where('jenis_transaksi', 'keluar')->where('jenis_penarikan', 'petty_cash')->sum('jumlah');
            $totalKeluarBaru = $solarBaru + $pettyBaru;

            $rekapBulanIni = KeuanganRekap::where('periode', $periode)->first();

            if ($rekapBulanIni) {
                $rekapBulanIni->update([
                    'total_pemasukan'   => $rekapBulanIni->total_pemasukan + $pemasukanBaru,
                    'total_solar'       => $rekapBulanIni->total_solar + $solarBaru,
                    'total_petty_cash'  => $rekapBulanIni->total_petty_cash + $pettyBaru,
                    'total_pengeluaran' => $rekapBulanIni->total_pengeluaran + $totalKeluarBaru,
                    'saldo_akhir'       => $rekapBulanIni->saldo_akhir + $pemasukanBaru - $totalKeluarBaru
                ]);
            } else {
                $rekapTerakhir = KeuanganRekap::where('periode', '<', $periode)->orderBy('periode', 'desc')->first();
                $saldoAwal = $rekapTerakhir ? (float) $rekapTerakhir->saldo_akhir : 0;
                $saldoAkhir = $saldoAwal + $pemasukanBaru - $totalKeluarBaru;

                KeuanganRekap::create([
                    'periode'           => $periode,
                    'total_pemasukan'   => $pemasukanBaru,
                    'total_solar'       => $solarBaru,
                    'total_petty_cash'  => $pettyBaru,
                    'total_pengeluaran' => $totalKeluarBaru,
                    'saldo_akhir'       => $saldoAkhir
                ]);
            }

            $dataArsip = $transaksiAktif->map(function ($item) use ($periode) {
                return [
                    'periode'         => $periode,
                    'jumlah'          => $item->jumlah,
                    'keterangan'      => $item->keterangan,
                    'jenis_transaksi' => $item->jenis_transaksi,
                    'jenis_penarikan' => $item->jenis_penarikan,
                    'nama_driver'     => $item->nama_driver,
                    'no_kendaraan'    => $item->no_kendaraan,
                    'status'          => $item->status,
                    'created_at'      => $item->created_at,
                    'updated_at'      => now(),
                ];
            })->toArray();

            KeuanganArsip::insert($dataArsip);

            Keuangan::query()->delete();

            DB::commit();
            return redirect()->route('admin.keuangan.index')->with('success', 'Berhasil Tutup Buku dan Update Arsip!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Gagal Arsip Keuangan: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function cetakStruk($id) {
        $data = Keuangan::findOrFail($id);
        return view('admin.keuangan.cetak-struk', compact('data'));
    }

    public function destroy($id) {
        Keuangan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data dihapus!');
    }

    // Fungsi tambahan untuk menghapus Arsip dan Rekap berdasarkan periode (bulan)
    public function destroyArsipBulan($periode)
    {
        DB::beginTransaction();
        try {
            // 1. Cek apakah rekap bulan tersebut ada
            $rekap = KeuanganRekap::where('periode', $periode)->first();

            if (!$rekap) {
                return redirect()->back()->with('error', 'Data rekap untuk periode ini tidak ditemukan.');
            }

            // 2. Hapus data di tabel rekap
            KeuanganRekap::where('periode', $periode)->delete();

            // 3. Hapus semua data historis/detail di tabel arsip pada bulan yang sama
            KeuanganArsip::where('periode', $periode)->delete();

            DB::commit();

            return redirect()->route('admin.keuangan.index')->with('success', 'Data arsip dan rekap periode ' . $periode . ' berhasil dihapus! Semua saldo kembali Rp 0.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Gagal Hapus Arsip Bulan: " . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus arsip: ' . $e->getMessage());
        }
    }
}