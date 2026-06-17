<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
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

    public function generateContactQr()
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

        $targetUrl = route('masinfo.create');

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

            return response()->streamDownload(function () use ($qrBinary): void {
                echo $qrBinary;
            }, 'masinfo-qr.png', [
                'Content-Type' => 'image/png',
            ]);
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

        $qrWidth = imagesx($qrImage);
        $qrHeight = imagesy($qrImage);

        // space reserved for logo above the QR (clamped)
        $logoAreaHeight = (int) floor($qrHeight * 0.18);
        $logoAreaHeight = max(60, min(180, $logoAreaHeight));
        $topPadding = $logoAreaHeight + 20; // extra spacing above QR
        $bottomArea = 84; // space for name and subtitle

        $canvasWidth = $qrWidth;
        $canvasHeight = $topPadding + $qrHeight + $bottomArea;

        $canvas = imagecreatetruecolor($canvasWidth, $canvasHeight);
        $white = imagecolorallocate($canvas, 255, 255, 255);
        $textColor = imagecolorallocate($canvas, 31, 41, 55);
        imagefill($canvas, 0, 0, $white);

        // Place logo centered in the top area (if provided)
        if ($logoPath) {
            $fullLogoPath = Storage::disk('public')->path($logoPath);
            if (is_file($fullLogoPath)) {
                $logoBinary = @file_get_contents($fullLogoPath);
                $logoImage = $logoBinary ? @imagecreatefromstring($logoBinary) : false;

                if ($logoImage) {
                    $logoOrigW = imagesx($logoImage);
                    $logoOrigH = imagesy($logoImage);

                    $maxLogoW = (int) floor($qrWidth * 0.6);
                    $maxLogoH = $logoAreaHeight;

                    $ratio = min($maxLogoW / $logoOrigW, $maxLogoH / $logoOrigH, 1);
                    $logoTargetW = (int) floor($logoOrigW * $ratio);
                    $logoTargetH = (int) floor($logoOrigH * $ratio);

                    $logoX = (int) floor(($canvasWidth - $logoTargetW) / 2);
                    $logoY = (int) floor(($topPadding - $logoTargetH) / 2);

                    imagecopyresampled(
                        $canvas,
                        $logoImage,
                        $logoX,
                        $logoY,
                        0,
                        0,
                        $logoTargetW,
                        $logoTargetH,
                        $logoOrigW,
                        $logoOrigH
                    );

                    imagedestroy($logoImage);
                }
            }
        }

        // Copy QR below the top area
        imagecopy($canvas, $qrImage, 0, $topPadding, 0, 0, $qrWidth, $qrHeight);

        // Add band name and URL under the QR
        $name = Str::limit((string) ($bandName ?: config('app.name', 'eBand')), 32, '...');
        $subtitle = url('/masinfo');

        $fontMain = 5;
        $fontSub = 3;
        $nameWidth = imagefontwidth($fontMain) * strlen($name);
        $subtitleWidth = imagefontwidth($fontSub) * strlen($subtitle);

        imagestring($canvas, $fontMain, (int) (($canvasWidth - $nameWidth) / 2), $topPadding + $qrHeight + 12, $name, $textColor);
        imagestring($canvas, $fontSub, (int) (($canvasWidth - $subtitleWidth) / 2), $topPadding + $qrHeight + 36, $subtitle, $textColor);

        ob_start();
        imagepng($canvas, null, 6);
        $finalBinary = (string) ob_get_clean();

        imagedestroy($qrImage);
        imagedestroy($canvas);

        return $finalBinary !== '' ? $finalBinary : $qrBinary;
    }
}
