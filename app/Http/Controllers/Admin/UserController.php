<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                return redirect()->route('admin.users.index')->with('error', 'Unauthorized access. Only Super Admins can manage users.');
            }
            return $next($request);
        })->except(['index']);
    }

    public function index()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->paginate(15);
            return view('admin.users.index', compact('users'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return view('admin.users.index', ['users' => collect(), 'error' => 'Could not load users.']);
        }
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'role'  => ['required', Rule::in(['super_admin', 'admin', 'member'])],
            ]);

            User::create([
                'name'  => $request->name,
                'email' => $request->email,
                'role'  => $request->role,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not create user. Please try again.');
        }
    }

    public function edit(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'You cannot edit your own role here. Use profile settings.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')->with('error', 'You cannot update your own role here.');
            }

            $request->validate([
                'name'  => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'role'  => ['required', Rule::in(['super_admin', 'admin', 'member'])],
            ]);

            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
                'role'  => $request->role,
            ]);

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['user_id' => $user->id]);
            return redirect()->back()->withInput()->with('error', 'Could not update user. Please try again.');
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
            }

            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e, ['user_id' => $user->id]);
            return redirect()->back()->with('error', 'Could not delete user. Please try again.');
        }
    }
}
