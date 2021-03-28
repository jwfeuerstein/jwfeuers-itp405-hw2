<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAlbumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('albums', function (Blueprint $table) {
            // $table->foreign('role_id')->references('id')->on('roles');

            // https://laravel.com/docs/8.x/migrations#foreign-key-constraints
            $table->foreignId('user_id')->nullable()->default(6)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('albums', ['user_id']);
    }
}
