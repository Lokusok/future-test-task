<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('create_date')->useCurrent();
            $table->dateTime('due_date');
            $table->enum('status', ['выполнена', 'не выполнена']);
            $table->enum('priority', ['низкий', 'средний', 'высокий']);
            $table->string('category');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
