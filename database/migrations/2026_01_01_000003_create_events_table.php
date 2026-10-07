<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $t) {
            $t->id();
            $t->string('title', 150);
            $t->date('event_date');
            $t->string('description', 500)->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('events'); }
};
