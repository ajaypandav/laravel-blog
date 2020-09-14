<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlagToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->boolean('flag')->default(0)->comment('0=Unread | 1=Read');
        });

        Schema::table('subscribers', function (Blueprint $table) {
            $table->boolean('flag')->default(0)->comment('0=Unread | 1=Read');
        });

        Schema::table('blog_comment', function (Blueprint $table) {
            $table->boolean('flag')->default(0)->comment('0=Unread | 1=Read');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
        Schema::table('subscribers', function (Blueprint $table) {
            //
        });
        Schema::table('blog_comment', function (Blueprint $table) {
            //
        });
    }
}
