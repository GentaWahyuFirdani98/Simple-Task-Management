@extends('layouts.app')

@section('title', 'Login - Task Management')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    create a new account
                </a>
            </p>
        </div>
        
        <div class="card">
            <!-- PHP SESSION IMPLEMENTATION - Login form for session-based authentication -->
            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        Email address
                    </label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="form-input @error('email') border-red-500 @enderror" 
                               value="{{ old('email') }}" placeholder="Enter your email">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password
                    </label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="form-input @error('password') border-red-500 @enderror" 
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary">
                        Sign in
                    </button>
                </div>
            </form>
        </div>

        <!-- Demo Credentials -->
        <div class="card bg-blue-50 border border-blue-200">
            <h3 class="text-lg font-medium text-blue-900 mb-3">Demo Credentials</h3>
            <div class="space-y-2 text-sm text-blue-800">
                <p><strong>Admin:</strong> admin@example.com / password</p>
                <p><strong>User 1:</strong> john@example.com / password</p>
                <p><strong>User 2:</strong> jane@example.com / password</p>
            </div>
        </div>

        <!-- Implementation Info -->
        <div class="card bg-gray-50 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Implementation Features</h3>
            <div class="space-y-2 text-sm text-gray-700">
                <p><span class="text-blue-600 font-medium">🔐 PHP Session:</span> Session-based authentication</p>
                <p><span class="text-green-600 font-medium">🗄️ DB Helper:</span> Task CRUD operations</p>
                <p><span class="text-purple-600 font-medium">📊 ORM:</span> User management with Eloquent</p>
            </div>
        </div>
    </div>
</div>
@endsection
