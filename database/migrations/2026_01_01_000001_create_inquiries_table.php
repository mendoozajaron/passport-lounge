<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $t) {
            $t->id();
            $t->string('name', 100);
            $t->string('email', 150);
            $t->string('phone', 20);
            $t->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
