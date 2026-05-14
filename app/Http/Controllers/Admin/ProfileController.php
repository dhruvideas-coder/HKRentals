<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        try {
            return view('admin.profile.show', ['user' => auth()->user()]);
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.dashboard')->with('error', 'Could not load profile.');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:2|max:100',
            ]);

            auth()->user()->update(['name' => $request->name]);

            return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not update profile. Please try again.');
        }
    }
}
