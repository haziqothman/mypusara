@extends('layouts.navigation')

@section('content')
<div class="container">
    <h1>Add Feedback</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- <form action="{{ route('customer.feedback.store') }}" method="POST"> --}}
        <form action="" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Feedback</label>
            <textarea name="message" class="form-control" id="message" rows="4" required></textarea>
        </div>

        <a href="{{route('customer.feedback')}}" class="btn btn-success">Submit</a>
        {{-- <a href="{{ route('feedback.index') }}" class="btn btn-secondary">Back</a> --}}
        <a href="{{route('customer.feedback')}}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
