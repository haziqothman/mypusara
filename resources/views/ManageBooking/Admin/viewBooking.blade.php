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

        {{-- Action Buttons --}}
        <div class="d-flex justify-content-between align-items-center mt-4">
            {{-- Back Button --}}
            <a href="{{ route('admin.bookings.index') }}" 
               class="btn btn-outline-primary btn-lg px-4 py-2 rounded-pill">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            
            {{-- Delete Button --}}
            <button type="button" 
                    class="btn btn-danger btn-lg px-4 py-2 rounded-pill shadow-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#deleteBookingModal">
                <i class="fas fa-trash-alt me-2"></i> Padam Tempahan
            </button>  
        </div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteBookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i> Sahkan Penghapusan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.bookings.destroy', $booking->id) }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Amaran!</strong> Tindakan ini tidak boleh diundur.
                    </div>
                    <p>Adakah anda pasti ingin memadam tempahan ini secara kekal?</p>
                    <ul class="list-unstyled">
                        <li><strong>No. Tempahan:</strong> #{{ $booking->id }}</li>
                        <li><strong>Nama Waris:</strong> {{ $booking->customerName }}</li>
                        <li><strong>Nama Si Mati:</strong> {{ $booking->nama_simati }}</li>
                    </ul>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" id="confirmDelete" required>
                        <label class="form-check-label" for="confirmDelete">
                            Saya memahami bahawa data akan dihapuskan secara kekal
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-1"></i> Sahkan Penghapusan
                    </button>
                

                </div>
            </form>
        </div>
    </div>
</div>
    </div>
@endsection

<script>
function confirmDelete() {
    if (confirm('Are you sure you want to delete this booking?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>