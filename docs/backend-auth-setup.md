# Backend Auth Setup

Dokumen ini melengkapi migration, model, middleware, dan route skeleton untuk sistem inventory organisasi.

## 1. Install Laravel Breeze

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install
npm run build
php artisan migrate
```

Jika memakai email verification, pastikan model `App\Models\User` mengimplementasikan `MustVerifyEmail` dan route yang butuh login memakai middleware `verified`.

File `routes/web.php` di proyek ini sudah memuat kerangka route auth Breeze yang umum dipakai. Jika Breeze membuat `routes/auth.php`, jangan require file tersebut lagi dari `web.php` kecuali route auth di `web.php` dipindahkan ke `auth.php` agar tidak terjadi duplikasi nama route.

## 2. Daftarkan Alias Middleware

Laravel 11/12 memakai `bootstrap/app.php`. Tambahkan alias berikut:

```php
use App\Http\Middleware\EnsureUserHasRole;
use App\Http\Middleware\RedirectAuthenticatedUserByRole;
use Illuminate\Foundation\Configuration\Middleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => EnsureUserHasRole::class,
        'redirect.authenticated.by.role' => RedirectAuthenticatedUserByRole::class,
    ]);
})
```

Untuk Laravel 10 ke bawah, daftarkan di `app/Http/Kernel.php`:

```php
protected $middlewareAliases = [
    'role' => \App\Http\Middleware\EnsureUserHasRole::class,
    'redirect.authenticated.by.role' => \App\Http\Middleware\RedirectAuthenticatedUserByRole::class,
];
```

## 3. Role Yang Dipakai

- `user`: anggota/peminjam biasa.
- `staff`: pengelola barang. Bisa edit barang, approve/reject request, dan tandai returned.
- `super-admin`: semua hak staff plus create/delete item dan manage role user.

Default user baru adalah `user`. Untuk akun staff pertama, update manual lewat tinker/database:

```bash
php artisan tinker
```

```php
\App\Models\User::where('email', 'staff@example.com')->update(['role' => 'staff']);
\App\Models\User::where('email', 'admin@example.com')->update(['role' => 'super-admin']);
```

## 4. Install Laravel Socialite

```bash
composer require laravel/socialite
```

Tambahkan konfigurasi Google di `.env`:

```env
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

Tambahkan service di `config/services.php`:

```php
'google' => [
    'client_id' => env('GOOGLE_CLIENT_ID'),
    'client_secret' => env('GOOGLE_CLIENT_SECRET'),
    'redirect' => env('GOOGLE_REDIRECT_URI'),
],
```

## 5. Controller Google Auth

Buat controller:

```bash
php artisan make:controller Auth/GoogleAuthController
```

Implementasi dasar:

```php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName() ?: $googleUser->getNickname(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'email_verified_at' => now(),
                'password' => Str::password(32),
            ]
        );

        Auth::login($user, true);

        return $user->canAccessAdminDashboard()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}
```

## 6. Database Notifications

Gunakan Laravel database notifications untuk status request dan request baru ke staff/admin.

```bash
php artisan notifications:table
php artisan migrate
```

Notifikasi minimal yang disarankan:

- `BorrowRequestSubmittedNotification`: dikirim ke semua `staff` dan `super-admin`.
- `BorrowRequestStatusChangedNotification`: dikirim ke peminjam saat status berubah menjadi `approved`, `rejected`, atau `returned`.

Saat request disetujui, kurangi `items.quantity_available`. Saat request dikembalikan, tambahkan kembali. Status `pending` dan `rejected` tidak mengubah stok.
