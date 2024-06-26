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
        Schema::table('apartment_images', function (Blueprint $table) {
            $table->foreignId('apartment_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartment_images', function (Blueprint $table) {
        $table->dropForeign('apartment_images_apartment_id_foreign');
        $table->dropColumn('apartment_id');
        });
    }
};
