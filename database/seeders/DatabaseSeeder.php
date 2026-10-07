<?php
namespace Database\Seeders;

use App\Models\Event;
use App\Models\MenuItem;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@passportlounge.ph')],
            ['name' => 'Admin', 'password' => Hash::make(env('ADMIN_PASSWORD', 'change-me-now'))]
        );


        if (! MenuItem::exists()) {
            $menu = [
                ['name' => 'Old Fashioned', 'category' => 'drink', 'price' => 280, 'description' => 'Whiskey, bitters, orange twist'],
                ['name' => 'Margarita', 'category' => 'drink', 'price' => 260, 'description' => 'Tequila, lime, salt rim'],
                ['name' => 'Loaded Fries', 'category' => 'food', 'price' => 220, 'description' => 'Cheese, bacon bits, sour cream'],
            ];
            foreach ($menu as $i => $m) {
                MenuItem::create($m + ['position' => $i + 1]);
            }
        }

        if (! Event::exists()) {
            Event::create(['title' => 'Grand Opening Night', 'event_date' => now()->addWeeks(3), 'description' => 'Doors open, drinks flow.']);
            Event::create(['title' => 'Drag Brunch', 'event_date' => now()->addWeeks(5), 'description' => 'Bottomless mimosas and a full show.']);
        }

    }
}
