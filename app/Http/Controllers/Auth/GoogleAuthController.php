<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrNew(['email' => $googleUser->getEmail()]);

        $user->fill([
            'name' => $user->exists ? $user->name : ($googleUser->getName() ?: $googleUser->getNickname()),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
            'email_verified_at' => $user->email_verified_at ?: now(),
            'role' => $user->role ?: User::ROLE_USER,
        ]);

        if (! $user->exists) {
            $user->password = Str::password(32);
        }

        $user->save();

        Auth::login($user, true);

        return $user->canAccessAdminDashboard()
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
}
