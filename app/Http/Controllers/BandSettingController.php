<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateBandSettingRequest;
use App\Models\BandSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $validated['activarcontactoinfo'] = $request->boolean('activarcontactoinfo');

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

    public function generateContactQr(): RedirectResponse
    {
        $bandSetting = BandSetting::query()->first();

        if (! $bandSetting) {
            return redirect()
                ->route('band-settings.edit')
                ->with('error_message', __('Primero guarda los datos de la banda.'));
        }

        if (! $bandSetting->activarcontactoinfo) {
            return redirect()
                ->route('band-settings.edit')
                ->with('error_message', __('Debes activar el formulario público para generar el QR.'));
        }

        $baseUrl = rtrim((string) config('app.url'), '/');
        $targetUrl = $baseUrl.'/masinfo';

        try {
            $response = Http::timeout(20)
                ->retry(2, 200)
                ->get('https://quickchart.io/qr', [
                    'text' => $targetUrl,
                    'size' => 900,
                    'margin' => 2,
                    'ecLevel' => 'H',
                    'format' => 'png',
                ]);

            if (! $response->successful()) {
                return redirect()
                    ->route('band-settings.edit')
                    ->with('error_message', __('No se pudo generar el QR en este momento.'));
            }

            $qrBinary = $this->decorateQrImage(
                $response->body(),
                $bandSetting->nombre ?: config('app.name', 'eBand'),
                $bandSetting->logo
            );

            $path = 'imagenes/band/qr/contacto-masinfo-'.$bandSetting->id.'.png';
            Storage::disk('public')->put($path, $qrBinary);

            $bandSetting->qr_contacto_masinfo = $path;
            $bandSetting->save();

            return redirect()
                ->route('band-settings.edit')
                ->with('success_message', __('QR generado correctamente.'));
        } catch (\Throwable) {
            return redirect()
                ->route('band-settings.edit')
                ->with('error_message', __('No se pudo generar el QR en este momento.'));
        }
    }

    private function decorateQrImage(string $qrBinary, ?string $bandName, ?string $logoPath): string
    {
        if (! function_exists('imagecreatefromstring')) {
            return $qrBinary;
        }

        $qrImage = @imagecreatefromstring($qrBinary);

        if (! $qrImage) {
            return $qrBinary;
        }

        $width = imagesx($qrImage);
        $height = imagesy($qrImage);
        $extraHeight = 84;

        $canvas = imagecreatetruecolor($width, $height + $extraHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $textColor = imagecolorallocate($canvas, 31, 41, 55);
        imagefill($canvas, 0, 0, $white);
        imagecopy($canvas, $qrImage, 0, 0, 0, 0, $width, $height);

        if ($logoPath) {
            $fullLogoPath = Storage::disk('public')->path($logoPath);
            if (is_file($fullLogoPath)) {
                $logoBinary = @file_get_contents($fullLogoPath);
                $logoImage = $logoBinary ? @imagecreatefromstring($logoBinary) : false;

                if ($logoImage) {
                    $logoTarget = (int) floor($width * 0.18);
                    $logoX = (int) floor(($width - $logoTarget) / 2);
                    $logoY = (int) floor(($height - $logoTarget) / 2);
                    imagecopyresampled(
                        $canvas,
                        $logoImage,
                        $logoX,
                        $logoY,
                        0,
                        0,
                        $logoTarget,
                        $logoTarget,
                        imagesx($logoImage),
                        imagesy($logoImage)
                    );
                    imagedestroy($logoImage);
                }
            }
        }

        $name = Str::limit((string) ($bandName ?: config('app.name', 'eBand')), 32, '...');
        $subtitle = '/masinfo';

        $fontMain = 5;
        $fontSub = 3;
        $nameWidth = imagefontwidth($fontMain) * strlen($name);
        $subtitleWidth = imagefontwidth($fontSub) * strlen($subtitle);
        imagestring($canvas, $fontMain, (int) (($width - $nameWidth) / 2), $height + 18, $name, $textColor);
        imagestring($canvas, $fontSub, (int) (($width - $subtitleWidth) / 2), $height + 48, $subtitle, $textColor);

        ob_start();
        imagepng($canvas, null, 6);
        $finalBinary = (string) ob_get_clean();

        imagedestroy($qrImage);
        imagedestroy($canvas);

        return $finalBinary !== '' ? $finalBinary : $qrBinary;
    }
}
