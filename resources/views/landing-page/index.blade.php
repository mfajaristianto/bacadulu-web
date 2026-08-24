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
[data-bd-reveal]{will-change:transform,opacity,filter}
[data-bd-tilt]{transform-style:preserve-3d;will-change:transform}
.bd-depth-1,.bd-depth-2{transform-style:preserve-3d}
.bd-section-glow{position:absolute;width:360px;height:360px;border-radius:50%;filter:blur(110px);opacity:.11;pointer-events:none;will-change:transform}

@media(prefers-reduced-motion:reduce){
    [data-bd-reveal]{opacity:1!important;filter:none!important;transform:none!important}
    [data-bd-tilt]{transform:none!important}
}
</style>
@endsection