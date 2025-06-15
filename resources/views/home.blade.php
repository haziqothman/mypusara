@extends('layouts.navigation')

@section('content')
<div class="container-fluid px-4">
    <!-- Welcome Header -->
    <div class="d-flex justify-content-between align-items-center mt-4 mb-5">
        <div>
            <h2 class="fw-bold text-gradient-primary mb-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
            <p class="text-muted mb-0">Gambaran keseluruhan tempahan pusara anda</p>
        </div>
        <div class="avatar avatar-lg bg-primary text-white rounded-circle">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </div>

    <!-- Booking Stats Cards -->
    <div class="row mb-4">
        <!-- Total Bookings -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">Jumlah Tempahan</h6>
                            <h2 class="mb-0">{{ $bookings->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-white-10 rounded-circle p-3">
                            <i class="fas fa-calendar-check fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pending Bookings -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2"> Dalam Proses</h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'pending')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-white-10 rounded-circle p-3">
                            <i class="fas fa-clock fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancelled Bookings -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-gradient-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">Telah Dibatalkan</h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'cancelled')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-white-10 rounded-circle p-3">
                            <i class="fas fa-times-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Completed Bookings -->
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm rounded-3 h-100 bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase text-white-50 mb-2">Tempahan Selesai</h6>
                            <h2 class="mb-0">{{ $bookings->where('status', 'confirmed')->count() }}</h2>
                        </div>
                        <div class="icon-shape bg-white-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fs-4"></i>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
            <div class="card-header bg-white border-bottom-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Tempahan Terkini Anda</h5>
                    <a href="{{ route('ManageBooking.Customer.dashboardBooking') }}" class="btn btn-sm btn-outline-primary rounded-pill">
                        Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($bookings->take(3) as $booking)
                    <div class="list-group-item border-0 py-3">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar avatar-lg bg-light-{{ $booking->status_color }} rounded-circle">
                                    <i class="fas fa-monument text-{{ $booking->status_color }}"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $booking->nama_simati }}</h6>
                                    <span class="badge bg-{{ $booking->status_color }} bg-opacity-10 text-{{ $booking->status_color }}">
                                        @if($booking->status == 'confirmed')
                                            Disahkan
                                        @elseif($booking->status == 'pending')
                                            Dalam Proses
                                        @else
                                            Dibatalkan
                                        @endif
                                    </span>
                                </div>
                                <p class="text-muted mb-0">
                                    No. Pusara: {{ $booking->package->pusaraNo ?? 'N/A' }} • 
                                    Tarikh: {{ \Carbon\Carbon::parse($booking->eventDate)->format('d M Y') }} • 
                                    Lokasi: {{ $booking->eventLocation }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="list-group-item border-0 py-4 text-center">
                        <i class="fas fa-calendar-times fa-2x text-muted mb-3"></i>
                        <p class="text-muted">Tiada rekod tempahan ditemui</p>
                        <a href="{{ route('customer.display.package') }}" class="btn btn-primary rounded-pill">
                            <i class="fas fa-plus me-2"></i> Buat Tempahan Baru
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Bantuan & Sokongan Section -->
        <div class="row mb-4">
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-question-circle text-primary me-2"></i> 
                            Pusat Bantuan
                        </h5>
                        <p class="card-text text-muted">Hubungi kami jika anda mempunyai sebarang pertanyaan</p>
                        <div class="d-grid gap-2">
                            <a href="https://wa.me/601137490379" target="_blank" class="btn btn-success rounded-pill">
                                <i class="fab fa-whatsapp me-2"></i> WhatsApp Kami
                            </a>
                          <a href="https://mail.google.com/mail/?view=cm&fs=1&to=haziq.othman99@gmail.com&su=Pertanyaan Tempahan Pusara&body=Sila nyatakan pertanyaan anda..." 
                            target="_blank"
                            class="btn btn-outline-primary rounded-pill">
                            <i class="fas fa-envelope me-2"></i> Hantar Emel melalui Gmail
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Center -->
            <div class="col-md-6 mb-3">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-book-open text-primary me-2"></i> 
                            Panduan Penjagaan Pusara
                        </h5>
                        <p class="card-text text-muted">Ikuti panduan ini untuk memastikan pusara kekal bersih dan terjaga</p>
                        <div class="d-grid gap-2">
                            <a href="#" class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#documentModal">
                                <i class="fas fa-eye me-2"></i> Lihat Panduan
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#doaModal">
                                <i class="fas fa-pray me-2"></i> Bacaan Doa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panduan Penjagaan Pusara Modal -->
        <div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-book-reader me-2"></i> 
                            Panduan Penjagaan Pusara
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h6>Langkah-Langkah Penjagaan:</h6>
                        <ul>
                            <li>Bersihkan kawasan pusara secara berkala daripada daun dan sampah.</li>
                            <li>Gunakan air dan sabun lembut untuk mencuci batu nisan.</li>
                            <li>Jangan gunakan bahan kimia kuat yang boleh merosakkan batu nisan.</li>
                            <li>Pastikan rumput atau tumbuhan liar dibersihkan.</li>
                            <li>Elakkan meletakkan barang-barang hiasan yang mudah reput atau mencemarkan kawasan pusara.</li>
                            <li>Hormati kawasan sekitar dan elakkan bunyi bising atau gangguan.</li>
                        </ul>
                        <p class="mt-3 text-muted"><i class="fas fa-info-circle me-1"></i> Penjagaan yang baik mencerminkan penghormatan kepada yang telah tiada.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        

        <!-- Bacaan Doa Modal -->
        <div class="modal fade" id="doaModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-praying-hands me-2"></i> 
                            Bacaan Doa untuk Keluarga Si Mati
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="text-primary">Doa Ketika Ziarah Kubur</h6>
                            <div class="arabic-text text-end mb-2" style="font-size: 1.2rem; line-height: 2;">
                                اَلسَّلَامُ عَلَيْكُمْ يَا أَهْلَ الدِّيَارِ مِنَ الْمُؤْمِنِينَ وَالْمُسْلِمِينَ، وَإِنَّا إِنْ شَاءَ اللَّهُ بِكُمْ لَاحِقُونَ، نَسْأَلُ اللَّهَ لَنَا وَلَكُمُ الْعَافِيَةَ
                            </div>
                            <p class="text-muted">
                                <strong>Maksud:</strong> "Salam sejahtera ke atas kamu wahai penghuni kubur dari kalangan orang-orang mukmin dan muslim. Sesungguhnya kami insya Allah akan menyusul kamu. Kami memohon kepada Allah kesejahteraan untuk kami dan kamu."
                            </p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-primary">Doa untuk Si Mati</h6>
                            <div class="arabic-text text-end mb-2" style="font-size: 1.2rem; line-height: 2;">
                                اللَّهُمَّ اغْفِرْ لَهُ وَارْحَمْهُ وَعَافِهِ وَاعْفُ عَنْهُ، وَأَكْرِمْ نُزُلَهُ، وَوَسِّعْ مَدْخَلَهُ، وَاغْسِلْهُ بِالْمَاءِ وَالثَّلْجِ وَالْبَرَدِ، وَنَقِّهِ مِنَ الْخَطَايَا كَمَا يُنَقَّى الثَّوْبُ الأَبْيَضُ مِنَ الدَّنَسِ، وَأَبْدِلْهُ دَارًا خَيْرًا مِنْ دَارِهِ، وَأَهْلاً خَيْرًا مِنْ أَهْلِهِ، وَزَوْجًا خَيْرًا مِنْ زَوْجِهِ، وَأَدْخِلْهُ الجَنَّةَ، وَأَعِذْهُ مِنْ عَذَابِ القَبْرِ وَعَذَابِ النَّارِ
                            </div>
                            <p class="text-muted">
                                <strong>Maksud:</strong> "Ya Allah, ampunilah dia, berilah rahmat kepadanya, selamatkanlah dia (dari segala yang menyusahkan), maafkanlah dia dan tempatkanlah dia di tempat yang mulia (Syurga), luaskan kuburnya, mandikanlah dia dengan air salji dan air es. Bersihkanlah dia dari segala kesalahan sebagaimana bersihnya pakaian putih dari kotoran. Berilah dia rumah yang lebih baik dari rumahnya (di dunia), keluarga yang lebih baik dari keluarganya (di dunia), pasangan yang lebih baik dari pasangannya (di dunia). Masukkanlah dia ke Syurga, jagalah dia dari siksa kubur dan siksa Neraka."
                            </p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-primary">Doa untuk Keluarga yang Berduka</h6>
                            <div class="arabic-text text-end mb-2" style="font-size: 1.2rem; line-height: 2;">
                                إِنَّا لِلَّهِ وَإِنَّا إِلَيْهِ رَاجِعُونَ، اللَّهُمَّ أْجُرْنِي فِي مُصِيبَتِي، وَاخْلُفْ لِي خَيْرًا مِنْهَا
                            </div>
                            <p class="text-muted">
                                <strong>Maksud:</strong> "Sesungguhnya kami adalah milik Allah dan kepada-Nya kami kembali. Ya Allah, berilah pahala kepadaku dalam musibahku ini dan gantikanlah untukku dengan yang lebih baik daripadanya."
                            </p>
                        </div>

                        <p class="mt-3 text-muted"><i class="fas fa-info-circle me-1"></i> Amalkan doa-doa ini untuk mendoakan kesejahteraan si mati dan ketenangan keluarga yang ditinggalkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .text-gradient-primary {
                background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
            
            .bg-gradient-primary {
                background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
            }
            
            .bg-gradient-info {
                background: linear-gradient(90deg, #36b9cc 0%, #258391 100%);
            }
            
            .bg-gradient-success {
                background: linear-gradient(90deg, #1cc88a 0%, #13855c 100%);
            }

            .bg-gradient-warning {
                background: linear-gradient(90deg, #f6c23e 0%, #dda20a 100%);
            }

            .bg-gradient-danger {
                background: linear-gradient(90deg, #e74a3b 0%, #be2617 100%);
            }
            
            .bg-white-10 {
                background-color: rgba(255, 255, 255, 0.1);
            }
            
            .avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            
            .avatar-lg {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
            
            .rounded-3 {
                border-radius: 0.75rem !important;
            }
            
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1) !important;
            }
            
            .bg-light-primary { background-color: rgba(78, 115, 223, 0.1); }
            .bg-light-info { background-color: rgba(54, 185, 204, 0.1); }
            .bg-light-success { background-color: rgba(28, 200, 138, 0.1); }
            .bg-light-warning { background-color: rgba(246, 194, 62, 0.1); }
            .bg-light-danger { background-color: rgba(231, 74, 59, 0.1); }
            
            .text-primary { color: #4e73df !important; }
            .text-info { color: #36b9cc !important; }
            .text-success { color: #1cc88a !important; }
            .text-warning { color: #f6c23e !important; }
            .text-danger { color: #e74a3b !important; }
            
            .list-group-item-action:hover {
                background-color: rgba(78, 115, 223, 0.05);
            }

            .arabic-text {
                font-family: 'Traditional Arabic', 'Arial', sans-serif;
                direction: rtl;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
                
                // Initialize modals
                var documentModal = new bootstrap.Modal(document.getElementById('documentModal'));
                var doaModal = new bootstrap.Modal(document.getElementById('doaModal'));
            });
        </script>
@endsection