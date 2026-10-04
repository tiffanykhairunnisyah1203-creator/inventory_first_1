<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Keuangan;
use App\Models\KeuanganArsip;
use App\Models\KeuanganRekap;
use Carbon\Carbon;

class ArsipKeuanganBulanan extends Command
{
    protected $signature = 'keuangan:arsip';
    protected $description = 'Rekap dan pindahkan data keuangan bulan lalu ke arsip';

    public function handle()
    {
        // Ambil data bulan lalu
        $bulanLalu = Carbon::now()->subMonth();
        $periode = $bulanLalu->format('Y-m'); // Contoh: "2026-03"

        DB::beginTransaction();
        try {
            // 1. Ambil Saldo Akhir dari bulan sebelumnya lagi (jika ada)
            $saldoBulanSebelumnya = KeuanganRekap::latest('periode')->value('saldo_akhir') ?? 0;

            // 2. Hitung Rekap Bulan Lalu dari tabel aktif
            $pemasukan = Keuangan::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)->where('jenis_transaksi', 'masuk')->sum('jumlah');
            
            $solar = Keuangan::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)->where('jenis_penarikan', 'solar')->sum('jumlah');
            
            $pettyCash = Keuangan::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)->where('jenis_penarikan', 'petty_cash')->sum('jumlah');
            
            $pengeluaran = Keuangan::whereMonth('created_at', $bulanLalu->month)
                ->whereYear('created_at', $bulanLalu->year)->where('jenis_transaksi', 'keluar')->sum('jumlah');

            $saldoAkhir = $saldoBulanSebelumnya + $pemasukan - $pengeluaran;

            // 3. Simpan Rekap
            KeuanganRekap::updateOrCreate(
                ['periode' => $periode],
                [
                    'total_pemasukan' => $pemasukan,
                    'total_solar' => $solar,
                    'total_petty_cash' => $pettyCash,
                    'total_pengeluaran' => $pengeluaran,
                    'saldo_akhir' => $saldoAkhir,
                ]
            );

            // 4. Pindahkan ke Arsip
            $transaksiAktif = Keuangan::whereMonth('created_at', $bulanLalu->month)
                                      ->whereYear('created_at', $bulanLalu->year)->get();
            
            foreach ($transaksiAktif as $item) {
                KeuanganArsip::create([
                    'periode' => $periode,
                    'jumlah' => $item->jumlah,
                    'keterangan' => $item->keterangan,
                    'jenis_transaksi' => $item->jenis_transaksi,
                    'jenis_penarikan' => $item->jenis_penarikan,
                    'nama_driver' => $item->nama_driver,
                    'no_kendaraan' => $item->no_kendaraan,
                    'status' => $item->status,
                    'created_at' => $item->created_at, // Pertahankan tanggal asli
                ]);
            }

            // 5. Hapus dari tabel aktif
            Keuangan::whereMonth('created_at', $bulanLalu->month)
                    ->whereYear('created_at', $bulanLalu->year)->delete();

            DB::commit();
            $this->info("Arsip keuangan periode {$periode} berhasil.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Gagal: " . $e->getMessage());
        }
    }
}