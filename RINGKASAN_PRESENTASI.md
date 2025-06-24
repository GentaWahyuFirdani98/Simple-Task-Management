# 🎯 Ringkasan Presentasi: Database Access Patterns

## 📋 Slide 1: Pengenalan Konsep

### **3 Cara Akses Database di Laravel:**

| Method | Deskripsi | Level Abstraksi |
|--------|-----------|-----------------|
| **DB Raw** | SQL murni | Rendah |
| **DB Helper** | Query Builder | Menengah |
| **ORM Eloquent** | Object-Relational Mapping | Tinggi |

---

## 📋 Slide 2: DB Raw (Raw SQL)

### **Karakteristik:**
- ✅ **Performa tertinggi**
- ✅ **Kontrol penuh atas query**
- ❌ **Rawan SQL injection**
- ❌ **Sulit maintenance**

### **Contoh Sintaks:**
```php
// SELECT
$users = DB::select('SELECT * FROM users WHERE email = ?', ['admin@example.com']);

// INSERT
DB::insert('INSERT INTO tasks (title, user_id) VALUES (?, ?)', ['New Task', 1]);

// UPDATE
DB::update('UPDATE tasks SET status = ? WHERE id = ?', ['completed', 1]);

// DELETE
DB::delete('DELETE FROM tasks WHERE id = ?', [1]);
```

### **Kapan Digunakan:**
- Query sangat kompleks
- Optimasi performa kritis
- Stored procedures

---

## 📋 Slide 3: DB Helper (Query Builder)

### **Karakteristik:**
- ✅ **Aman dari SQL injection**
- ✅ **Sintaks mudah dibaca**
- ✅ **Query dinamis**
- ⚠️ **Performa menengah**

### **Contoh dari Project Kita:**
```php
// READ - Ambil tasks user
$tasks = DB::table('tasks')
    ->where('user_id', $userId)
    ->orderBy('created_at', 'desc')
    ->get();

// CREATE - Tambah task baru
$taskId = DB::table('tasks')->insertGetId([
    'title' => $request->title,
    'user_id' => $userId,
    'created_at' => now(),
]);

// UPDATE - Update task
DB::table('tasks')
    ->where('id', $id)
    ->where('user_id', $userId)
    ->update(['status' => 'completed']);

// DELETE - Hapus task
DB::table('tasks')
    ->where('id', $id)
    ->where('user_id', $userId)
    ->delete();
```

### **Implementasi di Project:**
- **File**: `app/Http/Controllers/TaskController.php`
- **Fungsi**: Task CRUD operations
- **Alasan**: Query dinamis, tidak butuh relationship

---

## 📋 Slide 4: ORM Eloquent

### **Karakteristik:**
- ✅ **Sangat mudah digunakan**
- ✅ **Fitur lengkap (relationships, events)**
- ✅ **Rapid development**
- ❌ **Overhead performa**

### **Contoh dari Project Kita:**
```php
// Model Definition
class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'password'];
    
    // Custom method
    public static function createUser($data)
    {
        return self::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }
}

// Penggunaan di Controller
$user = User::verifyCredentials($email, $password);
$newUser = User::createUser($userData);
```

### **Implementasi di Project:**
- **File**: `app/Models/User.php` & `app/Http/Controllers/AuthController.php`
- **Fungsi**: User management & authentication
- **Alasan**: Built-in auth features, security

---

## 📋 Slide 5: Perbandingan Praktis

### **Skenario: Ambil Data User**

#### **DB Raw:**
```php
$user = DB::select('SELECT * FROM users WHERE email = ? AND active = 1', [$email]);
```

#### **DB Helper:**
```php
$user = DB::table('users')
    ->where('email', $email)
    ->where('active', 1)
    ->first();
```

#### **ORM Eloquent:**
```php
$user = User::where('email', $email)
    ->where('active', 1)
    ->first();
```

### **Analisis:**
- **Raw**: Paling cepat, tapi manual escape
- **Helper**: Balance antara performa dan kemudahan
- **Eloquent**: Paling mudah, tapi overhead model

---

## 📋 Slide 6: Implementasi di Project Task Management

