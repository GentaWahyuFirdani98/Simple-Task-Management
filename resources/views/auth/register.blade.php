@extends('layouts.app')

@section('title', 'Register - Task Management')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Or
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                    sign in to your existing account
                </a>
            </p>
        </div>
        
        <div class="card">
            <!-- ORM IMPLEMENTATION - Registration form using Eloquent User model -->
            <form class="space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">
                        Full Name
                    </label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               class="form-input @error('name') border-red-500 @enderror" 
                               value="{{ old('name') }}" placeholder="Enter your full name">
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

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
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                               class="form-input @error('password') border-red-500 @enderror" 
                               placeholder="Enter your password">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirm Password
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" 
                               autocomplete="new-password" required class="form-input" 
                               placeholder="Confirm your password">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full btn-primary">
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Implementation Info -->
        <div class="card bg-gray-50 border border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-3">Registration Features</h3>
            <div class="space-y-2 text-sm text-gray-700">
                <p><span class="text-purple-600 font-medium">📊 ORM:</span> User creation with Eloquent</p>
                <p><span class="text-blue-600 font-medium">🔐 Session:</span> Auto-login after registration</p>
                <p><span class="text-green-600 font-medium">🔒 Security:</span> Password hashing & validation</p>
            </div>
        </div>
    </div>
</div>
@endsection
