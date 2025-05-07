@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card border-0 shadow-lg glass-effect">
                <div class="card-header bg-gradient-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-search me-2"></i>Cari Pusara</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('graves.search') }}" method="GET">
                        <div class="input-group mb-4">
                            <input type="text" name="search" class="form-control form-control-lg" 
                                   placeholder="Cari dengan No. Pusara, Nama Si Mati atau No. Kad Pengenalan..." 
                                   value="{{ request('search') }}" required>
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </div>
                    </form>

                    @if(request()->has('search'))
                        <div class="search-results">
                            <h5 class="mb-4 text-primary">
                                <i class="fas fa-filter me-2"></i>Hasil Carian untuk "{{ request('search') }}"
                            </h5>

                            @if($graves->isEmpty())
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>Tiada rekod pusara ditemukan.
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>No. Pusara</th>
                                                <th>Nama Si Mati</th>
                                                <th>No. Kad Pengenalan</th>
                                                <th>Status</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($graves as $grave)
                                                <tr>
                                                    <td>{{ $grave->pusaraNo }}</td>
                                                    <td>{{ $grave->bookings->first()->nama_simati ?? 'N/A' }}</td>
                                                    <td>{{ $grave->bookings->first()->no_mykad_simati ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-success bg-opacity-10 text-success">
                                                            <i class="fas fa-check-circle me-1"></i> Disahkan
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('graves.show', $grave->id) }}" 
                                                           class="btn btn-sm btn-outline-primary">
                                                            <i class="fas fa-eye me-1"></i> Lihat Butiran
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="d-flex justify-content-center mt-4">
                                    {{ $graves->appends(['search' => request('search')])->links() }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-search fa-4x text-muted opacity-25"></i>
                            </div>
                            <h5 class="text-muted">Masukkan maklumat carian anda</h5>
                            <p class="text-muted">Cari dengan No. Pusara, Nama Si Mati atau No. Kad Pengenalan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection