<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaskRawController extends Controller
{
    /**
     * Display dashboard with tasks using DB Raw
     */
    public function dashboard()
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');
        
        // DB RAW IMPLEMENTATION - Get tasks using raw SQL
        $tasks = DB::select('
            SELECT id, title, description, status, priority, due_date, created_at, updated_at 
            FROM tasks 
            WHERE user_id = ? 
            ORDER BY created_at DESC
        ', [$userId]);

        // DB RAW IMPLEMENTATION - Get task statistics using raw SQL
        $taskStatsRaw = DB::select('
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed
            FROM tasks 
            WHERE user_id = ?
        ', [$userId]);

        // Convert to array format for view compatibility
        $taskStats = [
            'total' => $taskStatsRaw[0]->total ?? 0,
            'pending' => $taskStatsRaw[0]->pending ?? 0,
            'in_progress' => $taskStatsRaw[0]->in_progress ?? 0,
            'completed' => $taskStatsRaw[0]->completed ?? 0,
        ];

        return view('dashboard-raw', compact('tasks', 'taskStats'));
    }

    /**
     * Store a new task using DB Raw
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

        // DB RAW IMPLEMENTATION - Insert new task using raw SQL
        $result = DB::insert('
            INSERT INTO tasks (title, description, priority, due_date, status, user_id, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ', [
            $request->title,
            $request->description,
            $request->priority,
            $request->due_date,
            'pending',
            $userId,
            now(),
            now()
        ]);

        if ($result) {
            return redirect()->route('dashboard.raw')->with('success', 'Task created successfully with DB Raw!');
        }

        return back()->with('error', 'Failed to create task!');
    }

    /**
     * Show edit task form using DB Raw
     */
    public function edit($id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Get task using raw SQL with user verification
        $tasks = DB::select('
            SELECT id, title, description, status, priority, due_date, created_at, updated_at 
            FROM tasks 
            WHERE id = ? AND user_id = ? 
            LIMIT 1
        ', [$id, $userId]);

        if (empty($tasks)) {
            return redirect()->route('dashboard.raw')->with('error', 'Task not found!');
        }

        $task = $tasks[0]; // Get first (and only) result

        return view('tasks.edit-raw', compact('task'));
    }

    /**
     * Update task using DB Raw
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

        // DB RAW IMPLEMENTATION - Update task using raw SQL
        $updated = DB::update('
            UPDATE tasks 
            SET title = ?, description = ?, status = ?, priority = ?, due_date = ?, updated_at = ? 
            WHERE id = ? AND user_id = ?
        ', [
            $request->title,
            $request->description,
            $request->status,
            $request->priority,
            $request->due_date,
            now(),
            $id,
            $userId
        ]);

        if ($updated) {
            return redirect()->route('dashboard.raw')->with('success', 'Task updated successfully with DB Raw!');
        }

        return back()->with('error', 'Failed to update task!');
    }

    /**
     * Delete task using DB Raw
     */
    public function destroy($id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Delete task using raw SQL
        $deleted = DB::delete('
            DELETE FROM tasks 
            WHERE id = ? AND user_id = ?
        ', [$id, $userId]);

        if ($deleted) {
            return redirect()->route('dashboard.raw')->with('success', 'Task deleted successfully with DB Raw!');
        }

        return back()->with('error', 'Failed to delete task!');
    }

    /**
     * Update task status via AJAX using DB Raw
     */
    public function updateStatus(Request $request, $id)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Update task status using raw SQL
        $updated = DB::update('
            UPDATE tasks 
            SET status = ?, updated_at = ? 
            WHERE id = ? AND user_id = ?
        ', [
            $request->status,
            now(),
            $id,
            $userId
        ]);

        if ($updated) {
            return response()->json(['success' => true, 'message' => 'Status updated successfully with DB Raw!']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to update status!']);
    }

    /**
     * Filter tasks by status using DB Raw
     */
    public function filterByStatus($status)
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Filter tasks using raw SQL
        $tasks = DB::select('
            SELECT id, title, description, status, priority, due_date, created_at, updated_at 
            FROM tasks 
            WHERE user_id = ? AND status = ? 
            ORDER BY created_at DESC
        ', [$userId, $status]);

        // DB RAW IMPLEMENTATION - Get task statistics using raw SQL
        $taskStatsRaw = DB::select('
            SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed
            FROM tasks 
            WHERE user_id = ?
        ', [$userId]);

        // Convert to array format for view compatibility
        $taskStats = [
            'total' => $taskStatsRaw[0]->total ?? 0,
            'pending' => $taskStatsRaw[0]->pending ?? 0,
            'in_progress' => $taskStatsRaw[0]->in_progress ?? 0,
            'completed' => $taskStatsRaw[0]->completed ?? 0,
        ];

        return view('dashboard-raw', compact('tasks', 'taskStats'));
    }

    /**
     * Advanced query example - Get tasks with complex conditions using DB Raw
     */
    public function getTasksWithComplexConditions()
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Complex query with multiple JOINs and conditions
        $tasks = DB::select('
            SELECT 
                t.id,
                t.title,
                t.description,
                t.status,
                t.priority,
                t.due_date,
                t.created_at,
                u.name as user_name,
                CASE 
                    WHEN t.due_date < CURDATE() AND t.status != "completed" THEN "overdue"
                    WHEN t.due_date = CURDATE() AND t.status != "completed" THEN "due_today"
                    ELSE "normal"
                END as urgency_status,
                DATEDIFF(t.due_date, CURDATE()) as days_until_due
            FROM tasks t
            INNER JOIN users u ON t.user_id = u.id
            WHERE t.user_id = ?
            AND (
                t.status = "pending" 
                OR (t.status = "in_progress" AND t.priority = "high")
            )
            ORDER BY 
                CASE t.priority 
                    WHEN "high" THEN 1 
                    WHEN "medium" THEN 2 
                    WHEN "low" THEN 3 
                END,
                t.due_date ASC,
                t.created_at DESC
        ', [$userId]);

        return response()->json([
            'success' => true,
            'data' => $tasks,
            'message' => 'Complex query executed with DB Raw'
        ]);
    }

    /**
     * Get task statistics with advanced aggregation using DB Raw
     */
    public function getAdvancedStatistics()
    {
        // PHP SESSION IMPLEMENTATION - Get current user from session
        $userId = session('user_id');

        // DB RAW IMPLEMENTATION - Advanced statistics query
        $stats = DB::select('
            SELECT 
                COUNT(*) as total_tasks,
                COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_tasks,
                COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_tasks,
                COUNT(CASE WHEN status = "in_progress" THEN 1 END) as in_progress_tasks,
                COUNT(CASE WHEN due_date < CURDATE() AND status != "completed" THEN 1 END) as overdue_tasks,
                COUNT(CASE WHEN priority = "high" THEN 1 END) as high_priority_tasks,
                AVG(CASE WHEN status = "completed" THEN DATEDIFF(updated_at, created_at) END) as avg_completion_days,
                MIN(created_at) as first_task_date,
                MAX(created_at) as latest_task_date
            FROM tasks 
            WHERE user_id = ?
        ', [$userId]);

        return response()->json([
            'success' => true,
            'statistics' => $stats[0],
            'message' => 'Advanced statistics generated with DB Raw'
        ]);
    }
}
