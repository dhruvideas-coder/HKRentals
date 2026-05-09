<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('admin.profile.show', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|min:2|max:100',
        ]);

        $user->update(['name' => $request->name]);

        return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully.');
    }
}
