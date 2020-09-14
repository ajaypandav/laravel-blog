<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToBlogView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_view', function (Blueprint $table) {
            $table->bigInteger('bid')->unsigned()->nullable()->change();
            $table->foreign('bid')->references('id')->on('blog')->onDelete('set null')->onUpdate('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_view', function (Blueprint $table) {
            //
        });
    }
}
