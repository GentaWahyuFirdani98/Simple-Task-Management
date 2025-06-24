@extends('layouts.app')

@section('title', 'Create Task (DB Raw) - Task Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Task (DB Raw)</h1>
        <p class="text-gray-600">Add a new task using Raw SQL implementation</p>
    </div>

    <!-- Implementation Notice -->
    <div class="card bg-red-50 border border-red-200 mb-6">
        <div class="flex items-center">
            <div class="text-red-600 text-2xl mr-3">🔴</div>
            <div>
                <h3 class="text-lg font-medium text-red-900">DB Raw Implementation</h3>
                <p class="text-sm text-red-700">This form uses <code>DB::insert()</code> with raw SQL query for task creation</p>
            </div>
        </div>
    </div>

    <!-- Create Task Form -->
    <!-- DB RAW IMPLEMENTATION - Form to create new task using raw SQL -->
    <div class="card">
        <form action="{{ route('tasks.store.raw') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Task Title *
                </label>
                <input type="text" id="title" name="title" required 
                       class="form-input @error('title') border-red-500 @enderror" 
                       value="{{ old('title') }}" 
                       placeholder="Enter task title">
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea id="description" name="description" rows="4" 
                          class="form-textarea @error('description') border-red-500 @enderror" 
                          placeholder="Enter task description (optional)">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        Priority *
                    </label>
                    <select id="priority" name="priority" required 
                            class="form-select @error('priority') border-red-500 @enderror">
                        <option value="">Select Priority</option>
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Due Date
                    </label>
                    <input type="date" id="due_date" name="due_date" 
                           class="form-input @error('due_date') border-red-500 @enderror" 
                           value="{{ old('due_date') }}" 
                           min="{{ date('Y-m-d') }}">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard.raw') }}" class="btn-secondary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard (Raw)
                </a>
                
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Task (Raw SQL)
                </button>
            </div>
        </form>
    </div>

    <!-- Implementation Info -->
    <div class="card bg-red-50 border border-red-200 mt-6">
        <h3 class="text-lg font-medium text-red-900 mb-3">🔴 DB Raw Implementation Details</h3>
        <div class="space-y-3 text-sm text-red-800">
            <div>
                <strong>SQL Query Used:</strong>
                <code class="block mt-1 p-2 bg-red-100 rounded text-xs">
                    INSERT INTO tasks (title, description, priority, due_date, status, user_id, created_at, updated_at) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                </code>
            </div>
            <div>
                <strong>Security:</strong> Uses parameter binding (?) to prevent SQL injection
            </div>
            <div>
                <strong>Performance:</strong> Direct SQL execution - fastest possible method
            </div>
            <div>
                <strong>Maintenance:</strong> Requires manual SQL writing and parameter management
            </div>
        </div>
    </div>

    <!-- Comparison with Other Methods -->
    <div class="card bg-gray-50 border border-gray-200 mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">📊 Method Comparison</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="p-3 bg-red-100 rounded">
                <h4 class="font-medium text-red-900">🔴 DB Raw (Current)</h4>
                <p class="text-red-700 mt-1">Raw SQL with parameter binding</p>
                <code class="text-xs">DB::insert('INSERT...')</code>
            </div>
            <div class="p-3 bg-yellow-100 rounded">
                <h4 class="font-medium text-yellow-900">🟡 DB Helper</h4>
                <p class="text-yellow-700 mt-1">Query Builder methods</p>
                <code class="text-xs">DB::table()->insert()</code>
            </div>
            <div class="p-3 bg-green-100 rounded">
                <h4 class="font-medium text-green-900">🟢 ORM Eloquent</h4>
                <p class="text-green-700 mt-1">Model-based operations</p>
                <code class="text-xs">Task::create()</code>
            </div>
        </div>
    </div>
</div>
@endsection
