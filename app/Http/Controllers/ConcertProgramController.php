<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConcertProgramRequest;
use App\Http\Requests\UpdateConcertProgramRequest;
use App\Models\BandSetting;
use App\Models\ConcertProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConcertProgramController extends Controller
{
    public function index(): View
    {
        $this->authorize('admin');

        $programs = ConcertProgram::query()
            ->withCount('pieces')
            ->orderByDesc('is_featured')
            ->orderByDesc('is_published')
            ->orderByDesc('event_date')
            ->orderByDesc('event_time')
            ->paginate(15);

        return view('concert-programs.index', [
            'programs' => $programs,
        ]);
    }

    public function create(): View
    {
        $this->authorize('admin');

        return view('concert-programs.create', [
            'program' => new ConcertProgram,
            'repertoire' => [],
        ]);
    }

    public function store(StoreConcertProgramRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $isPublished = $request->boolean('is_published');
        $isFeatured = $isPublished && $request->boolean('is_featured');

        $program = new ConcertProgram;
        $program->fill($this->extractProgramData($validated, $isPublished, $isFeatured));
        $this->syncUploadedFiles($program, $request->file('image'), $request->file('logo_1'), $request->file('logo_2'), $request->file('logo_3'));
        $program->save();

        $this->syncFeaturedProgram($program);
        $this->syncRepertoire($program, $validated['repertoire']);

        return redirect()
            ->route('concert-programs.index')
            ->with('success_message', __('Programa de concierto creado correctamente.'));
    }

    public function edit(ConcertProgram $concertProgram): View
    {
        $this->authorize('admin');

        $concertProgram->load('pieces');

        return view('concert-programs.edit', [
            'program' => $concertProgram,
            'repertoire' => $concertProgram->pieces->map(function ($piece): array {
                return [
                    'title' => $piece->title,
                    'author' => $piece->author,
                    'details' => $piece->details,
                    'url' => $piece->url,
                    'sort_order' => $piece->sort_order,
                ];
            })->values()->all(),
        ]);
    }

    public function update(UpdateConcertProgramRequest $request, ConcertProgram $concertProgram): RedirectResponse
    {
        $validated = $request->validated();
        $isPublished = $request->boolean('is_published');
        $isFeatured = $isPublished && $request->boolean('is_featured');

        $concertProgram->fill($this->extractProgramData($validated, $isPublished, $isFeatured));
        $this->syncUploadedFiles($concertProgram, $request->file('image'), $request->file('logo_1'), $request->file('logo_2'), $request->file('logo_3'));
        $concertProgram->save();

        $this->syncFeaturedProgram($concertProgram);
        $concertProgram->pieces()->delete();
        $this->syncRepertoire($concertProgram, $validated['repertoire']);

        return redirect()
            ->route('concert-programs.edit', $concertProgram)
            ->with('success_message', __('Programa de concierto actualizado correctamente.'));
    }

    public function destroy(ConcertProgram $concertProgram): RedirectResponse
    {
        $this->authorize('admin');

        $this->deleteProgramFiles($concertProgram);
        $concertProgram->delete();

        return redirect()
            ->route('concert-programs.index')
            ->with('success_message', __('Programa de concierto eliminado correctamente.'));
    }

    public function publicProgram(): View
    {
        $program = $this->resolvePublicProgram();

        return view('public.concert-program', [
            'program' => $program,
        ]);
    }

    public function publicPoster(): View
    {
        $program = $this->resolvePublicProgram();

        return view('public.concert-program-poster', [
            'program' => $program,
            'isAdminPreview' => false,
        ]);
    }

    public function poster(ConcertProgram $concertProgram): View
    {
        $this->authorize('admin');

        $concertProgram->load('pieces');

        return view('public.concert-program-poster', [
            'program' => $concertProgram,
            'isAdminPreview' => true,
        ]);
    }

    public function downloadPublicQr()
    {
        $this->authorize('admin');

        $targetUrl = route('concert-programs.public');
        $bandSetting = BandSetting::query()->first();

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
                    ->route('concert-programs.index')
                    ->with('error_message', __('No se pudo generar el QR en este momento.'));
            }

            $binary = $response->body();

            if ($binary === '') {
                return redirect()
                    ->route('concert-programs.index')
                    ->with('error_message', __('No se pudo generar el QR en este momento.'));
            }

            $binary = $this->decorateQrImage(
                $binary,
                $bandSetting?->nombre ?: config('app.name', 'eBand'),
                $bandSetting?->logo,
                $targetUrl
            );

            return response()->streamDownload(function () use ($binary): void {
                echo $binary;
            }, 'programa-concierto-qr.png', [
                'Content-Type' => 'image/png',
            ]);
        } catch (\Throwable) {
            return redirect()
                ->route('concert-programs.index')
                ->with('error_message', __('No se pudo generar el QR en este momento.'));
        }
    }

    private function extractProgramData(array $validated, bool $isPublished, bool $isFeatured): array
    {
        return [
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'location' => $validated['location'],
            'participants' => $validated['participants'] ?? null,
            'is_published' => $isPublished,
            'is_featured' => $isFeatured,
        ];
    }

    private function resolvePublicProgram(): ?ConcertProgram
    {
        $featured = ConcertProgram::query()
            ->with('pieces')
            ->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->first();

        if ($featured) {
            return $featured;
        }

        $nextByDate = ConcertProgram::query()
            ->with('pieces')
            ->where('is_published', true)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('event_time')
            ->first();

        if ($nextByDate) {
            return $nextByDate;
        }

        return ConcertProgram::query()
            ->with('pieces')
            ->where('is_published', true)
            ->orderByDesc('event_date')
            ->orderByDesc('event_time')
            ->first();
    }

    private function syncFeaturedProgram(ConcertProgram $program): void
    {
        if (! $program->is_featured) {
            return;
        }

        ConcertProgram::query()
            ->whereKeyNot($program->id)
            ->where('is_featured', true)
            ->update(['is_featured' => false]);
    }

    private function syncRepertoire(ConcertProgram $program, array $repertoire): void
    {
        $rows = [];

        foreach ($repertoire as $index => $piece) {
            $title = trim((string) ($piece['title'] ?? ''));

            if ($title === '') {
                continue;
            }

            $rows[] = [
                'title' => $title,
                'author' => isset($piece['author']) ? trim((string) $piece['author']) : null,
                'details' => isset($piece['details']) ? trim((string) $piece['details']) : null,
                'url' => isset($piece['url']) ? trim((string) $piece['url']) : null,
                'sort_order' => isset($piece['sort_order']) && (int) $piece['sort_order'] > 0
                    ? (int) $piece['sort_order']
                    : ($index + 1),
            ];
        }

        if ($rows !== []) {
            $program->pieces()->createMany($rows);
        }
    }

    private function syncUploadedFiles(
        ConcertProgram $program,
        ?UploadedFile $image,
        ?UploadedFile $logo1,
        ?UploadedFile $logo2,
        ?UploadedFile $logo3
    ): void {
        $this->replaceFileIfUploaded($program, 'image_path', $image);
        $this->replaceFileIfUploaded($program, 'logo_1_path', $logo1);
        $this->replaceFileIfUploaded($program, 'logo_2_path', $logo2);
        $this->replaceFileIfUploaded($program, 'logo_3_path', $logo3);
    }

    private function replaceFileIfUploaded(ConcertProgram $program, string $attribute, ?UploadedFile $uploadedFile): void
    {
        if (! $uploadedFile) {
            return;
        }

        $existing = (string) ($program->{$attribute} ?? '');

        if ($existing !== '') {
            Storage::disk('public')->delete($existing);
        }

        $program->{$attribute} = $uploadedFile->store('imagenes/concert-programs', 'public');
    }

    private function deleteProgramFiles(ConcertProgram $program): void
    {
        foreach (['image_path', 'logo_1_path', 'logo_2_path', 'logo_3_path'] as $attribute) {
            $path = (string) ($program->{$attribute} ?? '');

            if ($path !== '') {
                Storage::disk('public')->delete($path);
            }
        }
    }

    private function decorateQrImage(string $qrBinary, ?string $bandName, ?string $logoPath, string $subtitle): string
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
