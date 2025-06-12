@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Todo</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">
                    Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" value="{{ old('title', $todo->title) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-500 @enderror"
                    required minlength="3" maxlength="255" placeholder="Enter a descriptive title"
                    oninput="checkTitleLength()">
                <p id="title-warning" class="text-xs text-yellow-600 mt-1 hidden">
                    ⚠️ You have reached the character limit.
                </p>
                <p class="text-xs text-gray-500 mt-1">Required. 3–255 characters.</p>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="3" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-red-500 @enderror"
                    maxlength="1000" placeholder="Add more details (optional)" oninput="checkDescriptionLength()">{{ old('description', $todo->description) }}</textarea>
                <p id="description-warning" class="text-xs text-yellow-600 mt-1 hidden">
                    ⚠️ You have reached the character limit.
                </p>
                <p class="text-xs text-gray-500 mt-1">Optional. Up to 1000 characters.</p>
            </div>

            <div>
                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $todo->due_date) }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('due_date') border-red-500 @enderror"
                    min="{{ date('Y-m-d') }}">
                <p class="text-xs text-gray-500 mt-1">Optional. Cannot be in the past.</p>
            </div>

            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700">
                    Priority <span class="text-red-500">*</span>
                </label>
                <select name="priority" id="priority" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('priority') border-red-500 @enderror"
                    required>
                    <option value="">Select Priority</option>
                    <option value="low" {{ old('priority', $todo->priority) == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ old('priority', $todo->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ old('priority', $todo->priority) == 'high' ? 'selected' : '' }}>High</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Required. Choose the importance level.</p>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('todos.index') }}" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancel
                </a>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Update Todo
                </button>
            </div>
        </form>
        <script>
        function checkTitleLength() {
            const input = document.getElementById('title');
            const warning = document.getElementById('title-warning');
            if (input.value.length === 255) {
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }
        }
        function checkDescriptionLength() {
            const input = document.getElementById('description');
            const warning = document.getElementById('description-warning');
            if (input.value.length === 1000) {
                warning.classList.remove('hidden');
            } else {
                warning.classList.add('hidden');
            }
        }
        </script>
    </div>
</div>
@endsection 