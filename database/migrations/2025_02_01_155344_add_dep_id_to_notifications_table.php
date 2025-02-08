<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('dep_id')->nullable(); // Or you can make it non-nullable based on your logic
        });
    }

    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn('dep_id');
        });
    }
};
