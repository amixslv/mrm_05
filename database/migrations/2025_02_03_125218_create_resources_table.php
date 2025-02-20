<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Veiciet migrācijas.
     */
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['Vehicle', 'Weapon', 'Equipment', 'Ammo']);
            $table->integer('quantity');
            $table->enum('status', ['Available', 'In use', 'Maintenance', 'Write off']);
            $table->string('assigned_department');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Atgrieziet migrācijas.
     */
    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
};
