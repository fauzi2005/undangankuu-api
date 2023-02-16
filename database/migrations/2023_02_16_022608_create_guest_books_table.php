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
        Schema::create('guest_books', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 50);
            $table->string('name', 50);
            $table->string('email', 50)->nullable();
            $table->string('contactNumber', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('partner', 20)->nullable();
            $table->string('totalPartner', 20)->nullable();
            $table->string('attending', 50)->nullable();
            $table->boolean('alreadyAttend')->default(false);
            $table->text('message')->nullable();
            $table->text('wishes')->nullable();
            $table->string('typeForm', 10)->default('UNKNOWN');
            $table->text('urlFrom')->default('https://undangankuu.com');
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
        Schema::dropIfExists('guest_books');
    }
};
