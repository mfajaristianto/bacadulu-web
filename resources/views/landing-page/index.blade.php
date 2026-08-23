@extends('layouts.app')

@section('content')
<div class="bd-home min-h-screen overflow-x-hidden bg-slate-50 text-slate-700 font-sans">
    @include('landing-page.sections.hero')
    @include('landing-page.sections.alur')
    @include('landing-page.sections.katalog')
    @include('landing-page.sections.kalkulator')
     @include('landing-page.sections.testimoni')
    @include('landing-page.sections.CTA home')
    @include('landing-page.sections.afiliasi')
</div>

<style>
.bd-home{--navy:#241B52;--orange:#EF5843;--gold:#F7AA35}
[data-bd-reveal]{opacity:0;filter:blur(3px);transition:opacity .7s ease,transform .7s cubic-bezier(.22,1,.36,1),filter .7s ease}
[data-bd-reveal="up"]{transform:translateY(38px)}
[data-bd-reveal="left"]{transform:translateX(-45px)}
[data-bd-reveal="right"]{transform:translateX(45px)}
[data-bd-reveal="zoom"]{transform:scale(.95)}
[data-bd-reveal].bd-visible{opacity:1;filter:none;transform:none}
[data-bd-tilt]{--rx:0deg;--ry:0deg;--lift:0px;transform:perspective(1000px) rotateX(var(--rx)) rotateY(var(--ry)) translateY(var(--lift));transform-style:preserve-3d;transition:transform .25s ease,box-shadow .25s ease;will-change:transform}
[data-bd-tilt]:hover{--lift:-5px}
.bd-depth-1{transform:translateZ(14px)}
.bd-depth-2{transform:translateZ(26px)}
.bd-section-glow{position:absolute;width:360px;height:360px;border-radius:50%;filter:blur(110px);opacity:.11;pointer-events:none}
@media(prefers-reduced-motion:reduce){
    [data-bd-reveal]{opacity:1!important;filter:none!important;transform:none!important;transition:none!important}
    [data-bd-tilt]{transform:none!important}
}
</style>

<script>
document.addEventListener('DOMContentLoaded',()=>{
    if(window.__bdFx)return;
    window.__bdFx=true;
    if(window.matchMedia('(prefers-reduced-motion:reduce)').matches)return;

    const observer=new IntersectionObserver(entries=>{
        entries.forEach(entry=>{
            if(entry.isIntersecting)entry.target.classList.add('bd-visible');
            else entry.target.classList.remove('bd-visible');
        });
    },{threshold:.12,rootMargin:'0px 0px -5% 0px'});

    document.querySelectorAll('[data-bd-reveal]').forEach(el=>{
        el.style.transitionDelay=`${Number(el.dataset.bdDelay||0)}ms`;
        observer.observe(el);
    });

    document.querySelectorAll('[data-bd-tilt]').forEach(card=>{
        card.addEventListener('pointermove',e=>{
            if(window.innerWidth<768)return;
            const r=card.getBoundingClientRect();
            const x=(e.clientX-r.left)/r.width;
            const y=(e.clientY-r.top)/r.height;
            card.style.setProperty('--rx',`${(0.5-y)*5}deg`);
            card.style.setProperty('--ry',`${(x-0.5)*7}deg`);
        });
        card.addEventListener('pointerleave',()=>{
            card.style.setProperty('--rx','0deg');
            card.style.setProperty('--ry','0deg');
        });
    });
});
</script>
@endsection