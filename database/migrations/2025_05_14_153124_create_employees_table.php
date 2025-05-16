<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_name');
            $table->bigInteger('employee_hours')->default(0);
            $table->bigInteger('employee_rate')->default(0);
            $table->bigInteger('extra_cost')->default(0);
            $table->text('task_description');
            $table->timestamps();
            $table->softDeletes(); // ← Tambahkan soft deletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
