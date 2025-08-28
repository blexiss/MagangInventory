<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->integer('use')->default(0);
            $table->integer('damaged')->default(0);
            $table->longText('json')->default(json_encode([]));
            $table->longText('check')->default(json_encode([]));
            $table->date('date_of_arrival')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};

