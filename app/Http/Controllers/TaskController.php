<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display dashboard with tasks
     */
    public function dashboard()
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');
        
        // DB HELPER IMPLEMENTATION - Get tasks using DB facade
        $tasks = DB::table('tasks')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // DB HELPER IMPLEMENTATION - Get task statistics
        $taskStats = [
            'total' => DB::table('tasks')->where('user_id', $userId)->count(),
            'pending' => DB::table('tasks')->where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress' => DB::table('tasks')->where('user_id', $userId)->where('status', 'in_progress')->count(),
            'completed' => DB::table('tasks')->where('user_id', $userId)->where('status', 'completed')->count(),
        ];

        return view('dashboard', compact('tasks', 'taskStats'));
    }

    /**
     * Show create task form
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a new task
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Insert new task using DB facade
        $taskId = DB::table('tasks')->insertGetId([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'status' => 'pending',
            'user_id' => $userId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Task created successfully!');
    }

    /**
     * Show edit task form
     */
    public function edit($id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Get task using DB facade with user verification
        $task = DB::table('tasks')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$task) {
            return redirect()->route('dashboard')->with('error', 'Task not found!');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update task
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Update task using DB facade
        $updated = DB::table('tasks')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'priority' => $request->priority,
                'due_date' => $request->due_date,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return redirect()->route('dashboard')->with('success', 'Task updated successfully!');
        }

        return back()->with('error', 'Failed to update task!');
    }

    /**
     * Delete task
     */
    public function destroy($id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Delete task using DB facade
        $deleted = DB::table('tasks')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            return redirect()->route('dashboard')->with('success', 'Task deleted successfully!');
        }

        return back()->with('error', 'Failed to delete task!');
    }

    /**
     * Update task status via AJAX
     */
    public function updateStatus(Request $request, $id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Update task status using DB facade
        $updated = DB::table('tasks')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->update([
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to update status!']);
    }

    /**
     * Filter tasks by status
     */
    public function filterByStatus($status)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB HELPER IMPLEMENTATION - Filter tasks using DB facade
        $tasks = DB::table('tasks')
            ->where('user_id', $userId)
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        // DB HELPER IMPLEMENTATION - Get task statistics
        $taskStats = [
            'total' => DB::table('tasks')->where('user_id', $userId)->count(),
            'pending' => DB::table('tasks')->where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress' => DB::table('tasks')->where('user_id', $userId)->where('status', 'in_progress')->count(),
            'completed' => DB::table('tasks')->where('user_id', $userId)->where('status', 'completed')->count(),
        ];

        return view('dashboard', compact('tasks', 'taskStats'));
    }
}
