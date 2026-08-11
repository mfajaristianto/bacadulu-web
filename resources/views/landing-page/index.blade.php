@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen text-slate-700 overflow-x-hidden font-sans">

    @include('landing-page.sections.hero')

    @include('landing-page.sections.alur')
   
    @include('landing-page.sections.katalog')

    @include('landing-page.sections.kalkulator')

    @include('landing-page.sections.CTA home')
 
    @include('landing-page.sections.afiliasi')

</div>
@endsection