@extends('layouts.public')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fas fa-search me-2"></i>Hasil Carian untuk "{{ $search }}"</h4>
                <a href="{{ route('landing') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-home me-1"></i> Laman Utama
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($results->isEmpty())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Tiada rekod pusara ditemukan untuk "{{ $search }}"
                    
                    @if(Str::wordCount($search) > 1)
                        <div class="mt-2">
                            <p>Cuba carian alternatif:</p>
                            <ul class="list-unstyled">
                                @foreach(explode(' ', $search) as $term)
                                    @if(strlen($term) > 2)
                                        <li><a href="{{ route('search.pusara', ['search' => $term]) }}">Cari "{{ $term }}" sahaja</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    Ditemukan {{ $results->total() }} rekod untuk "{{ $search }}"
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>No. Pusara</th>
                                <th>Nama Si Mati</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Tarikh Dikebumikan</th>
                                <th>Kawasan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $grave)
                                @foreach($grave->bookings as $booking)
                                <tr>
                                    <td>{{ $grave->pusaraNo }}</td>
                                    <td>{{ $booking->nama_simati }}</td>
                                    <td>{{ $booking->no_mykad_simati }}</td>
                                    <td>{{ $booking->eventDate }}</td>
                                    <td>
                                        @if($grave->section == 'section_A')
                                            Pintu Masuk
                                        @elseif($grave->section == 'section_B')
                                            Tandas & Stor
                                        @else
                                            Pintu Belakang
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('pusara.show', $grave->id) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $results->appends(['search' => $search])->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection