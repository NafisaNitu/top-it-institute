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
        Schema::create('subjects', function (Blueprint $table) {
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('sub_title')->nullable();
            $table->longText('description')->nullable();
            $table->text('image')->nullable();
            $table->string('total_class')->nullable();
            $table->string('total_hour')->nullable();
            $table->float('fee',8,2)->nullable();
            $table->boolean('status')->default("0");
            $table->id();
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
        Schema::dropIfExists('subjects');
    }
};
