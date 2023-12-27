@extends('layouts.app')

@section('title', 'Create Contest')

@section('content')
    <h1>Create Contest</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contests.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="text">Text:</label>
            <textarea name="text" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="draw_time">Draw Time:</label>
            <input type="datetime-local" name="draw_time" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="public_id">Public ID:</label>
            <input type="text" name="public_id" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection