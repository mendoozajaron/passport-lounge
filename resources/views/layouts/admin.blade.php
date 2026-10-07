<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Passport Lounge — Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    @livewireStyles
    <script>
        // Runs before paint so there's no flash of the wrong theme.
        document.documentElement.dataset.adminTheme = localStorage.getItem('adminTheme') || 'light';
    </script>
</head>
<body class="admin">
    @auth
        <div class="admin-shell">
            <aside class="admin-sidebar">
                <div class="admin-brand">PASSPORT LOUNGE<span>Admin</span></div>
                <nav>
                    <a href="{{ route('admin.questions') }}" wire:navigate @class(['active' => request()->routeIs('admin.questions')])>Quiz questions</a>
                    <a href="{{ route('admin.menu') }}" wire:navigate @class(['active' => request()->routeIs('admin.menu')])>Menu</a>
                    <a href="{{ route('admin.events') }}" wire:navigate @class(['active' => request()->routeIs('admin.events')])>Events</a>
                    <a href="{{ route('admin.inquiries') }}" wire:navigate @class(['active' => request()->routeIs('admin.inquiries')])>Inquiries</a>
                    <a href="{{ route('admin.quiz-emails') }}" wire:navigate @class(['active' => request()->routeIs('admin.quiz-emails')])>Quiz emails</a>
                    <a href="{{ route('admin.about') }}" wire:navigate @class(['active' => request()->routeIs('admin.about')])>About</a>
                    <a href="{{ route('admin.gallery') }}" wire:navigate @class(['active' => request()->routeIs('admin.gallery')])>Gallery</a>
                </nav>
                <div class="admin-sidebar-foot">
                    <button type="button" class="btn ghost" id="theme-toggle">🌓 Appearance</button>
                    <a class="btn ghost" href="/" target="_blank" rel="noopener noreferrer">View site</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="btn ghost" type="submit">Log out</button>
                    </form>
                </div>
            </aside>
            <main class="admin-main">
                <div class="admin-inner">
                    {{ $slot }}
                </div>
            </main>
        </div>
    @else
        {{ $slot }}
    @endauth

    @livewireScripts
    <script>
        document.getElementById('theme-toggle')?.addEventListener('click', () => {
            const next = document.documentElement.dataset.adminTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.dataset.adminTheme = next;
            localStorage.setItem('adminTheme', next);
        });
    </script>
</body>
</html>
