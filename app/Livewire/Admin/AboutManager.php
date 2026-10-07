<?php

namespace App\Livewire\Admin;

use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

#[Layout('layouts.admin')]

class AboutManager extends Component
{
    use WithFileUploads;

    public $title = '';
    public $body = '';
    public $button_label = '';
    public $button_url = '';
    public $opening = '';
    public $location = '';
    public $hours = '';
    public $social = '';
    public $image;              // new upload
    public $currentImage = null;

    public function mount()
    {
        $s = Section::firstOrNew(['key' => 'about']);

        $this->title = $s->title ?? '';
        $this->body = $s->body ?? '';
        $this->button_label = $s->button_label ?? '';
        $this->button_url = $s->button_url ?? '';
        $this->opening = $s->extra['opening'] ?? '';
        $this->location = $s->extra['where'] ?? '';
        $this->hours = $s->extra['hours'] ?? '';
        $this->social = $s->extra['social'] ?? '';
        $this->currentImage = $s->image_url;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'button_label' => 'nullable|string|max:100',
            'button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
        ]);

        $s = Section::firstOrNew(['key' => 'about']);

        if ($this->image) {
            if ($s->image_path) {
                Storage::disk('public')->delete($s->image_path);
            }
            $s->image_path = $this->image->store('sections', 'public');
        }

        $s->fill([
            'title' => $this->title,
            'body' => $this->body,
            'button_label' => $this->button_label,
            'button_url' => $this->button_url,
            'extra' => [
                'opening' => $this->opening,
                'where' => $this->location,
                'hours' => $this->hours,
                'social' => $this->social,
            ],
        ])->save();

        $this->currentImage = $s->image_url;
        $this->image = null;
        session()->flash('saved', 'About section updated.');
    }

    public function render()
    {
        return view('livewire.admin.about-manager');
    }
}