@extends('layouts.app')

@section('title', 'Create Task - Task Management')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Create New Task</h1>
        <p class="text-gray-600">Add a new task to your task list</p>
    </div>

    <!-- Create Task Form -->
    <!-- DB HELPER IMPLEMENTATION - Form to create new task using DB facade -->
    <div class="card">
        <form action="{{ route('tasks.store') }}" method="POST" class="space-y-6">
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
                <a href="{{ route('dashboard') }}" class="btn-secondary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
                
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Create Task
                </button>
            </div>
        </form>
    </div>

    <!-- Implementation Info -->
    <div class="card bg-green-50 border border-green-200 mt-6">
        <h3 class="text-lg font-medium text-green-900 mb-3">🗄️ DB Helper Implementation</h3>
        <div class="space-y-2 text-sm text-green-800">
            <p><strong>Create Operation:</strong> Uses DB::table('tasks')->insertGetId() to store new task</p>
            <p><strong>User Association:</strong> Automatically links task to current user from session</p>
            <p><strong>Validation:</strong> Server-side validation with error handling</p>
        </div>
    </div>
</div>
@endsection
