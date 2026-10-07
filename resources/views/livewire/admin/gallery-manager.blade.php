{{-- resources/views/livewire/admin/gallery-manager.blade.php --}}
<div>
    <h1>Gallery / Carousel</h1>

    @if (session('saved'))
        <p>{{ session('saved') }}</p>
    @endif

    <form wire:submit="save">
        <input type="file" wire:model="uploads" accept="image/*" multiple>
        @error('uploads') <small>{{ $message }}</small> @enderror
        @error('uploads.*') <small>{{ $message }}</small> @enderror

        @if ($uploads)
            <div style="display:flex; gap:.5rem; flex-wrap:wrap; margin:.5rem 0;">
                @foreach ($uploads as $file)
                    <img src="{{ $file->temporaryUrl() }}" width="80" alt="">
                @endforeach
            </div>
        @endif

        <button type="submit" wire:loading.attr="disabled">Upload</button>
    </form>

    <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(180px,1fr)); gap:1rem; margin-top:1.5rem;">
        @forelse ($photos as $photo)
            <div wire:key="photo-{{ $photo->id }}">
                <img
                    src="{{ $photo->url }}"
                    alt=""
                    style="width:100%; height:140px; object-fit:cover; border-radius:.5rem; {{ $photo->is_active ? '' : 'opacity:.4;' }}"
                >
                <div style="display:flex; gap:.25rem; margin-top:.4rem;">
                    <button type="button" wire:click="move({{ $photo->id }}, 'up')" @disabled($loop->first)>←</button>
                    <button type="button" wire:click="move({{ $photo->id }}, 'down')" @disabled($loop->last)>→</button>
                    <button type="button" wire:click="toggle({{ $photo->id }})">
                        {{ $photo->is_active ? 'Hide' : 'Show' }}
                    </button>
                    <button type="button" wire:click="delete({{ $photo->id }})" wire:confirm="Delete this photo?">Delete</button>
                </div>
            </div>
        @empty
            <p>No photos yet. Upload some above.</p>
        @endforelse
    </div>
</div>