@extends('layouts.navigation')

@section('content')
    <div class="container my-5">
        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="display-5 font-weight-bold">Detail Tempahan</h1>
            <p class="text-muted">Berikut adalah maklumat lengkap mengenai tempahan yang anda pilih.</p>
        </div>

        {{-- Display success or error messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Booking Details --}}
        <div class="card shadow-lg border-0">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Maklumat Tempahan </h5>
            </div>
            <div class="card-body">
                <div class="row gy-4">
                    {{-- Customer Info --}}
                    <div class="col-md-6">
                        <h6 class="text-primary">Detail Waris</h6>
                        <ul class="list-unstyled">
                            <li><strong>Nama:</strong> {{ $booking->customerName }}</li>
                            <li><strong>Email:</strong> {{ $booking->customerEmail }}</li>
                            <li><strong>No Telefon:</strong> {{ $booking->contactNumber }}</li>
                        </ul>
                    </div>

                    {{-- Booking Details --}}
                    <div class="col-md-6">
                        <h6 class="text-primary">Detail Si mati</h6>
                        <ul class="list-unstyled">
                            <li><strong>Nama Si Mati:</strong> {{ $booking->nama_simati }}</li>
                            <li><strong>No kad pengenalan si mati:</strong> {{ $booking->no_mykad_simati }}</li>
                        </ul>
                    </div>
                </div>

                <hr class="my-4">

                <div class="row gy-4">
                    {{-- Pax & Status --}}
                    <div class="col-md-6">
                        <h6 class="text-primary">Detail Tempahan</h6>
                        <ul class="list-unstyled">
                            <li><strong>No Pusara:</strong> {{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}</li>
                            <li><strong>Location:</strong> {{ $booking->eventLocation }}</li>
                            <li><strong>Tarikh:</strong> {{ $booking->eventDate }}</li>
                            <li><strong>Masa:</strong> {{ $booking->eventTime }}</li>
                            <li><strong>Lokasi:</strong> {{ $booking->eventLocation }}</li>
                            <li><strong>Status:</strong> 
                                @if ($booking->status === 'confirmed')
                                    <span class="badge bg-success">Reserved</span>
                                @elseif ($booking->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Cancelled</span>
                                @endif
                            </li>
                        </ul>
                    </div>

                    {{-- Notes --}}
                    <div class="col-md-6">
                        <h6 class="text-primary">Additional Notes</h6>
                        <p class="text-muted">
                            {{ $booking->notes ?: 'No additional notes provided.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Back Button --}}
        <div class="mt-4 text-center">
            <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" class="btn btn-outline-dark">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
@endsection
