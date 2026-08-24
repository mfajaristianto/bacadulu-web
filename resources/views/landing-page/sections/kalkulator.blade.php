<section id="kalkulator" class="bd-calc-section relative py-20 bg-white overflow-hidden">
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

            <h2 class="text-3xl font-extrabold text-slate-900 mt-2">
                Kalkulator Simulasi Penerbitan
            </h2>

            <p class="text-slate-500 text-sm mt-2">
                Gunakan simulasi ini untuk memperoleh gambaran awal biaya penerbitan.
            </p>
        </div>

        <div data-bd-reveal="zoom">
            <div data-bd-tilt class="bd-calculator grid md:grid-cols-2 gap-8 p-6 md:p-8 bg-white border border-slate-100 rounded-3xl shadow-xl">

                <div class="flex flex-col gap-5 bd-depth-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">
                            Jenis Paket
                        </label>

                        <select id="calcPaket"
                                onchange="hitungSimulasi()"
                                class="bd-calc-field w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                            <option value="500000">
                                Paket Hemat (E-Book & ISBN) - Rp 500.000
                            </option>

                            <option value="1200000" selected>
                                Paket Premium (Cetak + ISBN + Layout) - Rp 1.200.000
                            </option>

                            <option value="2500000">
                                Paket Eksklusif (Cetak + ISBN + HAKI) - Rp 2.500.000
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">
                            Jumlah Halaman Buku
                        </label>

                        <input type="number"
                               id="calcHalaman"
                               oninput="hitungSimulasi()"
                               value="150"
                               min="50"
                               max="1000"
                               class="bd-calc-field w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">
                            Jumlah Buku Fisik
                        </label>

                        <input type="number"
                               id="calcCetak"
                               oninput="hitungSimulasi()"
                               value="10"
                               min="5"
                               max="500"
                               class="bd-calc-field w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm">
                    </div>
                </div>

                <div class="bd-calc-result bd-depth-2 bg-slate-50 border border-slate-100 rounded-2xl p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 mb-3">
                            <svg class="w-5 h-5 text-orange-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 5h16v14H4zM8 9h8M8 13h3"/>
                            </svg>

                            <h4 class="text-sm font-bold text-slate-700">
                                Rincian Estimasi
                            </h4>
                        </div>

                        <div class="flex justify-between text-xs py-2 border-b border-slate-200">
                            <span class="text-slate-500">Harga Paket Dasar</span>
                            <strong id="resPaket" data-value="1200000">Rp 1.200.000</strong>
                        </div>

                        <div class="flex justify-between text-xs py-2 border-b border-slate-200">
                            <span class="text-slate-500">Tambahan Halaman</span>
                            <strong id="resHalaman" data-value="100000">Rp 100.000</strong>
                        </div>

                        <div class="flex justify-between text-xs py-2">
                            <span class="text-slate-500">Tambahan Cetak</span>
                            <strong id="resCetak" data-value="0">Rp 0</strong>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-slate-200">
                        <span class="text-[10px] text-slate-500 uppercase">
                            Total Estimasi
                        </span>

                        <h3 class="text-3xl font-black text-orange-600 mt-1"
                            id="resTotal"
                            data-value="1300000">
                            Rp 1.300.000
                        </h3>

                        <p class="text-[9px] text-slate-400 mt-2">
                            *Biaya akhir menyesuaikan hasil pemeriksaan naskah.
                        </p>

                        <a href="https://wa.me/6285139461070?text=Halo%20Admin%20BacaDulu,%20saya%20ingin%20konsultasi%20penerbitan%20buku."
                           target="_blank"
                           rel="noopener noreferrer"
                           class="bd-calc-wa w-full mt-4 flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold text-xs py-3 rounded-xl">
                            Konsultasi via WhatsApp
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<style>
.bd-calculator{transform-style:preserve-3d}
.bd-calc-field{outline:none;transition:border-color .25s ease,box-shadow .25s ease,background .25s ease}
.bd-calc-field:focus{border-color:#EF5843;background:#fff;box-shadow:0 0 0 4px rgba(239,88,67,.08)}
.bd-calc-result{position:relative;overflow:hidden}

.bd-calc-result::after{
    content:"";
    position:absolute;
    width:170px;
    height:170px;
    right:-100px;
    bottom:-100px;
    border-radius:50%;
    background:radial-gradient(circle,rgba(247,170,53,.16),transparent 70%);
    pointer-events:none
}

.bd-calc-wa{transition:transform .25s ease,background .25s ease,box-shadow .25s ease}

.bd-calc-wa:hover{
    transform:translateY(-2px);
    box-shadow:0 10px 24px rgba(239,88,67,.2)
}
</style>

<script>
function hitungSimulasi(){
    const paket=Number(document.getElementById('calcPaket')?.value||0);
    const halaman=Number(document.getElementById('calcHalaman')?.value||0);
    const cetak=Number(document.getElementById('calcCetak')?.value||0);

    const biayaHalaman=halaman>100?(halaman-100)*2000:0;
    const biayaCetak=cetak>10?(cetak-10)*45000:0;
    const total=paket+biayaHalaman+biayaCetak;

    const resPaket=document.getElementById('resPaket');
    const resHalaman=document.getElementById('resHalaman');
    const resCetak=document.getElementById('resCetak');
    const resTotal=document.getElementById('resTotal');

    if(window.bdAnimateMoney){
        window.bdAnimateMoney(resPaket,paket);
        window.bdAnimateMoney(resHalaman,biayaHalaman);
        window.bdAnimateMoney(resCetak,biayaCetak);
        window.bdAnimateMoney(resTotal,total);
        return;
    }

    const rp=n=>'Rp '+Number(n||0).toLocaleString('id-ID');

    if(resPaket)resPaket.textContent=rp(paket);
    if(resHalaman)resHalaman.textContent=rp(biayaHalaman);
    if(resCetak)resCetak.textContent=rp(biayaCetak);
    if(resTotal)resTotal.textContent=rp(total);
}

if(document.readyState==='loading'){
    document.addEventListener('DOMContentLoaded',hitungSimulasi);
}else{
    hitungSimulasi();
}
</script>