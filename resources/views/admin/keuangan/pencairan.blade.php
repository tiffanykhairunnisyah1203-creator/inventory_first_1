<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800">Pencairan Saldo</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <div class="mb-8 border-l-4 border-indigo-600 pl-4">
                    <h3 class="text-xl font-bold text-gray-900">Form Pencairan Saldo</h3>
                    <p class="text-gray-500 text-sm mt-1">Silakan isi detail pencairan Saldo operasional di bawah ini.</p>
                </div>

                <form action="{{ route('admin.keuangan.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-2">Nominal Pencairan</label>
                        <div class="relative">
                            <input type="text" name="jumlah" id="jumlah" required oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none"
                                placeholder="Rp.">
                        </div>
                    </div>

                    <div>
                        <label for="jenis_penarikan" class="block text-sm font-semibold text-gray-700 mb-2">Kategori Pencairan</label>
                        <select name="jenis_penarikan" id="jenis_penarikan" required onchange="aturDropdown(this.value)"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <option value="solar">Operasional Solar</option>
                            <option value="petty_cash">Operasional Petty Cash</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div id="div_driver" class="hidden">
                            <label for="nama_driver" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Driver <span class="text-gray-400 font-normal text-xs ml-1">(Wajib/Opsional)</span>
                            </label>
                            <input type="text" name="nama_driver" id="nama_driver"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 transition-all outline-none"
                                placeholder="Masukkan nama driver">
                        </div>
                        
                        <div id="div_kendaraan" class="hidden">
                            <label for="no_kendaraan" class="block text-sm font-semibold text-gray-700 mb-2">
                                No Kendaraan <span class="text-gray-400 text-[10px] ml-1"></span>
                            </label>
                            
                            <div class="flex items-center gap-2">
                                <select name="no_kendaraan" id="no_kendaraan" onchange="cekKendaraanLainnya(this.value)" 
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-50 text-gray-900 font-mono transition-all outline-none cursor-pointer">
                                    <option value="">-- Pilih Kendaraan --</option>
                                    @foreach(\App\Models\Kendaraan::all() as $k)
                                        <option value="{{ $k->no_plat }}">{{ $k->no_plat }}</option>
                                    @endforeach
                                    <option value="lainnya" class="font-bold text-indigo-600 bg-indigo-50">Kendaraan Lainnya (Input Manual)...</option>
                                </select>

                                <button type="button" id="btn_hapus_kendaraan" class="hidden shrink-0 px-3 py-2.5 bg-red-50 text-red-600 hover:bg-red-100 hover:text-red-700 border border-red-200 rounded-xl transition-colors" title="Hapus Plat Kendaraan dari Database">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>

                            <input type="text" name="no_kendaraan_manual" id="no_kendaraan_manual" onblur="tambahkanKeDropdown()"
                                class="hidden mt-3 w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white text-gray-900 uppercase transition-all outline-none shadow-inner" 
                                placeholder="Ketik No Kendaraan (Contoh: B 1234 ABC)">
                        </div>
                    </div>

                    <div class="flex flex-col-reverse sm:flex-row justify-end items-center gap-3 pt-6 mt-4 border-t border-gray-100">
                        <a href="{{ route('admin.keuangan.index') }}" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-semibold rounded-lg transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow-sm transition-colors whitespace-nowrap">
                            Konfirmasi Pencairan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('input[name="_token"]').value;

        function aturDropdown(jenis) {
            const divKendaraan = document.getElementById('div_kendaraan');
            const divDriver = document.getElementById('div_driver');
            if(jenis === 'solar') {
                divKendaraan.classList.remove('hidden');
                divDriver.classList.remove('hidden');
            } else {
                divKendaraan.classList.add('hidden');
                divDriver.classList.remove('hidden');
            }
        }

        function cekKendaraanLainnya(nilai) {
            const inputManual = document.getElementById('no_kendaraan_manual');
            const btnHapus = document.getElementById('btn_hapus_kendaraan');

            // Logika menampilkan atau menyembunyikan tombol hapus
            if (nilai !== '' && nilai !== 'lainnya') {
                btnHapus.classList.remove('hidden');
            } else {
                btnHapus.classList.add('hidden');
            }

            if (nilai === 'lainnya') {
                inputManual.classList.remove('hidden');
                inputManual.required = true;
                inputManual.focus(); 
            } else {
                inputManual.classList.add('hidden');
                inputManual.required = false;
            }
        }

        // AJAX SIMPAN KENDARAAN
        async function tambahkanKeDropdown() {
            const selectKendaraan = document.getElementById('no_kendaraan');
            const inputManual = document.getElementById('no_kendaraan_manual');
            const nilaiBaru = inputManual.value.trim().toUpperCase();

            if (nilaiBaru !== "") {
                try {
                    const response = await fetch("{{ route('admin.keuangan.kendaraan.storeAjax') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify({ no_plat: nilaiBaru })
                    });

                    const result = await response.json();
                    if (result.success) {
                        let opsiAda = false;
                        for (let i = 0; i < selectKendaraan.options.length; i++) {
                            if (selectKendaraan.options[i].value === nilaiBaru) { opsiAda = true; break; }
                        }

                        if (!opsiAda) {
                            const opsiBaru = document.createElement('option');
                            opsiBaru.value = nilaiBaru;
                            opsiBaru.text = nilaiBaru;
                            const opsiLainnya = selectKendaraan.querySelector('option[value="lainnya"]');
                            selectKendaraan.insertBefore(opsiBaru, opsiLainnya);
                        }
                        selectKendaraan.value = nilaiBaru;
                        inputManual.classList.add('hidden');
                        inputManual.value = '';
                        
                        // Validasi cek tombol hapus kembali setelah data berhasil disimpan
                        cekKendaraanLainnya(nilaiBaru);
                    }
                } catch (error) {
                    alert("Gagal menyimpan plat nomor.");
                }
            }
        }

        // FUNGSI KLIK TOMBOL HAPUS KENDARAAN (MENGGANTIKAN KLIK KANAN)
        document.getElementById('btn_hapus_kendaraan').addEventListener('click', async function() {
            const selectKendaraan = document.getElementById('no_kendaraan');
            const nilaiTerpilih = selectKendaraan.value;

            if (nilaiTerpilih && nilaiTerpilih !== "lainnya") {
                if (confirm(`Hapus plat "${nilaiTerpilih}" dari database?`)) {
                    try {
                        const response = await fetch(`/admin/keuangan/kendaraan/destroy-ajax/${nilaiTerpilih}`, {
                            method: "DELETE",
                            headers: { "X-CSRF-TOKEN": csrfToken }
                        });
                        const result = await response.json();
                        
                        if (result.success) {
                            selectKendaraan.remove(selectKendaraan.selectedIndex);
                            selectKendaraan.value = "";
                            cekKendaraanLainnya(""); // Sembunyikan tombol hapus karena reset ke kosong
                        } else {
                            alert(result.message || "Gagal menghapus data.");
                        }
                    } catch (error) {
                        alert("Gagal menghapus data. Periksa koneksi.");
                    }
                }
            }
        });

        // (Opsional) Fitur Klik Kanan Tetap Disimpan Sebagai Fallback
        document.addEventListener('DOMContentLoaded', function() {
            const selectKendaraan = document.getElementById('no_kendaraan');
            selectKendaraan.addEventListener('contextmenu', async function(e) {
                e.preventDefault();
                const nilaiTerpilih = this.value;
                if (nilaiTerpilih && nilaiTerpilih !== "lainnya") {
                    if (confirm(`Hapus plat "${nilaiTerpilih}" dari database?`)) {
                        try {
                            const response = await fetch(`/admin/keuangan/kendaraan/destroy-ajax/${nilaiTerpilih}`, {
                                method: "DELETE",
                                headers: { "X-CSRF-TOKEN": csrfToken }
                            });
                            const result = await response.json();
                            if (result.success) {
                                this.remove(this.selectedIndex);
                                this.value = "";
                                cekKendaraanLainnya(""); // Sembunyikan tombol
                            }
                        } catch (error) {
                            alert("Gagal menghapus data.");
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>