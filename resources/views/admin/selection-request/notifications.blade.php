<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head as other admin pages -->
</head>
<body>
    <!-- Same navbar as other admin pages -->

    <div class="container-fluid py-4">
        <div class="card shadow">
            <div class="card-header bg-white border-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Notifikasi</h3>
                    <form method="POST" action="{{ route('admin.notifications.markAllRead') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                            Tandai Semua Telah Dibaca
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="list-group">
                    @forelse(auth()->user()->notifications as $notification)
                    <a href="{{ $notification->data['link'] }}" 
                       class="list-group-item list-group-item-action {{ $notification->read() ? '' : 'list-group-item-primary' }}">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ $notification->data['message'] }}</h5>
                            <small>{{ $notification->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">Pelanggan: {{ $notification->data['customer_name'] }}</p>
                        <small>Klik untuk lihat permohonan</small>
                    </a>
                    @empty
                    <div class="text-center py-4">Tiada notifikasi</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Same footer as other admin pages -->
</body>
</html>