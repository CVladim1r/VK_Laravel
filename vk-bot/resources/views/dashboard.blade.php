@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'contests' ? 'active' : '' }}" id="nav-contests-tab" data-toggle="tab" href="#nav-contests" role="tab">Contests</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'publics' ? 'active' : '' }}" id="nav-publics-tab" data-toggle="tab" href="#nav-publics" role="tab">Publics</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabsContent">
        <div class="tab-pane fade {{ $activeTab === 'contests' ? 'show active' : '' }}" id="nav-contests" role="tabpanel" aria-labelledby="nav-contests-tab">
            <h2>Contests</h2>
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
                            <td><img src="data:image/jpeg;base64,{{ base64_encode($contest->image) }}" alt="Contest Image" width="60px">{{ $contest->image }}</img></td>
                            <td>{{ $contest->text }}</td>
                            <td>{{ $contest->draw_time }}</td>
                            <td>{{ $contest->public_id }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade {{ $activeTab === 'publics' ? 'show active' : '' }}" id="nav-publics" role="tabpanel" aria-labelledby="nav-publics-tab">
            <h2>Publics</h2>
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
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
