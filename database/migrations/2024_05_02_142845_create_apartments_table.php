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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('name');
            $table->string('slug');
            $table->unsignedTinyInteger('n_room');
            $table->unsignedTinyInteger('n_bathroom');
            $table->unsignedTinyInteger('n_bed');
            $table->unsignedSmallInteger('square_meters');
            $table->unsignedTinyInteger('floor');
            $table->string('address');
            $table->decimal('lat', 10, 8);
            $table->decimal('lon', 11, 8);
            $table->string('cover_img')->nullable();
            $table->boolean('visible')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
};
