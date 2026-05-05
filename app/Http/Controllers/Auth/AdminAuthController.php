<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login page.
     */
    public function showLogin()
    {
        // If already authenticated as admin, go to dashboard
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Redirect to Google OAuth.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Handle callback from Google OAuth.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('admin.login')
                ->with('error', 'Google authentication failed. Please try again.');
        }

        // Find or create the user by google_id or email
        $user = User::where('google_id', $googleUser->getId())->first()
              ?? User::where('email', $googleUser->getEmail())->first();

        // Get admin emails from .env
        $adminEmails = explode(',', env('ADMIN_EMAILS', ''));
        $isAdminEmail = in_array($googleUser->getEmail(), array_map('trim', $adminEmails));

        if ($user) {
            // Update their Google info & avatar
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'name'      => $googleUser->getName(),
            ]);

            // If their email is in the admin list but they aren't admin, promote them
            if ($isAdminEmail && $user->role !== 'admin') {
                $user->update(['role' => 'admin']);
            }
        } else {
            // First-time login: create user
            $user = User::create([
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
                'role'      => $isAdminEmail ? 'admin' : 'user',
            ]);
        }

        // Only allow admin users to access the portal
        if (!$user->isAdmin()) {
            return redirect()->route('admin.login')
                ->with('error', 'Access denied. Your Google account (' . $googleUser->getEmail() . ') does not have admin privileges. Contact the system administrator.');
        }

        Auth::login($user, true);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Logout from admin portal.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'You have been logged out successfully.');
    }
}
