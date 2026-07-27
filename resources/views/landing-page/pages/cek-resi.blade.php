@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center mb-5">
            <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider">Lacak Buku &amp; Pengiriman</span>
            <h1 class="fw-bold display-5 mt-3 text-dark">Cek Resi &amp; Progres Buku</h1>
            <p class="text-muted lead">Pantau status pendaftaran HKI, proses cetak, hingga posisi kurir secara real-time.</p>
        </div>
    </div>

    <!-- Form Input Resi -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 rounded-4">
                <form action="{{ route('cek-resi.track') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="resi_number" class="form-label fw-bold text-dark">Masukkan Nomor Resi / Kode Booking</label>
                        <input type="text" class="form-control form-control-lg @error('resi_number') is-invalid @enderror" id="resi_number" name="resi_number" value="{{ old('resi_number', $resiInput ?? '') }}" placeholder="Contoh: BCD-2026-00123" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">Lacak Resi &rarr;</button>
                </form>

                <!-- Pesan Error jika Resi Tidak Ditemukan -->
                @if(session('error'))
                    <div class="alert alert-danger mt-3 mb-0 text-center small">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Hasil Pelacakan (Muncul Jika Resi Ditemukan) -->
    @if(isset($shipment))
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white border-start border-primary border-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold text-dark mb-0">Hasil Pelacakan Resi</h4>
                    <span class="badge bg-primary px-3 py-2 fs-6">{{ $shipment->resi_number }}</span>
                </div>
                <hr>
                
                <div class="row mb-3">
                    <div class="col-sm-6 mb-2 mb-sm-0">
                        <p class="text-muted small mb-1">Judul Buku &amp; Naskah:</p>
                        <h6 class="fw-bold text-dark">{{ $shipment->book_title }}</h6>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1">Opsi Pengambilan:</p>
                        <h6 class="fw-bold text-dark text-uppercase">
                            {{ $shipment->delivery_type == 'pickup' ? 'Ambil di Tempat (Self Pickup)' : 'Diantar Kurir (Delivery)' }}
                        </h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mb-2 mb-sm-0">
                        <p class="text-muted small mb-1">Status Produksi &amp; HKI:</p>
                        <span class="badge bg-info text-dark p-2 text-uppercase fw-bold">
                            {{ str_replace('_', ' ', $shipment->production_status) }}
                        </span>
                    </div>
                    <div class="col-sm-6">
                        <p class="text-muted small mb-1">Status Pengiriman:</p>
                        <span class="badge bg-success p-2 text-uppercase fw-bold">
                            {{ $shipment->delivery_status }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection