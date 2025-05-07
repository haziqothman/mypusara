@extends('layouts.navigation')

@section('content')
<div class="container-fluid py-5">
    {{-- Page Header --}}
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Pengurusan Tempahan Pusara</h1>
        <p class="lead text-muted">Urus dan pantau semua tempahan pusara</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i> 
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Filter Section --}}
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.bookings.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="status" class="form-label fw-semibold">Status Tempahan:</label>
                        <select name="status" id="status" class="form-select">
                            <option value="" {{ !$selectedStatus ? 'selected' : '' }}>Semua Status</option>
                            <option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="confirmed" {{ $selectedStatus == 'confirmed' ? 'selected' : '' }}>Disahkan</option>
                            <option value="cancelled" {{ $selectedStatus == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter me-2"></i> Tapis
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    {{-- Bookings Table --}}
    <div class="card shadow-lg border-0 overflow-hidden">
        @if ($bookings->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th class="ps-4">#</th>
                            <th>Nama Waris</th>
                            <th>Nama Si mati</th>
                            <th>Tarikh Kematian</th>
                            <th>Lokasi Kematian</th>
                            <th>No. Pusara</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $index => $booking)
                            <tr class="align-middle">
                                <td class="ps-4 fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-light-primary rounded-circle me-3">
                                            <span class="avatar-text">{{ substr($booking->customerName, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $booking->customerName }}</h6>
                                            <small class="text-muted">{{ $booking->no_mykad }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $booking->nama_simati }}</td> 
                                <td>{{ \Carbon\Carbon::parse($booking->eventDate)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($booking->eventLocation, 20) }}</td>
                                <td>
                                    <span class="badge bg-light-primary text-primary">
                                        {{ $booking->package ? $booking->package->pusaraNo : 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    @if ($booking->status == 'confirmed')
                                        <span class="badge bg-success rounded-pill py-2 px-3">
                                            <i class="fas fa-check-circle me-1"></i> Disahkan
                                        </span>
                                    @elseif ($booking->status == 'pending')
                                        <span class="badge bg-warning rounded-pill py-2 px-3">
                                            <i class="fas fa-clock me-1"></i> Dalam Proses
                                        </span>
                                    @else
                                        <span class="badge bg-danger rounded-pill py-2 px-3">
                                            <i class="fas fa-times-circle me-1"></i> Dibatalkan
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- View Button -->
                                        <a href="{{ route('ManageBooking.Admin.viewBooking', ['id' => $booking->id]) }}" 
                                           class="btn btn-sm btn-light-primary" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('ManageBooking.Admin.editBooking', ['id' => $booking->id]) }}" 
                                           class="btn btn-sm btn-light-warning @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Kemaskini"
                                           @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Cancel Button -->
                                        <a href="{{ route('admin.bookings.cancel', ['id' => $booking->id]) }}" 
                                           class="btn btn-sm btn-light-danger @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                           data-bs-toggle="tooltip" data-bs-placement="top" title="Batal"
                                           onclick="return confirm('Adakah anda pasti ingin membatalkan tempahan ini?')"
                                           @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                            <i class="fas fa-times"></i>
                                        </a>

                                        <!-- Approve Button -->
                                        @if ($booking->status == 'pending')
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#approveConfirmationModal{{ $booking->id }}"
                                                    data-bs-placement="top" 
                                                    title="Sahkan Tempahan">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-light-secondary" disabled data-bs-toggle="tooltip" data-bs-placement="top" title="Telah Disahkan">
                                                <i class="fas fa-check-double"></i>
                                            </button>
                                        @endif

                                        <!-- Notify Button -->
                                        <button type="button" 
                                            class="btn btn-sm {{ $booking->status == 'pending' ? 'btn-success' : 'btn-danger' }}" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#graveDiggerModal{{ $booking->id }}"
                                            data-bs-placement="top" 
                                            title="Hantar Notifikasi Kepada Penggali Pusara"
                                            @if($booking->status != 'pending') disabled @endif>
                                            <i class="fas fa-envelope me-1"></i> Maklumkan
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Grave Digger Notification Modal -->
                            <div class="modal fade" id="graveDiggerModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Hantar Notifikasi Penggali Pusara</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="{{ route('admin.bookings.notify_grave_digger', $booking->id) }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <label class="form-label fw-semibold text-primary mb-2">
                                                        <i class="fas fa-phone-alt me-2"></i> Nombor Telefon Penggali
                                                    </label>
                                                    <div class="input-group">
                                                        <span class="input-group-text bg-light-primary border-primary">
                                                            <i class="fas fa-mobile-alt text-primary"></i>
                                                        </span>
                                                        <input type="tel" 
                                                            name="grave_digger_phone" 
                                                            class="form-control border-primary py-2" 
                                                            value="{{ old('grave_digger_phone', '+601137490379') }}" 
                                                            required
                                                            pattern="^\+?6?01[0-9]{8,9}$"
                                                            placeholder="+60123456789">
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fas fa-info-circle me-1"></i> Format: +60123456789 atau 0123456789
                                                    </small>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label fw-semibold text-primary mb-2">
                                                        <i class="fas fa-envelope me-2"></i> Mesej
                                                    </label>
                                                    <div class="card border-primary">
                                                        <div class="card-header bg-light-primary py-2">
                                                            <small class="text-primary fw-semibold">
                                                                <i class="fab fa-whatsapp me-1"></i> Template Pesanan
                                                            </small>
                                                        </div>
                                                        <textarea name="message" 
                                                        class="form-control border-0 shadow-none" 
                                                        rows="8"
                                                        style="resize: none; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;"
                                                        required>
*PERMINTAAN GALI PUSARA*

📌 *No. Tempahan:* #{{ $booking->id }}
⚰️ *No. Pusara:* {{ $booking->package->pusaraNo ?? 'N/A' }}
📍 *Kawasan:* {{ $booking->area }}

*MAKLUMAT SI MATI:*
👤 *Nama:* {{ $booking->nama_simati }}
🆔 *No. KP:* {{ $booking->no_mykad_simati }}

*TARIKH & MASA:*
📅 {{ \Carbon\Carbon::parse($booking->eventDate)->format('d/m/Y') }} 
⏰ {{ $booking->eventTime }}

Sila siapkan penggalian sebelum tarikh tersebut. 
Terima Kasih.
                                                        </textarea>
                                                    </div>
                                                    <small class="text-muted mt-1 d-block">
                                                        <i class="fas fa-lightbulb me-1"></i> Gunakan emoji (📌⚰️📍👤🆔📅⏰) untuk penekanan
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fab fa-whatsapp me-2"></i> Hantar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Approve Confirmation Modal -->
                            @if ($booking->status == 'pending')
                                <div class="modal fade" id="approveConfirmationModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title">
                                                    <i class="fas fa-check-circle me-2"></i> Sahkan Tempahan
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="POST" action="{{ route('admin.bookings.approve', ['id' => $booking->id]) }}">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        <strong>Pengesahan Diperlukan</strong>
                                                    </div>
                                                    
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="confirmBurial{{ $booking->id }}" required>
                                                        <label class="form-check-label" for="confirmBurial{{ $booking->id }}">
                                                            Saya mengesahkan jenazah telah dikebumikan
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i> Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="fas fa-check me-1"></i> Sahkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="avatar avatar-xl bg-light-primary rounded-circle mb-3">
                    <i class="fas fa-calendar-times fa-2x text-primary"></i>
                </div>
                <h5 class="fw-semibold">Tiada Rekod Tempahan Ditemui</h5>
                <p class="text-muted">Tiada tempahan yang sepadan dengan kriteria tapisan anda</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection

@section('styles')
<style>
    .avatar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
    }
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }
    .avatar-xl {
        width: 80px;
        height: 80px;
        font-size: 1.5rem;
    }
    .avatar-text {
        color: inherit;
    }
    .bg-light-primary {
        background-color: rgba(78, 115, 223, 0.1);
    }
    .bg-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    .bg-light-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }
    .bg-light-secondary {
        background-color: rgba(108, 117, 125, 0.1);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(78, 115, 223, 0.05);
    }
    .card {
        border-radius: 0.75rem;
    }
    .btn-light-primary {
        background-color: rgba(78, 115, 223, 0.1);
        color: #4e73df;
    }
    .btn-light-primary:hover {
        background-color: rgba(78, 115, 223, 0.2);
    }
    .btn-light-warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    .btn-light-warning:hover {
        background-color: rgba(255, 193, 7, 0.2);
    }
    .btn-light-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .btn-light-danger:hover {
        background-color: rgba(220, 53, 69, 0.2);
    }
    .btn-light-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    .btn-light-success {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    .btn-light-success:hover {
        background-color: rgba(40, 167, 69, 0.2);
    }
    
    @keyframes dig {
        0% { transform: rotate(0deg); }
        25% { transform: rotate(15deg); }
        50% { transform: rotate(0deg); }
        75% { transform: rotate(-15deg); }
        100% { transform: rotate(0deg); }
    }
    .fa-shovel {
        animation: dig 2s infinite;
    }

    .modal-confirmation-icon {
        font-size: 4rem;
        color: var(--bs-success);
    }

    .approval-checklist {
        border-left: 3px solid var(--bs-warning);
        padding-left: 1rem;
    }

    .form-check-input:checked {
        background-color: var(--bs-success);
        border-color: var(--bs-success);
    }

    .modal {
        z-index: 1060 !important;
    }
</style>
@endsection