<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        try {
            if (auth()->check() && auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return view('admin.auth.login');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.auth.login');
        }
    }

    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->with(['prompt' => 'select_account'])
                ->redirect();
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.login')->with('error', 'Could not initiate Google login. Please try again.');
        }
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.login')->with('error', 'Google authentication failed. Please try again.');
        }

        try {
            $adminEmails = explode(',', env('ADMIN_EMAILS', ''));
            $isAdminEmail = in_array($googleUser->getEmail(), array_map('trim', $adminEmails));

            if (!$isAdminEmail) {
                return redirect()->route('admin.login')
                    ->with('error', 'You are not a registered Admin user. Please contact the administrator.');
            }

            $avatar = $googleUser->getAvatar();
            if (strlen($avatar) > 255) {
                $avatar = null;
            }

            $user = User::where('google_id', $googleUser->getId())->first()
                  ?? User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $avatar,
                    'name'      => $googleUser->getName(),
                ]);

                if ($isAdminEmail && $user->role !== 'admin') {
                    $user->update(['role' => 'admin']);
                }
            } else {
                $user = User::create([
                    'name'      => $googleUser->getName(),
                    'email'     => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar'    => $avatar,
                    'role'      => $isAdminEmail ? 'admin' : 'user',
                ]);
            }

            if (!$user->isAdmin()) {
                return redirect()->route('admin.login')
                    ->with('error', 'You are not a registered Admin user. Please contact the administrator.');
            }

            Auth::login($user, true);

            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . $user->name . '!');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.login')->with('error', 'An error occurred during login. Please try again.');
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('home')->with('success', 'You have been logged out successfully.');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('home');
        }
    }
}
