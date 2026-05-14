<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $settings = Setting::firstOrCreate([], [
                'godown_address'         => '',
                'godown_lat'             => '',
                'godown_lng'             => '',
                'free_delivery_distance' => 5.00,
                'charge_per_km'          => 1.00,
            ]);

            return view('admin.settings.index', compact('settings'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.dashboard')->with('error', 'Could not load settings.');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'godown_address'         => 'required|string|max:255',
                'godown_lat'             => 'nullable|string',
                'godown_lng'             => 'nullable|string',
                'free_delivery_distance' => 'required|numeric|min:0',
                'charge_per_km'          => 'required|numeric|min:0',
            ]);

            $settings = Setting::first() ?? new Setting();
            $settings->fill($request->all());
            $settings->save();

            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->back()->withInput()->with('error', 'Could not save settings. Please try again.');
        }
    }
}
