<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        // PHP SESSION IMPLEMENTATION - Check if user is already logged in
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    /**
     * Show registration form
     */
    public function showRegister()
    {
        // PHP SESSION IMPLEMENTATION - Check if user is already logged in
        if (session()->has('user_id')) {
            return redirect()->route('dashboard');
        }
        
        return view('auth.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ORM IMPLEMENTATION - Using Eloquent to verify user credentials
        $user = User::verifyCredentials($request->email, $request->password);

        if ($user) {
            // PHP SESSION IMPLEMENTATION - Store user data in session
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'is_logged_in' => true
            ]);

            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            // ORM IMPLEMENTATION - Using Eloquent to create new user
            $user = User::createUser([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // PHP SESSION IMPLEMENTATION - Auto login after registration
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'is_logged_in' => true
            ]);

            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput();
        }
    }

    /**
     * Handle user logout
     */
    public function logout()
    {
        // PHP SESSION IMPLEMENTATION - Clear all session data
        session()->flush();
        session()->regenerate();

        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
