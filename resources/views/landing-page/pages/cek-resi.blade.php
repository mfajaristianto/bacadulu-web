@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-24">
    <div class="max-w-xl mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-slate-900">Lacak Pengiriman (Cek Resi)</h1>
        <p class="text-slate-500 mt-2">Masukkan nomor resi pengiriman naskah/buku Anda.</p>
        <div class="mt-8 bg-white p-6 rounded-3xl border border-slate-200 shadow-md">
            <input type="text" placeholder="Masukkan Nomor Resi Anda..." class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:outline-none focus:border-orange-500 mb-4">
            <button class="w-full bg-[#f05a42] text-white py-3 rounded-xl font-bold hover:bg-[#d94f38] transition">Cek Sekarang</button>
        </div>
    </div>
</div>
@endsection