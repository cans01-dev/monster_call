<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tel_list_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('forbidden_list_id')->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->char('tel', 11);
            $table->timestamps();
            $table->unique(['tel_list_id', 'tel']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tels');
    }
};
