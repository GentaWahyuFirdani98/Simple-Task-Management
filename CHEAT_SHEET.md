# 🚀 Cheat Sheet: DB Raw vs DB Helper vs ORM Eloquent

## 📊 Quick Comparison

| Feature | DB Raw | DB Helper | ORM Eloquent |
|---------|--------|-----------|--------------|
| **Syntax** | SQL | Method chain | Object-oriented |
| **Security** | Manual | Auto-escape | Auto-escape |
| **Performance** | 🟢 High | 🟡 Medium | 🔴 Lower |
| **Learning** | 🔴 Hard | 🟡 Medium | 🟢 Easy |
| **Maintenance** | 🔴 Hard | 🟡 Medium | 🟢 Easy |

---

## 🔴 DB Raw - SQL Murni

### **Basic Operations:**
```php
// SELECT
$users = DB::select('SELECT * FROM users WHERE active = ?', [1]);

// INSERT
DB::insert('INSERT INTO users (name, email) VALUES (?, ?)', ['John', 'john@example.com']);

// UPDATE
DB::update('UPDATE users SET active = ? WHERE id = ?', [1, 5]);

// DELETE
DB::delete('DELETE FROM users WHERE id = ?', [5]);
```

### **Pros & Cons:**
- ✅ Maximum performance
- ✅ Full control
- ❌ SQL injection risk
- ❌ Hard to maintain

---

## 🟡 DB Helper - Query Builder

### **Basic CRUD:**
```php
// SELECT
$users = DB::table('users')->where('active', 1)->get();
$user = DB::table('users')->where('id', 1)->first();

// INSERT
$id = DB::table('users')->insertGetId([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// UPDATE
DB::table('users')->where('id', 1)->update(['active' => 1]);

// DELETE
DB::table('users')->where('id', 1)->delete();
```

### **Advanced Queries:**
```php
// WHERE conditions
DB::table('tasks')
    ->where('user_id', 1)
    ->where('status', 'pending')
    ->orWhere('priority', 'high')
    ->get();

// JOIN
DB::table('tasks')
    ->join('users', 'tasks.user_id', '=', 'users.id')
    ->select('tasks.*', 'users.name')
    ->get();

// GROUP BY & HAVING
DB::table('tasks')
    ->select('status', DB::raw('count(*) as total'))
    ->groupBy('status')
    ->having('total', '>', 1)
    ->get();

// ORDER BY & LIMIT
DB::table('tasks')
    ->orderBy('created_at', 'desc')
    ->limit(10)
    ->get();
```

### **Pros & Cons:**
- ✅ SQL injection safe
- ✅ Readable syntax
- ✅ Dynamic queries
- ⚠️ Medium performance

---

## 🟢 ORM Eloquent - Object-Relational Mapping

### **Model Setup:**
```php
class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];
    protected $casts = ['email_verified_at' => 'datetime'];
}
```

### **Basic CRUD:**
```php
// SELECT
$users = User::where('active', 1)->get();
$user = User::find(1);
$user = User::where('email', 'john@example.com')->first();

// INSERT
$user = User::create([
    'name' => 'John',
    'email' => 'john@example.com'
]);

// UPDATE
$user = User::find(1);
$user->update(['active' => 1]);
// OR
User::where('id', 1)->update(['active' => 1]);

// DELETE
$user = User::find(1);
$user->delete();
// OR
User::where('id', 1)->delete();
```

### **Advanced Features:**
```php
// Relationships
class User extends Model {
    public function tasks() {
        return $this->hasMany(Task::class);
    }
}

// Eager Loading
$users = User::with('tasks')->get();

// Scopes
class User extends Model {
    public function scopeActive($query) {
        return $query->where('active', 1);
    }
}
$activeUsers = User::active()->get();

// Accessors & Mutators
public function getFullNameAttribute() {
    return $this->first_name . ' ' . $this->last_name;
}

public function setPasswordAttribute($value) {
    $this->attributes['password'] = bcrypt($value);
}
```

