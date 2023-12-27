<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContestModel;
use App\Models\PublicModel;

class PublicController extends Controller
{
    public function index(Request $request)
    {
        $publics = PublicModel::all();
        $activeTab = $request->get('tab', 'publics');

        return view('publics.index', compact('publics', 'activeTab'));
    }

    public function create()
    {
        return view('publics.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'vk_id' => 'required',
            'name' => 'required',
            'token' => 'required',
        ]);

        PublicModel::create([
            'vk_id' => $request->input('vk_id'),
            'name' => $request->input('name'),
            'token' => $request->input('token'),
        ]);

        return redirect()->route('publics.index')->with('success', 'Паблик успешно добавлен');
    }

    public function edit($id)
    {
        $public = PublicModel::find($id);
        return view('publics.edit', compact('public'));
    }

    public function update(Request $request, $id)
    {
        $public = PublicModel::find($id);
        $public->vk_id = $request->input('vk_id');
        $public->name = $request->input('name');
        $public->token = $request->input('token');
        $public->save();

        return redirect()->route('publics.index')->with('success', 'Паблик успешно обновлен');
    }

    public function destroy($id)
    {
        $public = PublicModel::find($id);
        $public->delete();

        return redirect()->route('publics.index')->with('success', 'Паблик успешно удален');
    }
}
