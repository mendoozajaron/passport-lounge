<?php

namespace App\Livewire\Admin;

use App\Models\GalleryPhoto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;

// Add the same #[Layout(...)] line you used in AboutManager.
#[Layout('layouts.admin')]

class GalleryManager extends Component
{
    use WithFileUploads;

    public $uploads = [];

    public function save()
    {
        $this->validate([
            'uploads' => 'required|array',
            'uploads.*' => 'image|max:4096',
        ]);

        $next = (GalleryPhoto::max('sort_order') ?? 0) + 1;

        foreach ($this->uploads as $file) {
            GalleryPhoto::create([
                'path' => $file->store('gallery', 'public'),
                'sort_order' => $next++,
            ]);
        }

        $this->reset('uploads');
        session()->flash('saved', 'Photos uploaded.');
    }

    public function toggle($id)
    {
        $p = GalleryPhoto::findOrFail($id);
        $p->update(['is_active' => ! $p->is_active]);
    }

    public function move($id, $direction)
    {
        $p = GalleryPhoto::findOrFail($id);

        $other = $direction === 'up'
            ? GalleryPhoto::where('sort_order', '<', $p->sort_order)->orderByDesc('sort_order')->first()
            : GalleryPhoto::where('sort_order', '>', $p->sort_order)->orderBy('sort_order')->first();

        if ($other) {
            [$a, $b] = [$p->sort_order, $other->sort_order];
            $p->update(['sort_order' => $b]);
            $other->update(['sort_order' => $a]);
        }
    }

    public function delete($id)
    {
        $p = GalleryPhoto::findOrFail($id);
        Storage::disk('public')->delete($p->path);
        $p->delete();
    }

    public function render()
    {
        return view('livewire.admin.gallery-manager', [
            'photos' => GalleryPhoto::orderBy('sort_order')->get(),
        ]);
    }
}