<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->unsigned(); 
            $table->bigInteger('cassa_id')->unsigned(); 
            $table->bigInteger('user_id')->unsigned(); 
            $table->integer('quantita')->unsigned(); 
            $table->integer('price')->unsigned(); 

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cassa_id')->references('id')->on('karts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
