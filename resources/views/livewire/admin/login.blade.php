<div class="admin-inner">
    <form class="panel login" wire:submit="login">
        <h1>Admin login</h1>

        <label for="email">Email</label>
        <input id="email" type="email" wire:model="email" autocomplete="username" required>

        <label for="password">Password</label>
        <input id="password" type="password" wire:model="password" autocomplete="current-password" required>

        @error('email') <p class="error">{{ $message }}</p> @enderror
        @error('password') <p class="error">{{ $message }}</p> @enderror
        @if ($error) <p class="error">{{ $error }}</p> @endif

        <p></p>
        <button class="btn" type="submit" wire:loading.attr="disabled" wire:target="login">
            <span wire:loading.remove wire:target="login">Log in</span>
            <span wire:loading wire:target="login">Logging in…</span>
        </button>
    </form>
</div>
