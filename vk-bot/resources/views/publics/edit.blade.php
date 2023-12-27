@extends('layouts.app')

@section('title', 'Edit Public')

@section('content')
    <h1>Edit Public</h1>

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('publics.update', $public->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="vk_id" class="form-label">VK ID</label>
            <input type="text" id="vk_id" name="vk_id" class="form-control" value="{{ $public->vk_id }}" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $public->name }}" required>
        </div>

        <div class="mb-3">
            <label for="token" class="form-label">Token</label>
            <input type="text" id="token" name="token" class="form-control" value="{{ $public->token }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Public</button>
    </form>
@endsection
