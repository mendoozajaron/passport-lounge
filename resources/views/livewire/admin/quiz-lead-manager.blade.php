<div>
    <div class="admin-bar">
        <h1>Quiz emails</h1>
    </div>

    @forelse ($leads as $lead)
        <div class="panel" wire:key="ql-{{ $lead->id }}">
            <h3>{{ $lead->email }}</h3>
            <p class="muted" style="margin:.2rem 0">
                Got: {{ $types[$lead->result_key]['name'] ?? '—' }}
                &middot; {{ $lead->created_at->format('M j, Y g:i A') }}
            </p>
        </div>
    @empty
        <p class="muted">No one has taken the quiz yet.</p>
    @endforelse
</div>