# Switching /admin to Livewire

## 1. Install Livewire
    composer require livewire/livewire

## 2. Copy these files into your project (overwrite where paths match)
- app/Livewire/Admin/Login.php
- app/Livewire/Admin/Dashboard.php
- resources/views/livewire/admin/login.blade.php
- resources/views/livewire/admin/dashboard.blade.php
- resources/views/layouts/admin.blade.php
- routes/web.php          (overwrite — admin is now Livewire, not a Vue/API route)
- resources/js/App.vue    (overwrite — the isAdmin check and <AdminPanel> are removed)

## 3. Delete these — no longer used
- resources/js/components/AdminPanel.vue
- app/Http/Controllers/AdminAuthController.php
- app/Http/Controllers/AdminQuestionController.php

(app/Http/Controllers/InquiryController.php is replaced too — its admin `index` method
is gone since the Livewire dashboard queries Inquiry directly. The public `store` method,
used by the Contact us form, is unchanged.)

## 4. Make unauthenticated /admin visits land on the Livewire login page
In `bootstrap/app.php`, inside `->withMiddleware(function (Middleware $middleware) { ... })`, add:

    $middleware->redirectGuestsTo(fn () => route('admin.login'));

## 5. Rebuild the public assets (Livewire doesn't need Vite, but Vue still does)
    npm run dev

## 6. Log in
Visit /admin — same credentials as before (from your .env or the seeder defaults:
admin@passportlounge.ph / change-me-now).
