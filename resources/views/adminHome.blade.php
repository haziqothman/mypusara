@extends('layouts.navigation')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 mt-5">

            <!-- Greeting -->
            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">Hi, {{ Auth::user()->name }}!</h2>
                <p class="text-muted">Selamat datang ke Mypusara - Sistem Pengurusan Pusara Anda</p>
            </div>

            <!-- Dashboard Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-gradient bg-primary text-white rounded-top-4">
                    <h4 class="mb-0">Dashboard</h4>
                </div>

                <div class="card-body p-5">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Search Section -->
                    <div class="text-center mb-5">
                        <h4 class="fw-semibold">Carian Pusara</h4>
                        <p class="text-muted">Cari dan temui lokasi pengebumian orang tersayang dengan mudah.</p>
                    </div>

                    <div class="d-flex justify-content-center">
                        <form action="{{ route('search.pusara') }}" method="GET" class="w-75">
                            <div class="input-group shadow-sm">
                                <input type="text" 
                                       class="form-control rounded-start-pill" 
                                       placeholder="Contoh: A001, B100" 
                                       name="search" 
                                       required
                                       value="{{ request('search') }}">
                                <button class="btn btn-primary rounded-end-pill px-4" type="submit">
                                    <i class="fas fa-search me-2"></i> Cari
                                </button>
                            </div>
                            <div class="mt-3 text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="allStatus" value="all" checked>
                                    <label class="form-check-label" for="allStatus">Semua Status</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="bookedStatus" value="booked">
                                    <label class="form-check-label" for="bookedStatus">Tempahan Sahaja</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="buriedStatus" value="buried">
                                    <label class="form-check-label" for="buriedStatus">Telah Dikebumikan</label>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Search Results Section -->
                    @if(isset($results))
                    <div class="mt-5">
                        <h5 class="fw-semibold mb-4">Hasil Carian</h5>
                        
                        @if($results->isEmpty())
                            <div class="alert alert-info">
                                Tiada rekod pusara ditemui.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No. Pusara</th>
                                            <th>Nama Si Mati</th>
                                            <th>Status</th>
                                            <th>Tarikh</th>
                                            <th>Tindakan</th>
                                        </tr>
                                    </thead>
                                    <div class="row gy-4">
  <!-- Inside your card-body, after the search section -->
@if(isset($bookings) && $bookings->count())
<div class="mt-5">
    <h5 class="fw-semibold mb-4">Senarai Tempahan Terkini</h5>
    <div class="table-responsive">
        <!-- In your search results table -->
<table class="table table-hover">
    <thead class="table-light">
        <tr>
            <th>No. Pusara</th>
            <th>Nama Si Mati</th>
            <th>No. MyKad</th>
            <th>Status</th>
            <th>Tarikh</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($results as $booking)
        <tr>
            <td>
                @isset($booking->package)
                    {{ $booking->package->pusaraNo }}
                @else
                    N/A
                @endisset
            </td>
            <td>{{ $booking->nama_simati }}</td>
            <td>{{ $booking->no_mykad_simati }}</td>
            <td>
                @if ($booking->status === 'confirmed')
                    <span class="badge bg-success">Confirmed</span>
                @elseif ($booking->status === 'pending')
                    <span class="badge bg-warning">Pending</span>
                @else
                    <span class="badge bg-danger">Cancelled</span>
                @endif
            </td>
            <td>{{ $booking->eventDate }}</td>
            <td>
                <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye"></i> Lihat
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    </div>
</div>
@endif
                                </table>
                            </div>
                        @endif
                    </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .rounded-4 {
        border-radius: 1rem !important;
    }
    .rounded-top-4 {
        border-top-left-radius: 1rem !important;
        border-top-right-radius: 1rem !important;
    }
    .bg-gradient {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    }
    .form-control:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
</style>
@endsection