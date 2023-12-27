<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        Task::create([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
        ]);

        return redirect()->route('tasks.index')->with('success', 'Задание успешно добавлено');
    }

    public function edit($id)
    {
        $task = Task::find($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        $task = Task::find($id);
        $task->name = $request->input('name');
        $task->type = $request->input('type');
        $task->value = $request->input('value');
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Задание успешно обновлено');
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Задание успешно удалено');
    }
}
