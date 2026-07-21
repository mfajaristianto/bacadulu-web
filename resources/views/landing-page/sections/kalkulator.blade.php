<section id="kalkulator" class="py-20 bg-slate-50 relative">
    <div class="max-w-5xl mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-orange-600 text-xs font-bold tracking-widest uppercase">Transparency Pricing</span>
            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Kalkulator Simulasi Penerbitan</h2>
            <p class="text-slate-500 text-sm mt-2">Pilih paket dan kustomisasi sesuai kebutuhan Anda untuk melihat perkiraan biaya terbit.</p>
        </div>

        <div class="bg-white rounded-3xl p-8 border border-slate-100 shadow-xl shadow-slate-200/50 grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Panel Kontrol -->
            <div class="flex flex-col gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">1. Pilih Jenis Paket</label>
                    <select id="calcPaket" onchange="hitungSimulasi()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-1 focus:ring-orange-500">
                        <option value="500000">Paket Hemat (E-Book & ISBN) - Rp 500.000</option>
                        <option value="1200000" selected>Paket Premium (Cetak + ISBN + Layout) - Rp 1.200.000</option>
                        <option value="2500000">Paket Eksklusif (Cetak + ISBN + HAKI) - Rp 2.500.000</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">2. Jumlah Halaman Buku</label>
                    <input type="number" id="calcHalaman" oninput="hitungSimulasi()" value="150" min="50" max="1000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-1 focus:ring-orange-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">3. Jumlah Buku Fisik Dicetak</label>
                    <input type="number" id="calcCetak" oninput="hitungSimulasi()" value="10" min="5" max="500" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:outline-none focus:ring-1 focus:ring-orange-500">
                </div>
            </div>

            <!-- Hasil Perhitungan -->
            <div class="bg-slate-50 rounded-2xl p-6 flex flex-col justify-between border border-slate-100">
                <div>
                    <h4 class="text-sm font-bold text-slate-600 mb-2">Rincian Estimasi Biaya:</h4>
                    <div class="flex justify-between text-xs py-2 border-b border-slate-200">
                        <span class="text-slate-500">Harga Paket Dasar</span>
                        <span class="text-slate-800 font-semibold" id="resPaket">Rp 1.200.000</span>
                    </div>
                    <div class="flex justify-between text-xs py-2 border-b border-slate-200">
                        <span class="text-slate-500">Tambahan Biaya Halaman</span>
                        <span class="text-slate-800 font-semibold" id="resHalaman">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-xs py-2">
                        <span class="text-slate-500">Biaya Cetak Tambahan</span>
                        <span class="text-slate-800 font-semibold" id="resCetak">Rp 0</span>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-200">
                    <span class="text-[10px] text-slate-500 uppercase block tracking-wider">Total Estimasi Terbit:</span>
                    <h3 class="text-3xl font-black text-orange-600 mt-1" id="resTotal">Rp 1.200.000</h3>
                    <p class="text-[9px] text-slate-400 mt-2">*Biaya akhir dapat disesuaikan kembali setelah naskah diulas oleh editor kami.</p>
                    
                    <a href="https://wa.me/6281315717719?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20paket%20buku%20saya." target="_blank" class="w-full mt-4 bg-orange-500 hover:bg-orange-600 text-white font-extrabold text-xs py-3 rounded-xl shadow-md shadow-orange-500/10 transition-colors duration-200 flex items-center justify-center gap-2">
                        Konsultasi via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    function hitungSimulasi() {
        const paketDasar = parseInt(document.getElementById('calcPaket').value) || 0;
        const jmlHalaman = parseInt(document.getElementById('calcHalaman').value) || 0;
        const jmlCetak = parseInt(document.getElementById('calcCetak').value) || 0;

        let tambahanHalaman = 0;
        if (jmlHalaman > 100) {
            tambahanHalaman = (jmlHalaman - 100) * 2000;
        }

        let tambahanCetak = 0;
        if (jmlCetak > 10) {
            tambahanCetak = (jmlCetak - 10) * 45000;
        }

        const totalSemua = paketDasar + tambahanHalaman + tambahanCetak;

        document.getElementById('resPaket').innerText = 'Rp ' + paketDasar.toLocaleString('id-ID');
        document.getElementById('resHalaman').innerText = 'Rp ' + tambahanHalaman.toLocaleString('id-ID');
        document.getElementById('resCetak').innerText = 'Rp ' + tambahanCetak.toLocaleString('id-ID');
        document.getElementById('resTotal').innerText = 'Rp ' + totalSemua.toLocaleString('id-ID');
    }

    document.addEventListener("DOMContentLoaded", function() {
        hitungSimulasi();
    });
</script>