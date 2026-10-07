<div>
    <div class="admin-bar">
        <h1>Quiz questions</h1>
        <button class="btn" wire:click="resetForm">Add question</button>
    </div>

    <form class="panel" wire:submit="save">
        <h3>{{ $editingId ? 'Edit question' : 'New question' }}</h3>

        <label for="qtext">Question</label>
        <input id="qtext" wire:model="text" maxlength="255" required>
        @error('text') <p class="error">{{ $message }}</p> @enderror

        <label>Answers (2 to 6). Each answer points to a drinker type.</label>
        @foreach ($options as $i => $option)
            <div class="opt-row" wire:key="opt-{{ $i }}">
                <input wire:model="options.{{ $i }}.text" maxlength="120" placeholder="Answer text" required>
                <select wire:model="options.{{ $i }}.type">
                    @foreach ($types as $key => $t)
                        <option value="{{ $key }}">{{ $t['name'] }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn ghost" @if(count($options) <= 2) disabled @endif wire:click="removeOption({{ $i }})">Remove</button>
            </div>
            @error("options.$i.text") <p class="error">{{ $message }}</p> @enderror
        @endforeach
        <button type="button" class="btn ghost" @if(count($options) >= 6) disabled @endif wire:click="addOption">Add answer</button>

        <div class="actions" style="margin-top:1.2rem">
            <button class="btn" type="submit" wire:loading.attr="disabled" wire:target="save">Save question</button>
            @if ($editingId)
                <button type="button" class="btn ghost" wire:click="resetForm">Cancel</button>
            @endif
        </div>
    </form>

    @forelse ($questions as $q)
        <div class="panel" wire:key="q-{{ $q->id }}">
            <h3>{{ $q->text }}</h3>
            <ul>
                @foreach ($q->options as $o)
                    <li>{{ $o->text }} <span class="type">({{ $types[$o->type]['name'] }})</span></li>
                @endforeach
            </ul>
            <div class="actions">
                <button class="btn ghost" wire:click="edit({{ $q->id }})">Edit</button>
                <button class="btn danger" wire:click="delete({{ $q->id }})" wire:confirm="Delete this question?">Delete</button>
            </div>
        </div>
    @empty
        <p class="muted">No questions yet. Add your first one.</p>
    @endforelse
</div>
