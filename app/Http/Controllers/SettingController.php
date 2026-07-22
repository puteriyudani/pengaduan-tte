<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        return view('setting.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'no_wa' => ['required', 'string', 'max:20'],
        ]);

        foreach ($validated as $key => $value) {
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                [
                    'value' => $value,
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()
            ->back()
            ->with('success', 'Setting berhasil disimpan');
    }
}
