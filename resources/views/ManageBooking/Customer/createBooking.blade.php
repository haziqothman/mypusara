@extends('layouts.navigation')

@section('content')
<div class="container py-5">
    {{-- Notification Messages --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('destroy'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('destroy') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(!$package->isAvailable())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            Pusara ini tidak tersedia untuk tempahan.
        </div>
        <a href="{{ route('customer.display.package') }}" class="btn btn-primary">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Senarai Pusara
        </a>
        @return
    @endif

    {{-- Main content --}}
    <div class="card border-0 shadow-lg overflow-hidden">
        {{-- Header with gradient background --}}
        <div class="card-header bg-gradient-primary py-4">
            <div class="text-center text-white">
                <h1 class="h3 mb-1 fw-light">Tempahan Pusara</h1>
                <p class="mb-0 opacity-75">Isikan maklumat di bawah untuk tempahan pusara</p>
            </div>
        </div>

        {{-- Form --}}
        <div class="card-body p-5">
            <form method="POST" action="{{ url('customer/customer/' .$package->id. '/store-booking') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf
                <input type="hidden" name="packageId" value="{{ $package->id }}">

                {{-- Form sections --}}
                <div class="row g-4">
                    {{-- Waris Information --}}
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-3 h-100">
                            <h5 class="mb-4 text-primary">
                                <i class="fas fa-user-circle me-2"></i> Maklumat Waris
                            </h5>
                            
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Nama Waris</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                    <input type="text" id="customerName" name="customerName" class="form-control" 
                                           value="{{ old('customerName', $user->name) }}" placeholder="Ali bin Abu" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="no_mykad" class="form-label">No Kad Pengenalan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-id-card"></i></span>
                                    <input type="number" id="no_mykad" name="no_mykad" class="form-control" 
                                           value="{{ old('no_mykad', $user->no_mykad) }}" placeholder="0000000000" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="customerEmail" class="form-label">Alamat Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-envelope"></i></span>
                                    <input type="email" id="customerEmail" name="customerEmail" class="form-control" 
                                           value="{{ old('customerEmail', $user->email) }}" placeholder="xxxxxx@gmail.com" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contactNumber" class="form-label">Nombor Telefon</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-phone"></i></span>
                                    <input type="tel" id="contactNumber" name="contactNumber" class="form-control" 
                                           value="{{ old('contactNumber', $user->phone ?? '') }}" placeholder="+60123456789" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Si Mati Information --}}
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-3 h-100">
                            <h5 class="mb-4 text-primary">
                                <i class="fas fa-angel me-2"></i> Maklumat Si Mati
                            </h5>
                            
                            <div class="mb-3">
                                <label for="nama_simati" class="form-label">Nama Si Mati</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-user"></i></span>
                                    <input type="text" id="nama_simati" name="nama_simati" class="form-control" 
                                           placeholder="Ali bin Abu" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="no_mykad_simati" class="form-label">No Kad Pengenalan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-id-card"></i></span>
                                    <input type="text" id="no_mykad_simati" name="no_mykad_simati" class="form-control" 
                                           value="{{ old('no_mykad_simati') }}" placeholder="0000000000" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="no_sijil_kematian" class="form-label">No Sijil Kematian</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="as fa-award"></i></span>
                                    <input type="text" id="no_sijil_kematian" name="no_sijil_kematian" class="form-control" 
                                           value="{{ old('no_sijil_kematian') }}" placeholder="A1234567" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="eventLocation" class="form-label">Hospital Si Mati</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="fas fa-hospital"></i></span>
                                    <input type="text" id="eventLocation" name="eventLocation" class="form-control" 
                                           placeholder="Alamat penuh hospital" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pusara Details --}}
                    <div class="col-12">
                        <div class="bg-light p-4 rounded-3">
                            <h5 class="mb-4 text-primary">
                                <i class="fas fa-monument me-2"></i> Maklumat Pusara
                            </h5>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="pusaraNo" class="form-label">Nombor Lot Pusara</label>
                                    <input type="text" name="pusaraNo" id="pusaraNo" class="form-control bg-white" 
                                           value="{{$package->pusaraNo}}" readonly>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="area" class="form-label">Area</label>
                                    <input type="text" name="area" id="area" class="form-control bg-white" 
                                           value="{{$package->section}}" readonly>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="eventDate" class="form-label">Tarikh</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-calendar-day"></i></span>
                                        <input type="date" id="eventDate" name="eventDate" class="form-control" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="eventTime" class="form-label">Masa</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-white"><i class="fas fa-clock"></i></span>
                                        <input type="time" id="eventTime" name="eventTime" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <label for="packageDesc" class="form-label">Keterangan Pusara</label>
                                <textarea name="packageDesc" id="packageDesc" rows="3" class="form-control bg-white" readonly>{{$package->packageDesc}}</textarea>
                            </div>
                            
                            <div class="mt-3">
                                <label for="notes" class="form-label">Nota Tambahan</label>
                                <textarea id="notes" name="notes" rows="2" class="form-control" 
                                          placeholder="Sila nyatakan sebarang keperluan khas atau nota tambahan"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Form actions --}}
                <div class="d-flex justify-content-between mt-5">
                    <a href="{{ route('customer.display.package') }}" 
                       class="btn btn-outline-danger px-4 py-2"
                       onclick="return confirm('Adakah anda pasti ingin membatalkan tempahan ini?')">
                        <i class="fas fa-times me-2"></i> Batalkan
                    </a>
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        <i class="fas fa-paper-plane me-2"></i> Hantar Tempahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Include Flatpickr CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Malay localization -->
    <script src="https://npmcdn.com/flatpickr/dist/l10n/ms.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Check if the package is available when page loads
            const packageStatus = "{{ $package->isAvailable() ? 'available' : 'unavailable' }}";
            
            if(packageStatus === 'unavailable') {
                document.querySelector('form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    alert('This grave is no longer available for booking');
                    return false;
                });
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Example of unavailable dates (replace with dynamic data from your backend)
            const unavailableDates = ['2024-12-25', '2024-12-31', '2025-01-01'];

            // Initialize Flatpickr for the date
            flatpickr("#eventDate", {
                dateFormat: "Y-m-d",
                disable: unavailableDates,
                minDate: "today",
                locale: "ms", // Malay localization
                onChange: function(selectedDates, dateStr, instance) {
                    if (unavailableDates.includes(dateStr)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Tarikh Tidak Tersedia',
                            text: 'Tarikh yang dipilih telah penuh. Sila pilih tarikh lain.',
                        });
                        instance.clear();
                    }
                }
            });

            // Initialize Flatpickr for the time
            flatpickr("#eventTime", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 15,
                locale: "ms"
            });

            // Form validation
            (function () {
                'use strict'
                var forms = document.querySelectorAll('.needs-validation')
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })();
        });
    </script>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
        }
        
        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }
        
        .card-header {
            border-bottom: none;
        }
        
        .form-control, .form-select {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
            border-color: #4e73df;
        }
        
        .input-group-text {
            border-radius: 0.5rem 0 0 0.5rem;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
            transform: translateY(-2px);
        }
        
        .btn-outline-danger {
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        
        .btn-outline-danger:hover {
            transform: translateY(-2px);
        }
        
        .invalid-feedback {
            font-size: 0.85rem;
        }
        
        .was-validated .form-control:invalid, 
        .was-validated .form-control:invalid:focus {
            border-color: #e74a3b;
            box-shadow: 0 0 0 0.25rem rgba(231, 74, 59, 0.25);
        }
        
        .was-validated .form-control:valid, 
        .was-validated .form-control:valid:focus {
            border-color: #1cc88a;
            box-shadow: 0 0 0 0.25rem rgba(28, 200, 138, 0.25);
        }
    </style>
@endsection