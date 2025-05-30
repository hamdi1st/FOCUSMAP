<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
   {
    Schema::create('steps', function (Blueprint $table) {
        $table->id();
        $table->foreignId('goal_id')->constrained()->onDelete('cascade');
        $table->string('title');
        $table->boolean('is_completed')->default(false);
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('steps');
    }
};
