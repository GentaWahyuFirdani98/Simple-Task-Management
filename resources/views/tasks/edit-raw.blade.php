@extends('layouts.app')

@section('title', 'Edit Task (DB Raw) - Task Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Task (DB Raw)</h1>
        <p class="text-gray-600">Update task information using Raw SQL implementation</p>
    </div>

    <!-- Implementation Notice -->
    <div class="card bg-red-50 border border-red-200 mb-6">
        <div class="flex items-center">
            <div class="text-red-600 text-2xl mr-3">🔴</div>
            <div>
                <h3 class="text-lg font-medium text-red-900">DB Raw Implementation</h3>
                <p class="text-sm text-red-700">This form uses <code>DB::update()</code> with raw SQL query for task modification</p>
            </div>
        </div>
    </div>

    <!-- Edit Task Form -->
    <!-- DB RAW IMPLEMENTATION - Form to update task using raw SQL -->
    <div class="card">
        <form action="{{ route('tasks.update.raw', $task->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Task Title *
                </label>
                <input type="text" id="title" name="title" required 
                       class="form-input @error('title') border-red-500 @enderror" 
                       value="{{ old('title', $task->title) }}" 
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
                          placeholder="Enter task description (optional)">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status *
                    </label>
                    <select id="status" name="status" required 
                            class="form-select @error('status') border-red-500 @enderror">
                        <option value="pending" {{ old('status', $task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in_progress" {{ old('status', $task->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('status', $task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                        Priority *
                    </label>
                    <select id="priority" name="priority" required 
                            class="form-select @error('priority') border-red-500 @enderror">
                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
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
                           value="{{ old('due_date', $task->due_date) }}">
                    @error('due_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Task Info -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-medium text-gray-900 mb-2">Task Information (Raw SQL Data)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Task ID:</span> {{ $task->id }}
                    </div>
                    <div>
                        <span class="font-medium">Created:</span> {{ date('M d, Y H:i', strtotime($task->created_at)) }}
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span> {{ date('M d, Y H:i', strtotime($task->updated_at)) }}
                    </div>
                    <div>
                        <span class="font-medium">Data Source:</span> <span class="text-red-600 font-medium">Raw SQL Query</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard.raw') }}" class="btn-secondary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard (Raw)
                </a>
                
                <div class="flex space-x-3">
                    <form method="POST" action="{{ route('tasks.destroy.raw', $task->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-task btn-danger">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Task (Raw SQL)
                        </button>
                    </form>
                    
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Update Task (Raw SQL)
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Implementation Info -->
    <div class="card bg-red-50 border border-red-200 mt-6">
        <h3 class="text-lg font-medium text-red-900 mb-3">🔴 DB Raw Implementation Details</h3>
        <div class="space-y-3 text-sm text-red-800">
            <div>
                <strong>SELECT Query Used:</strong>
                <code class="block mt-1 p-2 bg-red-100 rounded text-xs">
                    SELECT * FROM tasks WHERE id = ? AND user_id = ? LIMIT 1
                </code>
            </div>
            <div>
                <strong>UPDATE Query Used:</strong>
                <code class="block mt-1 p-2 bg-red-100 rounded text-xs">
                    UPDATE tasks SET title = ?, description = ?, status = ?, priority = ?, due_date = ?, updated_at = ? 
                    WHERE id = ? AND user_id = ?
                </code>
            </div>
            <div>
                <strong>DELETE Query Used:</strong>
                <code class="block mt-1 p-2 bg-red-100 rounded text-xs">
                    DELETE FROM tasks WHERE id = ? AND user_id = ?
                </code>
            </div>
            <div>
                <strong>Security Features:</strong>
                <ul class="list-disc list-inside mt-1 space-y-1">
                    <li>Parameter binding prevents SQL injection</li>
                    <li>User ID verification ensures data isolation</li>
                    <li>Input validation before database operations</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Performance Comparison -->
    <div class="card bg-gray-50 border border-gray-200 mt-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">⚡ Performance Comparison</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
            <div class="p-3 bg-red-100 rounded">
                <h4 class="font-medium text-red-900">🔴 DB Raw (Current)</h4>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between">
                        <span>Performance:</span>
                        <span class="font-medium">100%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Complexity:</span>
                        <span class="font-medium">High</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Maintenance:</span>
                        <span class="font-medium">Hard</span>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-yellow-100 rounded">
                <h4 class="font-medium text-yellow-900">🟡 DB Helper</h4>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between">
                        <span>Performance:</span>
                        <span class="font-medium">85%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Complexity:</span>
                        <span class="font-medium">Medium</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Maintenance:</span>
                        <span class="font-medium">Medium</span>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-green-100 rounded">
                <h4 class="font-medium text-green-900">🟢 ORM Eloquent</h4>
                <div class="mt-2 space-y-1">
                    <div class="flex justify-between">
                        <span>Performance:</span>
                        <span class="font-medium">75%</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Complexity:</span>
                        <span class="font-medium">Low</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Maintenance:</span>
                        <span class="font-medium">Easy</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
