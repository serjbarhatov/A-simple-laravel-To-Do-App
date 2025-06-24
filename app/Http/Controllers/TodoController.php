<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->todos();

        // Filter by status
        if ($request->has('status')) {
            $query->where('completed', $request->status === 'completed');
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        // Sort todos
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        switch ($sort) {
            case 'due_date':
                $query->orderBy('due_date', $direction);
                break;
            case 'priority':
                $query->orderByRaw("FIELD(priority, 'high', 'medium', 'low') " . $direction);
                break;
            default:
                $query->orderBy($sort, $direction);
        }

        $todos = $query->get();

        return view('todos.index', compact('todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('todos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        $todo = auth()->user()->todos()->create($request->validated());

        return redirect()->route('todos.index')
            ->with('success', 'Todo created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        // Ensure user can only edit their own todos
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        return view('todos.edit', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        // Ensure user can only update their own todos
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->update($request->validated());

        return redirect()->route('todos.index')
            ->with('success', 'Todo updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        // Ensure user can only delete their own todos
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->delete();

        return redirect()->route('todos.index')
            ->with('success', 'Todo deleted successfully!');
    }

    public function toggleComplete(Todo $todo)
    {
        // Ensure user can only toggle their own todos
        if ($todo->user_id !== auth()->id()) {
            abort(403);
        }

        $todo->update(['completed' => !$todo->completed]);

        return redirect()->route('todos.index')
            ->with('success', 'Todo status updated successfully!');
    }
}
