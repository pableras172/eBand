<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBandSettingRequest;
use App\Models\BandSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BandSettingController extends Controller
{
    public function edit(): View
    {
        $bandSetting = BandSetting::query()->first() ?? new BandSetting;

        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        return view('band-settings.edit', [
            'bandSetting' => $bandSetting,
            'users' => $users,
        ]);
    }

    public function update(UpdateBandSettingRequest $request): RedirectResponse
    {
        $bandSetting = BandSetting::query()->first() ?? new BandSetting;
        $validated = $request->validated();

        if ($request->hasFile('logo')) {
            if ($bandSetting->logo) {
                Storage::disk('public')->delete($bandSetting->logo);
            }

            $validated['logo'] = $request->file('logo')->store('imagenes/band', 'public');
        }

        $bandSetting->fill($validated);
        $bandSetting->save();

        return redirect()
            ->route('band-settings.edit')
            ->with('success_message', __('Datos de la banda actualizados correctamente.'));
    }
}
