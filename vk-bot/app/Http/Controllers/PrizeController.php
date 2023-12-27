<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;

class PrizeController extends Controller
{
    public function create()
    {
        return view('prizes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        Prize::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
        ]);

        return redirect()->route('prizes.index')->with('success', 'Приз успешно добавлен');
    }

    public function edit($id)
    {
        $prize = Prize::find($id);
        return view('prizes.edit', compact('prize'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        $prize = Prize::find($id);
        $prize->name = $request->input('name');
        $prize->type = $request->input('type');
        $prize->value = $request->input('value');
        $prize->save();

        return redirect()->route('prizes.index')->with('success', 'Приз успешно обновлен');
    }

    public function destroy($id)
    {
        $prize = Prize::find($id);
        $prize->delete();

        return redirect()->route('prizes.index')->with('success', 'Приз успешно удален');
    }

}
