<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $t) {
            $t->id();
            $t->string('name', 120);
            $t->string('category', 20); // 'drink' or 'food'
            $t->decimal('price', 8, 2);
            $t->string('description', 255)->nullable();
            $t->unsignedInteger('position')->default(0);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('menu_items'); }
};
