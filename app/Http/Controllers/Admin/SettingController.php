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
                'charge_per_mile'        => 1.00,
                'max_delivery_distance'  => 50.00,
                'tax_rate'               => 9.25,
                'email_content'          => Setting::emailDefaults(),
            ]);

            $emailDefaults = Setting::emailDefaults();

            return view('admin.settings.index', compact('settings', 'emailDefaults'));
        } catch (\Throwable $e) {
            $this->logError(__FUNCTION__, $e);
            return redirect()->route('admin.dashboard')->with('error', 'Could not load settings.');
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'godown_address'                  => 'required|string|max:255',
                'godown_lat'                      => 'nullable|string',
                'godown_lng'                      => 'nullable|string',
                'charge_per_mile'                 => 'required|numeric|min:0',
                'max_delivery_distance'           => 'required|numeric|min:0',
                'tax_rate'                        => 'required|numeric|min:0|max:100',
                'email_content.subject'           => 'required|string|max:255',
                'email_content.body'              => 'required|string|max:3000',
            ]);

            $settings = Setting::first() ?? new Setting();

            $settings->godown_address        = $request->godown_address;
            $settings->godown_lat            = $request->godown_lat;
            $settings->godown_lng            = $request->godown_lng;
            $settings->charge_per_mile       = $request->charge_per_mile;
            $settings->max_delivery_distance = $request->max_delivery_distance;
            $settings->tax_rate              = $request->tax_rate;
            $settings->email_content         = $request->input('email_content');
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
