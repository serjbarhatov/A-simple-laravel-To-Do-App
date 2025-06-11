@extends('layouts.app')

@section('content')
<div class="bg-white/90 shadow-2xl rounded-2xl p-8 mb-8 transition-all duration-300">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-extrabold text-purple-700 tracking-tight drop-shadow">My Todos</h2>
        <div class="flex space-x-2">
            <form method="GET" action="" class="flex items-center space-x-2">
                <select name="filter" class="rounded border-gray-300 focus:ring-purple-400 focus:border-purple-400 transition">
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                </select>
                <select name="sort" class="rounded border-gray-300 focus:ring-purple-400 focus:border-purple-400 transition">
                    <option value="due_date">Due Date</option>
                    <option value="priority">Priority</option>
                </select>
                <button type="submit" class="bg-gray-200 px-2 py-1 rounded hover:bg-purple-100 transition">Apply</button>
            </form>
            <a href="{{ route('todos.create') }}" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-pink-500 hover:to-purple-500 text-white font-bold py-2 px-4 rounded-lg shadow transition-all duration-200">
                + Add New Todo
            </a>
        </div>
    </div>
    <div class="space-y-6">
        @forelse ($todos as $todo)
            <div class="flex items-center justify-between p-6 bg-white rounded-xl shadow-lg border-l-8 @if($todo->priority=='high') border-red-500 @elseif($todo->priority=='medium') border-yellow-500 @else border-green-500 @endif @if($todo->due_date && $todo->due_date->isPast() && !$todo->completed) bg-red-50 @endif hover:scale-[1.02] hover:shadow-2xl transition-all duration-200">
                <div class="flex items-center space-x-4">
                    <form action="{{ route('todos.toggle-complete', $todo) }}" method="POST" class="flex-shrink-0">
                        @csrf
                        <button type="submit" class="focus:outline-none">
                            <svg class="w-7 h-7 {{ $todo->completed ? 'text-green-500' : 'text-gray-400' }} transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" stroke-width="2" class="{{ $todo->completed ? 'stroke-green-400' : 'stroke-gray-300' }}" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" class="{{ $todo->completed ? '' : 'hidden' }}" />
                            </svg>
                        </button>
                    </form>
                    <div>
                        <h3 class="text-xl font-bold flex items-center gap-2 {{ $todo->completed ? 'line-through text-gray-400' : 'text-gray-800' }}">
                            @if($todo->priority=='high')<span title="High Priority">🔥</span>@elseif($todo->priority=='medium')<span title="Medium Priority">⚡</span>@else<span title="Low Priority">🟢</span>@endif
                            {{ $todo->title }}
                            <span class="ml-2 px-2 py-1 rounded text-xs font-bold @if($todo->priority=='high') bg-red-500 text-white @elseif($todo->priority=='medium') bg-yellow-400 text-black @else bg-green-400 text-black @endif">
                                {{ ucfirst($todo->priority) }}
                            </span>
                            @if($todo->due_date)
                                <span class="ml-2 px-2 py-1 rounded text-xs font-semibold @if($todo->due_date->isPast() && !$todo->completed) bg-red-200 text-red-800 @else bg-gray-200 text-gray-800 @endif">
                                    Due: {{ $todo->due_date->format('Y-m-d') }}
                                </span>
                            @endif
                        </h3>
                        @if($todo->description)
                            <p class="text-gray-600 mt-1">{{ $todo->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('todos.edit', $todo) }}" class="text-blue-500 hover:text-blue-700 transition" title="Edit">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </a>
                    <form action="{{ route('todos.destroy', $todo) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none transition" title="Delete">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-4">No todos yet. Create one!</p>
        @endforelse
    </div>
</div>
@endsection

@section('footer')
@php
    $activeCount = \App\Models\Todo::where('completed', false)->count();
    $completedCount = \App\Models\Todo::where('completed', true)->count();
@endphp
<footer class="w-full text-center py-4 text-gray-600 text-sm mt-auto">
    <span class="mr-4">Active: <span class="font-bold text-purple-700">{{ $activeCount }}</span></span>
    <span>Completed: <span class="font-bold text-green-600">{{ $completedCount }}</span></span>
</footer>
@endsection 