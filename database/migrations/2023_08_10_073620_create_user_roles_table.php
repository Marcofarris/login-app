<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_roles', function (Blueprint $table) {
            // $table->bigInteger('user_id')->unsigned(); 
            // $table->bigInteger('role_id')->unsigned(); 
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');

            $table->foreignIdFor(User::class)->onDelete('cascade')->constrained();
            $table->foreignIdFor(Role::class)->onDelete('cascade')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_roles');
    }
};
