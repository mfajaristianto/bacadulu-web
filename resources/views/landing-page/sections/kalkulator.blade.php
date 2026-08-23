<section id="kalkulator" class="relative py-20 bg-white overflow-hidden">
    <div class="bd-section-glow bg-[#241B52] -left-44 top-20"></div>

    <div class="max-w-5xl mx-auto px-6 relative">
        <div class="text-center mb-10" data-bd-reveal="up">

            <div class="inline-flex items-center gap-2 text-orange-600">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="4" y="2" width="16" height="20" rx="2"/>
                    <path d="M8 6h8M8 11h2M14 11h2M8 15h2M14 15h2"/>
                </svg>
                <span class="text-xs font-bold tracking-widest uppercase">Simulasi Biaya</span>
            </div>

            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">Kalkulator Simulasi Penerbitan</h2>
            <p class="text-slate-500 text-sm mt-2">Gunakan simulasi ini untuk memperoleh gambaran awal biaya penerbitan.</p>
        </div>

        <div data-bd-reveal="zoom">
            <div data-bd-tilt class="bd-calculator grid md:grid-cols-2 gap-8 p-6 md:p-8 bg-white border border-slate-100 rounded-3xl shadow-xl">

                <div class="flex flex-col gap-5 bd-depth-1">

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis Paket</label>
                        <select id="calcPaket" onchange="hitungSimulasi()" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <option value="500000">Paket Hemat (E-Book & ISBN) - Rp 500.000</option>
                            <option value="1200000" selected>Paket Premium (Cetak + ISBN + Layout) - Rp 1.200.000</option>
                            <option value="2500000">Paket Eksklusif (Cetak + ISBN + HAKI) - Rp 2.500.000</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jumlah Halaman Buku</label>
                        <input type="number" id="calcHalaman" oninput="hitungSimulasi()" value="150" min="50" max="1000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jumlah Buku Fisik</label>
                        <input type="number" id="calcCetak" oninput="hitungSimulasi()" value="10" min="5" max="500" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                </div>

                <div class="bd-depth-2 bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 5h16v14H4zM8 9h8M8 13h3"/>
                            </svg>
                            <h4 class="text-sm font-bold text-slate-700">Rincian Estimasi</h4>
                        </div>

                        <div class="flex justify-between text-xs py-2 border-b"><span class="text-slate-500">Harga Paket Dasar</span><strong id="resPaket">Rp 1.200.000</strong></div>
                        <div class="flex justify-between text-xs py-2 border-b"><span class="text-slate-500">Tambahan Halaman</span><strong id="resHalaman">Rp 0</strong></div>
                        <div class="flex justify-between text-xs py-2"><span class="text-slate-500">Tambahan Cetak</span><strong id="resCetak">Rp 0</strong></div>
                    </div>

                    <div class="mt-5 pt-4 border-t">
                        <span class="text-[10px] text-slate-500 uppercase">Total Estimasi</span>
                        <h3 class="text-3xl font-black text-orange-600 mt-1" id="resTotal">Rp 1.200.000</h3>
                        <p class="text-[9px] text-slate-400 mt-2">*Biaya akhir menyesuaikan hasil pemeriksaan naskah.</p>

                        <a href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                           target="_blank"
                           class="w-full mt-4 flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs py-3 rounded-xl">
                            Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>.bd-calculator{transform-style:preserve-3d}</style>

<script>
function hitungSimulasi(){
    const paket=+document.getElementById('calcPaket').value||0;
    const halaman=+document.getElementById('calcHalaman').value||0;
    const cetak=+document.getElementById('calcCetak').value||0;
    const biayaHalaman=halaman>100?(halaman-100)*2000:0;
    const biayaCetak=cetak>10?(cetak-10)*45000:0;
    const rp=n=>'Rp '+n.toLocaleString('id-ID');

    document.getElementById('resPaket').innerText=rp(paket);
    document.getElementById('resHalaman').innerText=rp(biayaHalaman);
    document.getElementById('resCetak').innerText=rp(biayaCetak);
    document.getElementById('resTotal').innerText=rp(paket+biayaHalaman+biayaCetak);
}
document.addEventListener('DOMContentLoaded',hitungSimulasi);
</script>