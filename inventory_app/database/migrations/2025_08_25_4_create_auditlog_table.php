<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('user'); // dummy user
            $table->string('action'); // add/edit/delete
            $table->string('model'); // misal: Item
            $table->text('old_data')->nullable();
            $table->text('new_data')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