### **Strategi Pemilihan:**

#### **🔐 User Management → ORM Eloquent**
**Alasan:**
- Butuh fitur authentication Laravel
- Password hashing otomatis
- Built-in security features

**Contoh:**
```php
// Registration dengan auto-hashing
User::create([
    'name' => $request->name,
    'email' => $request->email,
    'password' => $request->password, // Auto-hashed
]);
```

#### **🗄️ Task Management → DB Helper**
**Alasan:**
- Query dinamis (filter, sorting)
- Performa lebih baik untuk CRUD
- Tidak butuh relationship kompleks

**Contoh:**
```php
// Query dinamis berdasarkan filter
$query = DB::table('tasks')->where('user_id', $userId);

if ($status) $query->where('status', $status);
if ($priority) $query->where('priority', $priority);

$tasks = $query->orderBy('created_at', 'desc')->get();
```

---

## 📋 Slide 7: Keamanan & Best Practices

### **SQL Injection Protection:**

#### **❌ Vulnerable (Raw tanpa parameter):**
```php
$email = $_POST['email'];
$users = DB::select("SELECT * FROM users WHERE email = '$email'");
// Rawan: admin@test.com' OR '1'='1
```

#### **✅ Secure (Semua method dengan parameter):**
```php
// Raw dengan parameter binding
$users = DB::select('SELECT * FROM users WHERE email = ?', [$email]);

// Helper otomatis escape
$users = DB::table('users')->where('email', $email)->get();

// Eloquent otomatis escape
$users = User::where('email', $email)->get();
```

### **Mass Assignment Protection:**
```php
// ORM Eloquent - Built-in protection
class User extends Model {
    protected $fillable = ['name', 'email']; // Whitelist
    protected $guarded = ['id', 'password']; // Blacklist
}
```

---

## 📋 Slide 8: Performance Benchmark

### **Estimasi Performa (Relatif):**
```
DB Raw:      ████████████████████ 100%
DB Helper:   ████████████████░░░░  85%
ORM Eloquent: ██████████████░░░░░░  75%
```

### **Development Speed:**
```
ORM Eloquent: ████████████████████ 100%
DB Helper:    ████████████████░░░░  80%
DB Raw:       ████████████░░░░░░░░  60%
```

### **Trade-off:**
- **Performa tinggi** = Development lambat
- **Development cepat** = Overhead performa

---

## 📋 Slide 9: Kapan Menggunakan Apa?

### **Decision Tree:**

```
Butuh performa maksimal? 
├─ Ya → DB Raw
└─ Tidak
   ├─ Butuh relationship kompleks?
   │  ├─ Ya → ORM Eloquent
   │  └─ Tidak → DB Helper
   └─ Rapid development?
      ├─ Ya → ORM Eloquent
      └─ Tidak → DB Helper
```

### **Real-world Guidelines:**
- **Startup/MVP**: ORM Eloquent (speed to market)
- **Enterprise**: Mix (sesuai kebutuhan)
- **High-traffic**: DB Raw untuk bottleneck
- **CRUD Apps**: DB Helper

---

## 📋 Slide 10: Demo Live Coding

### **Showcase Project Features:**

1. **Login (ORM)**: `User::verifyCredentials()`
2. **Dashboard (Helper)**: `DB::table('tasks')->where()`
3. **Create Task (Helper)**: `DB::table('tasks')->insert()`
4. **Filter Tasks (Helper)**: Dynamic query building

### **Highlight Comments:**
```php
// PHP SESSION IMPLEMENTATION
// DB HELPER IMPLEMENTATION  
// ORM IMPLEMENTATION
```

---

## 🎯 Key Takeaways

1. **Tidak ada solusi one-size-fits-all**
2. **Pilih berdasarkan kebutuhan spesifik**
3. **Kombinasi pendekatan = optimal**
4. **Security selalu prioritas**
5. **Performance vs Development speed trade-off**

### **Project ini mendemonstrasikan:**
- ✅ **Penggunaan yang tepat** untuk setiap pendekatan
- ✅ **Best practices** keamanan
- ✅ **Real-world implementation**
- ✅ **Clear separation of concerns**