### **Pros & Cons:**
- ✅ Very easy to use
- ✅ Rich features
- ✅ Rapid development
- ❌ Performance overhead

---

## 🎯 Project Implementation Examples

### **User Management (ORM Eloquent):**
```php
// File: app/Models/User.php
public static function createUser($data)
{
    return self::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
    ]);
}

public static function verifyCredentials($email, $password)
{
    $user = self::where('email', $email)->first();
    return $user && password_verify($password, $user->password) ? $user : false;
}
```

### **Task Management (DB Helper):**
```php
// File: app/Http/Controllers/TaskController.php

// Get tasks with stats
$tasks = DB::table('tasks')
    ->where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->get();

$taskStats = [
    'total' => DB::table('tasks')->where('user_id', $userId)->count(),
    'pending' => DB::table('tasks')->where('user_id', $userId)->where('status', 'pending')->count(),
];

// Create task
$taskId = DB::table('tasks')->insertGetId([
    'title' => $request->title,
    'user_id' => $userId,
    'created_at' => now(),
]);

// Update task
DB::table('tasks')
    ->where('id', $id)
    ->where('user_id', $userId)
    ->update(['status' => $request->status]);
```

---

## 🔒 Security Best Practices

### **SQL Injection Prevention:**
```php
// ❌ NEVER do this
$email = $_POST['email'];
DB::select("SELECT * FROM users WHERE email = '$email'");

// ✅ Always use parameter binding
DB::select('SELECT * FROM users WHERE email = ?', [$email]);
DB::table('users')->where('email', $email)->get();
User::where('email', $email)->get();
```

### **Mass Assignment Protection:**
```php
// Model protection
class User extends Model {
    protected $fillable = ['name', 'email']; // Whitelist
    protected $guarded = ['id', 'admin'];    // Blacklist
}

// Controller validation
$validated = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
]);
```

---

## 🚀 Performance Tips

### **DB Helper Optimization:**
```php
// Use select() to limit columns
DB::table('users')->select('id', 'name')->get();

// Use chunk() for large datasets
DB::table('users')->chunk(100, function ($users) {
    foreach ($users as $user) {
        // Process user
    }
});

// Use exists() instead of count()
if (DB::table('users')->where('email', $email)->exists()) {
    // User exists
}
```

### **Eloquent Optimization:**
```php
// Eager loading to prevent N+1
User::with('tasks')->get();

// Use select() to limit columns
User::select('id', 'name')->get();

// Use cursor() for memory efficiency
foreach (User::cursor() as $user) {
    // Process user
}
```

---

## 🎯 Decision Matrix

### **Choose DB Raw when:**
- Maximum performance needed
- Complex queries with multiple JOINs
- Working with stored procedures
- Database-specific features required

### **Choose DB Helper when:**
- Dynamic query building
- Simple to medium complexity
- No complex relationships
- **Example: Task CRUD operations**

### **Choose ORM Eloquent when:**
- Rapid development needed
- Complex model relationships
- Rich feature requirements
- **Example: User authentication**

---

## 📝 Quick Reference Commands

### **Common DB Helper Methods:**
```php
->where('column', 'value')
->orWhere('column', 'value')
->whereIn('column', [1, 2, 3])
->whereBetween('column', [1, 100])
->whereNull('column')
->orderBy('column', 'desc')
->groupBy('column')
->having('count', '>', 1)
->limit(10)
->offset(20)
->join('table', 'column1', '=', 'column2')
->leftJoin('table', 'column1', '=', 'column2')
```

### **Common Eloquent Methods:**
```php
Model::all()
Model::find($id)
Model::where('column', 'value')->get()
Model::create($data)
Model::update($data)
Model::delete()
Model::with('relation')->get()
Model::has('relation')->get()
Model::whereHas('relation', function($q) {})
```

---

**💡 Remember: The best approach depends on your specific use case. This project demonstrates using the right tool for the right job!**
