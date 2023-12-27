@extends('layouts.app')

@section('title', 'Contests')

@section('contests_content')
    <h1>Конкурсы</h1>
    <a href="{{ route('contests.create') }}" class="btn btn-success mb-3">Создать</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Text</th>
                <th>Draw Time</th>
                <th>Public ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contests as $contest)
                <tr>
                    <td>{{ $contest->id }}</td>
                    <td><img src="data:image/jpeg;base64,{{ base64_encode($contest->image) }}" alt="Contest Image" width="60px"></td>
                    <td>{{ $contest->text }}</td>
                    <td>{{ $contest->draw_time }}</td>
                    <td>{{ $contest->public_id }}</td>
                    <td>
                        <a href="{{ route('contests.edit', $contest->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('contests.destroy', $contest->id) }}" method="POST" style="display:inline">
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
