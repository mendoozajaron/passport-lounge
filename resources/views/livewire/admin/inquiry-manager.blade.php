<div>
    <div class="admin-bar">
        <h1>Contact inquiries</h1>
    </div>

    @forelse ($inquiries as $i)
        <div class="panel" wire:key="i-{{ $i->id }}">
            <h3>{{ $i->name }}</h3>
            <p style="margin:0"><a href="mailto:{{ $i->email }}">{{ $i->email }}</a> &middot; {{ $i->phone }}</p>
            <p class="muted" style="margin:.3rem 0 0">{{ $i->created_at->format('M j, Y g:i A') }}</p>
        </div>
    @empty
        <p class="muted">No inquiries yet.</p>
    @endforelse
</div>
