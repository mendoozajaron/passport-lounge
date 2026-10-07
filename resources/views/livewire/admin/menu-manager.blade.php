<div>
    <div class="admin-bar">
        <h1>Menu</h1>
        <button class="btn" wire:click="resetForm">Add item</button>
    </div>

    <form class="panel" wire:submit="save">
        <h3>{{ $editingId ? 'Edit item' : 'New item' }}</h3>

        <label for="m-name">Name</label>
        <input id="m-name" wire:model="name" maxlength="120" required>
        @error('name') <p class="error">{{ $message }}</p> @enderror

        <div class="opt-row" style="grid-template-columns:1fr 1fr">
            <div>
                <label for="m-cat">Category</label>
                <select id="m-cat" wire:model="category">
                    <option value="drink">Drink</option>
                    <option value="food">Food</option>
                </select>
            </div>
            <div>
                <label for="m-price">Price (₱)</label>
                <input id="m-price" wire:model="price" type="number" step="0.01" min="0" required>
                @error('price') <p class="error">{{ $message }}</p> @enderror
            </div>
        </div>

        <label for="m-desc">Description (optional)</label>
        <input id="m-desc" wire:model="description" maxlength="255">

        <div class="actions" style="margin-top:1.2rem">
            <button class="btn" type="submit" wire:loading.attr="disabled" wire:target="save">Save item</button>
            @if ($editingId)
                <button type="button" class="btn ghost" wire:click="resetForm">Cancel</button>
            @endif
        </div>
    </form>

    @forelse ($items as $item)
        <div class="panel" wire:key="m-{{ $item->id }}">
            <h3>{{ $item->name }} <span class="type">₱{{ number_format($item->price, 2) }}</span></h3>
            <p class="muted" style="margin:.2rem 0">
                {{ ucfirst($item->category) }}@if($item->description) &middot; {{ $item->description }} @endif
            </p>
            <div class="actions">
                <button class="btn ghost" wire:click="edit({{ $item->id }})">Edit</button>
                <button class="btn danger" wire:click="delete({{ $item->id }})" wire:confirm="Delete this menu item?">Delete</button>
            </div>
        </div>
    @empty
        <p class="muted">No menu items yet.</p>
    @endforelse
</div>
