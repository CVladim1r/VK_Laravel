@extends('layouts.app')

@section('title', 'Publics')

@section('publics_content')
    <h1>База пабликов</h1>
    <a href="{{ route('publics.create') }}" class="btn btn-success mb-3">Создать</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>VK ID</th>
                <th>Name</th>
                <th>Token</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($publics as $public)
                <tr>
                    <td>{{ $public->id }}</td>
                    <td>{{ $public->vk_id }}</td>
                    <td>{{ $public->name }}</td>
                    <td>{{ $public->token }}</td>
                    <td>
                        <a href="{{ route('publics.edit', $public->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('publics.destroy', $public->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
