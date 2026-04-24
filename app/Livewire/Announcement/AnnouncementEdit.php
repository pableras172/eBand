<?php

namespace App\Livewire\Announcement;

use App\Models\Announcement;
use App\Models\Instrument;
use Livewire\Component;

class AnnouncementEdit extends Component
{
    public Announcement $announcement;

    public string $title = '';

    public string $body = '';

    public ?string $content_view = null;

    public ?string $redirect_url = null;

    public ?string $starts_at = null;

    public ?string $ends_at = null;

    public bool $is_active = true;

    public bool $applies_to_all = true;

    public array $instrument_ids = [];

    public function mount(Announcement $announcement): void
    {
        $this->announcement = $announcement;

        $this->authorize('update', $this->announcement);

        $this->title = $announcement->title;
        $this->body = (string) $announcement->body;
        $this->content_view = $announcement->content_view;
        $this->redirect_url = $announcement->redirect_url;
        $this->starts_at = optional($announcement->starts_at)->format('Y-m-d\\TH:i');
        $this->ends_at = optional($announcement->ends_at)->format('Y-m-d\\TH:i');
        $this->is_active = (bool) $announcement->is_active;
        $this->applies_to_all = (bool) $announcement->applies_to_all;
        $this->instrument_ids = $announcement->instruments()->pluck('instruments.id')->toArray();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string', 'required_without:content_view'],
            'content_view' => ['nullable', 'string', 'regex:/^announcements\.[a-zA-Z0-9_.-]+$/'],
            'redirect_url' => ['nullable', 'url'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['boolean'],
            'applies_to_all' => ['boolean'],
            'instrument_ids' => ['array'],
            'instrument_ids.*' => ['integer', 'exists:instruments,id'],
        ];
    }

    public function updatedAppliesToAll(bool $value): void
    {
        if ($value) {
            $this->instrument_ids = [];
        }
    }

    public function save()
    {
        $this->validate();

        if (! $this->applies_to_all && count($this->instrument_ids) === 0) {
            $this->addError('instrument_ids', 'Selecciona al menos un instrumento o marca "Todos".');

            return;
        }

        $this->announcement->update([
            'title' => $this->title,
            'body' => $this->sanitizeBody($this->body),
            'content_view' => $this->content_view ?: null,
            'redirect_url' => $this->redirect_url ?: null,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at ?: null,
            'is_active' => $this->is_active,
            'applies_to_all' => $this->applies_to_all,
        ]);

        $this->announcement->instruments()->sync($this->applies_to_all ? [] : $this->instrument_ids);

        return redirect()->route('announcements.index');
    }

    protected function sanitizeBody(string $body): string
    {
        return trim((string) strip_tags($body, '<p><br><strong><b><em><i><u><ul><ol><li><a><h3><h4><blockquote>'));
    }

    public function render()
    {
        return view('livewire.announcement.announcement-edit', [
            'instruments' => Instrument::query()->orderBy('orden')->get(),
        ]);
    }
}
