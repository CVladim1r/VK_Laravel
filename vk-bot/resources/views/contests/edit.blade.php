@extends('layouts.app')

@section('title', 'Edit Contest')

@section('content')

    <h1>Edit Contest</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('contests.update', $contest->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" id="image" name="image" class="form-control">
            <img src="{{ asset('storage/' . $contest->image) }}" alt="Contest Image" style="max-width: 200px; margin-top: 10px;">
        </div>

        <div class="mb-3">
            <label for="text" class="form-label">Text</label>
            <textarea id="text" name="text" class="form-control" required>{{ $contest->text }}</textarea>
        </div>

        <div class="mb-3">
            <label for="draw_time" class="form-label">Draw Time</label>
            <input type="datetime-local" id="draw_time" name="draw_time" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($contest->draw_time)) }}" required>
        </div>

        <div class="mb-3">
            <label for="public_id" class="form-label">Public ID</label>
            <input type="text" id="public_id" name="public_id" class="form-control" value="{{ $contest->public_id }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>

@endsection
