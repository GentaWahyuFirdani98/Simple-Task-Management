@extends('layouts.app')

@section('title', 'Edit Task - Task Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Task</h1>
        <p class="text-gray-600">Update task information</p>
    </div>

    <!-- Edit Task Form -->
    <!-- DB HELPER IMPLEMENTATION - Form to update task using DB facade -->
    <div class="card">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
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
                <h4 class="font-medium text-gray-900 mb-2">Task Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Created:</span> {{ date('M d, Y H:i', strtotime($task->created_at)) }}
                    </div>
                    <div>
                        <span class="font-medium">Last Updated:</span> {{ date('M d, Y H:i', strtotime($task->updated_at)) }}
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-6 border-t border-gray-200">
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
                
                <div class="flex space-x-3">
                    <form method="POST" action="{{ route('tasks.destroy', $task->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-task btn-danger">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Task
                        </button>
                    </form>
                    
                    <button type="submit" class="btn-primary">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                        </svg>
                        Update Task
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Implementation Info -->
    <div class="card bg-green-50 border border-green-200 mt-6">
        <h3 class="text-lg font-medium text-green-900 mb-3">🗄️ DB Helper Implementation</h3>
        <div class="space-y-2 text-sm text-green-800">
            <p><strong>Update Operation:</strong> Uses DB::table('tasks')->where()->update() to modify task</p>
            <p><strong>Security:</strong> Ensures user can only edit their own tasks</p>
            <p><strong>Delete Operation:</strong> Uses DB::table('tasks')->where()->delete() for removal</p>
        </div>
    </div>
</div>
@endsection
