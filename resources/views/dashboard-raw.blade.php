@extends('layouts.app')

@section('title', 'Dashboard DB Raw - Task Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard (DB Raw Implementation)</h1>
            <!-- PHP SESSION IMPLEMENTATION - Display user-specific welcome message -->
            <p class="text-gray-600">Welcome back, {{ session('user_name') }}! <span class="text-red-600 font-medium">[Using Raw SQL]</span></p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('tasks.create.raw') }}" class="btn-primary">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Create New Task (Raw SQL)
            </a>
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                </svg>
                Switch to DB Helper
            </a>
        </div>
    </div>

    <!-- Implementation Notice -->
    <div class="card bg-red-50 border border-red-200">
        <div class="flex items-center">
            <div class="text-red-600 text-2xl mr-3">🔴</div>
            <div>
                <h3 class="text-lg font-medium text-red-900">DB Raw Implementation</h3>
                <p class="text-sm text-red-700">This page uses raw SQL queries with <code>DB::select()</code>, <code>DB::insert()</code>, <code>DB::update()</code>, and <code>DB::delete()</code></p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <!-- DB RAW IMPLEMENTATION - Task statistics from raw SQL queries -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card bg-blue-50 border border-blue-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-500 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">Total Tasks</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $taskStats['total'] }}</p>
                    <p class="text-xs text-blue-500">Raw SQL COUNT(*)</p>
                </div>
            </div>
        </div>

        <div class="card bg-yellow-50 border border-yellow-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-500 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-600">Pending</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $taskStats['pending'] }}</p>
                    <p class="text-xs text-yellow-500">Raw SQL CASE WHEN</p>
                </div>
            </div>
        </div>

        <div class="card bg-blue-50 border border-blue-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-600 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-600">In Progress</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $taskStats['in_progress'] }}</p>
                    <p class="text-xs text-blue-500">Raw SQL SUM(CASE)</p>
                </div>
            </div>
        </div>

        <div class="card bg-green-50 border border-green-200">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-500 text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-600">Completed</p>
                    <p class="text-2xl font-bold text-green-900">{{ $taskStats['completed'] }}</p>
                    <p class="text-xs text-green-500">Raw SQL Aggregation</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="card">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Tasks (Raw SQL WHERE Clauses)</h3>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard.raw') }}" class="btn-secondary text-sm">All Tasks</a>
            <a href="{{ route('tasks.filter.raw', 'pending') }}" class="btn-warning text-sm">Pending</a>
            <a href="{{ route('tasks.filter.raw', 'in_progress') }}" class="btn-primary text-sm">In Progress</a>
            <a href="{{ route('tasks.filter.raw', 'completed') }}" class="btn-success text-sm">Completed</a>
        </div>
    </div>

    <!-- Tasks List -->
    <!-- DB RAW IMPLEMENTATION - Display tasks retrieved from raw SQL -->
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Your Tasks (Raw SQL Results)</h3>
            <span class="text-sm text-gray-500">{{ count($tasks) }} task(s) found</span>
        </div>

        @if(count($tasks) > 0)
            <div class="space-y-4">
                @foreach($tasks as $task)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-medium text-gray-900">{{ $task->title }}</h4>
                                    <span id="status-badge-{{ $task->id }}" class="status-{{ $task->status }}">
                                        {{ strtoupper(str_replace('_', ' ', $task->status)) }}
                                    </span>
                                    <span class="priority-{{ $task->priority }}">
                                        {{ strtoupper($task->priority) }}
                                    </span>
                                </div>
                                
                                @if($task->description)
                                    <p class="text-gray-600 mb-3">{{ $task->description }}</p>
                                @endif
                                
                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Created: {{ date('M d, Y', strtotime($task->created_at)) }}</span>
                                    @if($task->due_date)
                                        <span>Due: {{ date('M d, Y', strtotime($task->due_date)) }}</span>
                                    @endif
                                    <span class="text-red-600 font-medium">[Raw SQL Data]</span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-2 ml-4">
                                <!-- Quick Status Update -->
                                <select class="status-select-raw form-select text-sm" data-task-id="{{ $task->id }}">
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $task->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                
                                <!-- Action Buttons -->
                                <a href="{{ route('tasks.edit.raw', $task->id) }}" class="btn-secondary text-sm">
                                    Edit (Raw)
                                </a>
                                
                                <form method="POST" action="{{ route('tasks.destroy.raw', $task->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-task btn-danger text-sm">
                                        Delete (Raw)
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first task with Raw SQL.</p>
                <div class="mt-6">
                    <a href="{{ route('tasks.create.raw') }}" class="btn-primary">
                        Create New Task (Raw SQL)
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Implementation Comparison -->
    <div class="card bg-gradient-to-r from-red-50 to-orange-50 border border-red-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">🔍 DB Raw Implementation Highlights</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h4 class="font-medium text-red-900 mb-2">✅ Advantages:</h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Maximum performance control</li>
                    <li>• Complex queries with JOINs</li>
                    <li>• Database-specific features</li>
                    <li>• Optimized aggregations</li>
                </ul>
            </div>
            <div>
                <h4 class="font-medium text-red-900 mb-2">⚠️ Considerations:</h4>
                <ul class="text-sm text-red-700 space-y-1">
                    <li>• Manual parameter binding required</li>
                    <li>• More verbose syntax</li>
                    <li>• Database-specific SQL</li>
                    <li>• Harder to maintain</li>
                </ul>
            </div>
        </div>
        
        <div class="mt-4 p-3 bg-red-100 rounded-lg">
            <h4 class="font-medium text-red-900 mb-2">📝 Raw SQL Examples Used:</h4>
            <div class="text-sm text-red-800 space-y-1">
                <p><strong>Statistics:</strong> <code>SELECT COUNT(*), SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) FROM tasks WHERE user_id = ?</code></p>
                <p><strong>Tasks:</strong> <code>SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC</code></p>
                <p><strong>Insert:</strong> <code>INSERT INTO tasks (title, description, ...) VALUES (?, ?, ...)</code></p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Handle status change for Raw SQL implementation
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select-raw');
    
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const taskId = this.dataset.taskId;
            const newStatus = this.value;
            
            updateTaskStatusRaw(taskId, newStatus);
        });
    });
});

function updateTaskStatusRaw(taskId, status) {
    fetch(`/tasks/raw/${taskId}/status`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the status badge
            const statusBadge = document.querySelector(`#status-badge-${taskId}`);
            if (statusBadge) {
                statusBadge.className = `status-${status}`;
                statusBadge.textContent = status.replace('_', ' ').toUpperCase();
            }
            
            // Show success message with Raw SQL indicator
            showAlert(data.message, 'success');
        } else {
            showAlert('Failed to update status with Raw SQL!', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('An error occurred with Raw SQL operation!', 'error');
    });
}

function showAlert(message, type) {
    const alertContainer = document.getElementById('alert-container');
    if (!alertContainer) return;
    
    const alertClass = type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700';
    
    const alertHTML = `
        <div class="alert border-l-4 p-4 mb-4 ${alertClass}">
            <p>${message}</p>
        </div>
    `;
    
    alertContainer.insertAdjacentHTML('beforeend', alertHTML);
    
    setTimeout(() => {
        const newAlert = alertContainer.lastElementChild;
        if (newAlert) {
            newAlert.style.opacity = '0';
            setTimeout(() => {
                newAlert.remove();
            }, 300);
        }
    }, 3000);
}
</script>
@endpush
@endsection
