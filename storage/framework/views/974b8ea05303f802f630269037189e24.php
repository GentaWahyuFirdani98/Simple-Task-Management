<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Task Management System'); ?></title>
    
    <!-- Tailwind CSS -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <!-- Additional styles -->
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <?php if(session('is_logged_in')): ?>
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-gray-800">Task Management</h1>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <a href="<?php echo e(route('dashboard')); ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                                🟡 Dashboard (Helper)
                            </a>
                            <a href="<?php echo e(route('dashboard.raw')); ?>" class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium">
                                🔴 Dashboard (Raw)
                            </a>
                            <a href="<?php echo e(route('tasks.create')); ?>" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">
                                Create Task
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <!-- PHP SESSION IMPLEMENTATION - Display user info from session -->
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-700 text-sm">Welcome, <?php echo e(session('user_name')); ?></span>
                        <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn-secondary text-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <!-- Alert Container -->
    <div id="alert-container" class="max-w-7xl mx-auto px-4 mt-4">
        <?php if(session('success')): ?>
            <div class="alert border-l-4 border-green-500 bg-green-100 text-green-700 p-4 mb-4">
                <p><?php echo e(session('success')); ?></p>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert border-l-4 border-red-500 bg-red-100 text-red-700 p-4 mb-4">
                <p><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert border-l-4 border-red-500 bg-red-100 text-red-700 p-4 mb-4">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto py-6 px-4">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-12">
        <div class="max-w-7xl mx-auto py-4 px-4">
            <div class="text-center text-gray-600 text-sm">
                <p>&copy; 2024 Task Management System. Built with Laravel & Tailwind CSS.</p>
                <p class="mt-1">
                    <!-- Implementation Highlights -->
                    <span class="text-blue-600 font-medium">🔐 PHP Session</span> |
                    <span class="text-red-600 font-medium">🔴 DB Raw</span> |
                    <span class="text-yellow-600 font-medium">🟡 DB Helper</span> |
                    <span class="text-purple-600 font-medium">📊 ORM Eloquent</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Additional scripts -->
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\whyuf\OneDrive\Dokumen\kuliah\PWEB\TUGAS\task-management\resources\views/layouts/app.blade.php ENDPATH**/ ?>