@extends('layouts.app')

@section('title', 'Create Public')

@section('content')
    <h1>Create Public</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('publics.store') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="vk_id">VK ID:</label>
            <input type="text" name="vk_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="token">Token:</label>
            <input type="text" name="token" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
