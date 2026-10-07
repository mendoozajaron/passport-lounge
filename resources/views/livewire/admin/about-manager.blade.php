{{-- resources/views/livewire/admin/about-manager.blade.php --}}
<div>
    <h1>About us</h1>

    @if (session('saved'))
        <p>{{ session('saved') }}</p>
    @endif

    <form wire:submit="save">
        <label>Title</label>
        <input type="text" wire:model="title">
        @error('title') <small>{{ $message }}</small> @enderror

        <label>Text</label>

<div
    contenteditable="true"
    wire:ignore
    x-data
    x-on:input="$wire.set('body', $el.innerHTML)"
    style="
        min-height: 200px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: white;
    "
>
    {!! $body !!}
</div>

@error('body')
    <small>{{ $message }}</small>
@enderror

        <label>Image</label>
        @if ($image)
            <img src="{{ $image->temporaryUrl() }}" width="240" alt="">
        @elseif ($currentImage)
            <img src="{{ $currentImage }}" width="240" alt="">
        @endif
        <input type="file" wire:model="image" accept="image/*">
        @error('image') <small>{{ $message }}</small> @enderror

        <label>Button label</label>
        <input type="text" wire:model="button_label">

        <label>Button link</label>
        <input type="text" wire:model="button_url">

        <label>Status</label>
        <input type="text" wire:model="opening">

        <label>Where</label>
        <input type="text" wire:model="location">

        <label>Hours</label>
        <input type="text" wire:model="hours">

        <label>Follow us</label>
        <input type="text" wire:model="social">

        <button type="submit" wire:loading.attr="disabled">Save</button>
    </form>
</div>