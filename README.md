# 📋 Task Management System

Sistem manajemen tugas berbasis web yang dibangun dengan Laravel dan Tailwind CSS. Aplikasi ini mendemonstrasikan implementasi **PHP Session**, **DB Helper**, dan **ORM Eloquent** dalam satu proyek yang terintegrasi.

## 🚀 Fitur Utama

- ✅ **Autentikasi Pengguna** (Login/Register)
- ✅ **Manajemen Tugas** (CRUD Operations)
- ✅ **Dashboard Interaktif** dengan statistik
- ✅ **Filter Tugas** berdasarkan status
- ✅ **Update Status Real-time** dengan AJAX
- ✅ **UI Responsif** dengan Tailwind CSS
- ✅ **Validasi Form** yang komprehensif

## 🔧 Implementasi Teknis

### 🔐 PHP SESSION IMPLEMENTATION

**Lokasi Implementasi:**
- `app/Http/Controllers/AuthController.php` (Baris 25-35, 50-60, 85-95)
- `app/Http/Middleware/AuthMiddleware.php` (Baris 15-20)
- `resources/views/layouts/app.blade.php` (Baris 35-40)

**Fitur Session:**
```php
// Login - Menyimpan data user ke session
session([
    'user_id' => $user->id,
    'user_name' => $user->name,
    'user_email' => $user->email,
    'is_logged_in' => true
]);

// Middleware - Pengecekan session untuk proteksi halaman
if (!session()->has('user_id') || !session()->get('is_logged_in')) {
    return redirect()->route('login');
}

// Logout - Menghapus semua data session
session()->flush();
session()->regenerate();
```

### 🗄️ DB HELPER IMPLEMENTATION

**Lokasi Implementasi:**
- `app/Http/Controllers/TaskController.php` (Baris 15-25, 45-55, 75-85, 105-115)

**Operasi Database:**
```php
// CREATE - Menambah tugas baru
DB::table('tasks')->insertGetId([
    'title' => $request->title,
    'description' => $request->description,
    'user_id' => session('user_id'),
    'created_at' => now()
]);

// READ - Mengambil data tugas dengan filter
DB::table('tasks')
    ->where('user_id', $userId)
    ->where('status', 'pending')
    ->orderBy('created_at', 'desc')
    ->get();

// UPDATE - Mengupdate status tugas
DB::table('tasks')
    ->where('id', $id)
    ->where('user_id', $userId)
    ->update(['status' => $newStatus]);

// DELETE - Menghapus tugas
DB::table('tasks')
    ->where('id', $id)
    ->where('user_id', $userId)
    ->delete();
```

### 📊 ORM ELOQUENT IMPLEMENTATION

**Lokasi Implementasi:**
- `app/Models/User.php` (Baris 35-65)
- `app/Http/Controllers/AuthController.php` (Baris 40-50, 70-80)

**Model Operations:**
```php
// CREATE - Membuat user baru
User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => bcrypt($data['password'])
]);

// READ - Mencari user berdasarkan email
User::where('email', $email)->first();

// VERIFY - Verifikasi kredensial user
User::verifyCredentials($email, $password);

// FIND - Mencari user berdasarkan ID
User::find($id);
```

## 📁 Struktur Proyek

```
task-management/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php      # 🔐 PHP Session Auth
│   │   │   └── TaskController.php      # 🗄️ DB Helper CRUD
│   │   └── Middleware/
│   │       └── AuthMiddleware.php      # 🔐 Session Protection
│   ├── Models/
│   │   └── User.php                    # 📊 ORM Eloquent Model
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   └── create_tasks_table.php
│   └── seeders/
│       └── DatabaseSeeder.php          # Data dummy
├── resources/
│   ├── css/
│   │   └── app.css                     # Tailwind CSS
│   ├── js/
│   │   └── app.js                      # JavaScript interaktif
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Layout utama
│       ├── auth/
│       │   ├── login.blade.php         # 🔐 Halaman login
│       │   └── register.blade.php      # 📊 Halaman register
│       ├── tasks/
│       │   ├── create.blade.php        # 🗄️ Form create task
│       │   └── edit.blade.php          # 🗄️ Form edit task
│       └── dashboard.blade.php         # Dashboard utama
├── routes/
│   └── web.php                         # Routing aplikasi
└── public/
    └── index.php                       # Entry point
```

## 🎨 UI Components (Tailwind CSS)

- **Cards**: Komponen kartu untuk menampilkan informasi
- **Buttons**: Tombol dengan berbagai varian (primary, secondary, success, danger)
- **Forms**: Input field, select, dan textarea yang responsif
- **Status Badges**: Label status dengan warna yang berbeda
- **Priority Indicators**: Indikator prioritas tugas
- **Responsive Grid**: Layout yang adaptif untuk berbagai ukuran layar

## 🔧 Instalasi & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd task-management
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Database Migration & Seeding
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Assets
```bash
npm run build
# atau untuk development
npm run dev
```

### 7. Start Server
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## 👤 Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@example.com | password |
| User 1 | john@example.com | password |
| User 2 | jane@example.com | password |

## 🧪 Testing

### Manual Testing
1. **Autentikasi**: Test login/register/logout
2. **Session**: Coba akses halaman protected tanpa login
3. **CRUD Tasks**: Create, read, update, delete tugas
4. **Filter**: Test filter berdasarkan status
5. **AJAX**: Test update status real-time

### Data Dummy
Database seeder menyediakan:
- 3 user demo
- 5 sample tasks dengan berbagai status dan prioritas

## 🎯 Highlight Implementasi

### 🔐 PHP Session Features
- Session-based authentication
- Middleware protection untuk halaman protected
- Auto-logout setelah timeout
- Session data untuk personalisasi UI

### 🗄️ DB Helper Features  
- Raw query menggunakan DB facade
- Complex filtering dan sorting
- Batch operations
- Transaction safety

### 📊 ORM Eloquent Features
- Model-based user management
- Eloquent relationships
- Mass assignment protection
- Custom model methods

## 📝 Catatan Pengembangan

- **Security**: Implementasi CSRF protection dan input validation
- **Performance**: Efficient database queries dengan proper indexing
- **UX**: Responsive design dengan loading states dan error handling
- **Code Quality**: Clean code dengan proper separation of concerns

## 🤝 Kontribusi

Proyek ini dibuat untuk tujuan pembelajaran. Silakan fork dan modifikasi sesuai kebutuhan.

---

**Dibuat dengan ❤️ menggunakan Laravel 10 & Tailwind CSS**
