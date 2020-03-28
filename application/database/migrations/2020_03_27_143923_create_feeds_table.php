<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->text('content')->nullable();
            $table->string('media')->nullable();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE feeds ADD FULLTEXT search(title, content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('feeds', function($table) {
            $table->dropIndex('search');
        });
        Schema::dropIfExists('feeds');
    }
}
