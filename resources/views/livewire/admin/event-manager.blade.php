<div>
    <div class="admin-bar">
        <h1>Events</h1>
        <button class="btn" wire:click="resetForm">Add event</button>
    </div>

    <form class="panel" wire:submit="save">
        <h3>{{ $editingId ? 'Edit event' : 'New event' }}</h3>

        <label for="e-title">Title</label>
        <input id="e-title" wire:model="title" maxlength="150" required>
        @error('title') <p class="error">{{ $message }}</p> @enderror

        <label for="e-date">Date</label>
        <input id="e-date" wire:model="event_date" type="date" required>
        @error('event_date') <p class="error">{{ $message }}</p> @enderror

        <label for="e-desc">Description (optional)</label>
        <input id="e-desc" wire:model="description" maxlength="500">

        <div class="actions" style="margin-top:1.2rem">
            <button class="btn" type="submit" wire:loading.attr="disabled" wire:target="save">Save event</button>
            @if ($editingId)
                <button type="button" class="btn ghost" wire:click="resetForm">Cancel</button>
            @endif
        </div>
    </form>

    @forelse ($events as $event)
        <div class="panel" wire:key="e-{{ $event->id }}">
            <h3>{{ $event->title }} <span class="type">{{ $event->event_date->format('M j, Y') }}</span></h3>
            @if ($event->description) <p class="muted" style="margin:.2rem 0">{{ $event->description }}</p> @endif
            <div class="actions">
                <button class="btn ghost" wire:click="edit({{ $event->id }})">Edit</button>
                <button class="btn danger" wire:click="delete({{ $event->id }})" wire:confirm="Delete this event?">Delete</button>
            </div>
        </div>
    @empty
        <p class="muted">No events yet.</p>
    @endforelse
</div>
