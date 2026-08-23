@php
$steps=[
    [
        'title'=>'Kirim Naskah',
        'desc'=>'Kirim draf lengkap naskah dalam format dokumen untuk dilakukan pemeriksaan awal.',
        'icon'=>'upload'
    ],
    [
        'title'=>'Penyuntingan & Layout',
        'desc'=>'Naskah melalui proses penyuntingan, desain sampul, dan penataan isi buku.',
        'icon'=>'edit'
    ],
    [
        'title'=>'ISBN & HAKI',
        'desc'=>'Pengurusan ISBN resmi serta perlindungan hak kekayaan intelektual sesuai kebutuhan.',
        'icon'=>'shield'
    ],
    [
        'title'=>'Cetak & Distribusi',
        'desc'=>'Buku siap dicetak dan didistribusikan dalam format fisik maupun digital.',
        'icon'=>'package'
    ]
];
@endphp

<section id="alur" class="relative py-20 bg-white overflow-hidden">
    <div class="bd-section-glow bg-orange-400 -right-44 top-20"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative">
        <div class="text-center max-w-3xl mx-auto mb-12" data-bd-reveal="up">
            <span class="text-orange-600 text-xs font-bold tracking-widest uppercase">Proses Penerbitan</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mt-2">Alur Mudah Menerbitkan Buku</h2>
            <p class="text-slate-500 text-sm mt-3">Setiap naskah diproses secara terstruktur dari tahap awal hingga siap diterbitkan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($steps as $i=>$step)
            <div data-bd-reveal="up" data-bd-delay="{{ $i*90 }}">
                <article data-bd-tilt class="bd-process-card h-full relative p-6 rounded-2xl bg-slate-50 border border-slate-100 hover:bg-white hover:border-orange-500/30 hover:shadow-xl">
                    <span class="absolute right-5 top-4 text-5xl font-black text-slate-200/60">{{ str_pad($i+1,2,'0',STR_PAD_LEFT) }}</span>

                    <div class="bd-process-icon bd-depth-2">
                        @if($step['icon']==='upload')
                        <svg viewBox="0 0 24 24"><path d="M12 16V4M7 9l5-5 5 5M5 20h14"/></svg>
                        @elseif($step['icon']==='edit')
                        <svg viewBox="0 0 24 24"><path d="M4 20l4.5-1L19 8.5 15.5 5 5 15.5 4 20zM13.5 7l3.5 3.5"/></svg>
                        @elseif($step['icon']==='shield')
                        <svg viewBox="0 0 24 24"><path d="M12 3l7 3v5c0 5-3 8-7 10-4-2-7-5-7-10V6l7-3zM9 12l2 2 4-4"/></svg>
                        @else
                        <svg viewBox="0 0 24 24"><path d="M3 7l9-4 9 4-9 4-9-4zM3 7v10l9 4 9-4V7M12 11v10"/></svg>
                        @endif
                    </div>

                    <h3 class="relative text-slate-800 font-bold text-base mt-5 mb-2 bd-depth-2">{{ $step['title'] }}</h3>
                    <p class="relative text-xs text-slate-500 leading-relaxed bd-depth-1">{{ $step['desc'] }}</p>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.bd-process-card{min-height:215px;transform-style:preserve-3d}
.bd-process-icon{width:46px;height:46px;display:flex;align-items:center;justify-content:center;border-radius:13px;color:#EF5843;background:#FFF1E8}
.bd-process-icon svg{width:23px;height:23px;fill:none;stroke:currentColor;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
</style>