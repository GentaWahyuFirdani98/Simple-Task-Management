<?php $__env->startSection('title', 'Dashboard - Task Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <!-- PHP SESSION IMPLEMENTATION - Display user-specific welcome message -->
            <p class="text-gray-600">Welcome back, <?php echo e(session('user_name')); ?>!</p>
        </div>
        <a href="<?php echo e(route('tasks.create')); ?>" class="btn-primary">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Create New Task
        </a>
    </div>

    <!-- Statistics Cards -->
    <!-- DB HELPER IMPLEMENTATION - Task statistics from database -->
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
                    <p class="text-2xl font-bold text-blue-900"><?php echo e($taskStats['total']); ?></p>
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
                    <p class="text-2xl font-bold text-yellow-900"><?php echo e($taskStats['pending']); ?></p>
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
                    <p class="text-2xl font-bold text-blue-900"><?php echo e($taskStats['in_progress']); ?></p>
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
                    <p class="text-2xl font-bold text-green-900"><?php echo e($taskStats['completed']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Buttons -->
    <div class="card">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Tasks</h3>
        <div class="flex flex-wrap gap-2">
            <a href="<?php echo e(route('dashboard')); ?>" class="btn-secondary text-sm">All Tasks</a>
            <a href="<?php echo e(route('tasks.filter', 'pending')); ?>" class="btn-warning text-sm">Pending</a>
            <a href="<?php echo e(route('tasks.filter', 'in_progress')); ?>" class="btn-primary text-sm">In Progress</a>
            <a href="<?php echo e(route('tasks.filter', 'completed')); ?>" class="btn-success text-sm">Completed</a>
        </div>
    </div>

    <!-- Tasks List -->
    <!-- DB HELPER IMPLEMENTATION - Display tasks retrieved from database -->
    <div class="card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-medium text-gray-900">Your Tasks</h3>
            <span class="text-sm text-gray-500"><?php echo e(count($tasks)); ?> task(s) found</span>
        </div>

        <?php if(count($tasks) > 0): ?>
            <div class="space-y-4">
                <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3 mb-2">
                                    <h4 class="text-lg font-medium text-gray-900"><?php echo e($task->title); ?></h4>
                                    <span id="status-badge-<?php echo e($task->id); ?>" class="status-<?php echo e($task->status); ?>">
                                        <?php echo e(strtoupper(str_replace('_', ' ', $task->status))); ?>

                                    </span>
                                    <span class="priority-<?php echo e($task->priority); ?>">
                                        <?php echo e(strtoupper($task->priority)); ?>

                                    </span>
                                </div>

                                <?php if($task->description): ?>
                                    <p class="text-gray-600 mb-3"><?php echo e($task->description); ?></p>
                                <?php endif; ?>

                                <div class="flex items-center space-x-4 text-sm text-gray-500">
                                    <span>Created: <?php echo e(date('M d, Y', strtotime($task->created_at))); ?></span>
                                    <?php if($task->due_date): ?>
                                        <span>Due: <?php echo e(date('M d, Y', strtotime($task->due_date))); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="flex items-center space-x-2 ml-4">
                                <!-- Quick Status Update -->
                                <select class="status-select form-select text-sm" data-task-id="<?php echo e($task->id); ?>">
                                    <option value="pending" <?php echo e($task->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                    <option value="in_progress" <?php echo e($task->status == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                                    <option value="completed" <?php echo e($task->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                </select>

                                <!-- Action Buttons -->
                                <a href="<?php echo e(route('tasks.edit', $task->id)); ?>" class="btn-secondary text-sm">
                                    Edit
                                </a>

                                <form method="POST" action="<?php echo e(route('tasks.destroy', $task->id)); ?>" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="delete-task btn-danger text-sm">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tasks found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating your first task.</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('tasks.create')); ?>" class="btn-primary">
                        Create New Task
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Implementation Highlights -->
    <div class="card bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200">
        <h3 class="text-lg font-medium text-gray-900 mb-4">🚀 Implementation Highlights</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="text-center">
                <div class="text-blue-600 text-2xl mb-2">🔐</div>
                <h4 class="font-medium text-blue-900">PHP Session</h4>
                <p class="text-sm text-blue-700">User authentication & session management</p>
            </div>
            <div class="text-center">
                <div class="text-green-600 text-2xl mb-2">🗄️</div>
                <h4 class="font-medium text-green-900">DB Helper</h4>
                <p class="text-sm text-green-700">Task CRUD operations with DB facade</p>
            </div>
            <div class="text-center">
                <div class="text-purple-600 text-2xl mb-2">📊</div>
                <h4 class="font-medium text-purple-900">ORM Eloquent</h4>
                <p class="text-sm text-purple-700">User management with Eloquent models</p>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\whyuf\OneDrive\Dokumen\kuliah\PWEB\TUGAS\task-management\resources\views/dashboard.blade.php ENDPATH**/ ?>