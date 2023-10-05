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
        Schema::create('tweets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->string('text')->nullable();
            $table->string('path')->nullable();
            $table->string('type')->default('tweet');
            $table->integer('count_replies')->default(0);
            $table->integer('count_favorites')->default(0);
            $table->integer('count_retweets')->default(0);
            $table->timestamps();

            $table->index('parent_id');
            $table->index('user_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tweets');
    }
};
