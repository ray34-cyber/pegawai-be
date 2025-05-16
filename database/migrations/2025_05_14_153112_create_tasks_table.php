<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_name');
            $table->date('task_date');
            $table->bigInteger('total_remuneration')->default(0);
            $table->timestamps();
            $table->softDeletes(); // ← Tambahkan soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};

