@extends('layouts.navigation')

@section('content')
<div class="container">
    <h1>Feedback List</h1>
    <a href="{{ route('customer.feedback.create') }}" class="btn btn-primary mb-3">Add Feedback</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Feedback</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($feedbacks as $feedback)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $feedback->name }}</td>
                    <td>{{ $feedback->message }}</td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">View</a>
                        {{-- Tambahkan tombol edit/delete jika diperlukan, khusus untuk admin --}}
                        @if(auth()->user()->role == 'admin')
                            {{-- <a href="{{ route('admin.feedback.edit', $feedback->id) }}" class="btn btn-warning btn-sm">Edit</a> --}}
                            {{-- <form action="{{ route('admin.feedback.destroy', $feedback->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form> --}}
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No feedbacks found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection