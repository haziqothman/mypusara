@extends('layouts.navigation')

@section('content')
    <div class="container my-5">
        <div class="position-relative">
            <h1 class="text-center mb-4">Tempahan Anda</h1>
            <a href="{{ route('customer.display.package') }}" class="position-absolute top-0 end-0 btn btn-primary">Buat Tempahan Baru</a>
        </div>

        {{-- Display success or error message if any --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Check if there are no bookings --}}
        @if(isset($message))
            <div class="alert alert-info text-center">
                {{ $message }}
            </div>
        @elseif($bookings->isNotEmpty())
            {{-- Display bookings in rows --}}
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                        <!-- <th>customerName</th>
                        <th>no_mykad</th>
                        <th>customerEmail</th>
                        <th>contactNumber</th> -->
                        <th>area</th>
                        <th>nama_simati</th>
                        <th>Ulasan</th>
                        <th>Tarikh</th>
                        <th>Masa</th>
                        <th>Lokasi</th>
                        <!-- <th>Status</th> -->
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                            <!-- <td>{{ $booking->customerName }}</td>
                            <td>{{ $booking->no_mykad }}</td>
                            <td>{{ $booking->customerEmail }}</td>
                            <td>{{ $booking->contactNumber }}</td> -->
                            <td>{{ $booking->area }}</td>
                            <td>{{ $booking->nama_simati }}</td>
                            <td>{{ $booking->notes ?? '-' }}</td>
                            <td>{{ $booking->eventDate }}</td>
                            <td>{{ $booking->eventTime }}</td>
                            <td>{{ $booking->eventLocation }}</td>
                                <td>
                                    @if($booking->status == 'confirmed')
                                        <span class="badge bg-success">Reserved</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                <div class="d-flex gap-2">
                                    <!-- View Button -->
                                    <a href="{{ route('ManageBooking.Customer.viewBooking', $booking->id) }}" 
                                    class="btn btn-primary btn-sm" 
                                    title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a href="{{ route('ManageBooking.Customer.editBooking', $booking->id) }}" 
                                    class="btn btn-warning btn-sm @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                    title="Edit"
                                    @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Cancel Button -->
                                    <a href="{{ route('customer.cancel.booking', $booking->id) }}" 
                                    class="btn btn-danger btn-sm @if($booking->status == 'confirmed' || $booking->status == 'cancelled') disabled @endif" 
                                    title="Cancel"
                                    onclick="return confirm('Are you sure you want to cancel this booking?')"
                                    @if($booking->status == 'confirmed' || $booking->status == 'cancelled') onclick="return false;" @endif>
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Add the custom CSS directly in this Blade file --}}
    <style>
        /* Disable the button functionality and appearance */
        .disabled-btn {
            pointer-events: none; /* Prevent the click event */
            opacity: 0.5; /* Make the button appear disabled */
            cursor: not-allowed; /* Change cursor to indicate that the button is disabled */
        }
    </style>
    {{-- Add the JavaScript to confirm cancel action --}}
    <script>
        function confirmCancel() {
            return confirm("Are you sure you want to cancel the booking?");
        }
    </script>
@endsection
