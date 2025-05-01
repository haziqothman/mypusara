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
                                <input type="text" class="form-control rounded-start-pill" placeholder="Contoh: A001, B100" name="search" required>
                                <button class="btn btn-primary rounded-end-pill" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
