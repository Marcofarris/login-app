<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Kart;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('quantita');
            $table->foreignIdFor(User::class)->onDelete('cascade')->constrained();
           // $table->foreignIdFor(Kart::class)->onDelete('cascade')->constrained();
            $table->bigInteger('cassa_id')->unsigned(); 
            $table->integer('price')->unsigned(); 
            $table->foreign('cassa_id')->references('id')->on('karts');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
