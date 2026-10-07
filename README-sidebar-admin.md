# Sidebar admin + Menu/Events CRUD

## 1. Copy these files into your project (overwrite where the path already exists)
- database/migrations/2026_01_01_000002_create_menu_items_table.php  (new)
- database/migrations/2026_01_01_000003_create_events_table.php      (new)
- app/Models/MenuItem.php                                            (new)
- app/Models/Event.php                                                (new)
- app/Livewire/Admin/QuestionManager.php                              (new — replaces Dashboard.php)
- app/Livewire/Admin/MenuManager.php                                  (new)
- app/Livewire/Admin/EventManager.php                                 (new)
- app/Livewire/Admin/InquiryManager.php                               (new)
- app/Livewire/Admin/Login.php                                        (overwrite — redirect target changed)
- resources/views/livewire/admin/question-manager.blade.php           (new — replaces dashboard.blade.php)
- resources/views/livewire/admin/menu-manager.blade.php               (new)
- resources/views/livewire/admin/event-manager.blade.php              (new)
- resources/views/livewire/admin/inquiry-manager.blade.php            (new)
- resources/views/layouts/admin.blade.php                             (overwrite — sidebar + appearance toggle)
- resources/css/app.css                                               (overwrite — adds sidebar/dark styles)
- routes/web.php                                                      (overwrite — four admin routes now)
- database/seeders/DatabaseSeeder.php                                 (overwrite — adds sample menu items + events)

## 2. Delete — replaced by QuestionManager
- app/Livewire/Admin/Dashboard.php
- resources/views/livewire/admin/dashboard.blade.php

## 3. Run the new migrations and reseed the sample menu/events
    php artisan migrate --seed

(If it says nothing new to migrate, your DB already had these tables from a partial
attempt — run `php artisan migrate:fresh --seed` instead. That resets everything,
including your existing quiz questions and inquiries, so only do that if you're fine
losing test data.)

## 4. Visit /admin
You'll land on Quiz questions, with a sidebar for Menu, Events, and Inquiries.
The "🌓 Appearance" button in the sidebar toggles light/dark for the admin area only —
it's saved in the browser's localStorage, so it's per-device, not per-account.
