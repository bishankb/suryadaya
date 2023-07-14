<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('page_type');
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('order');
            $table->longText('description')->nullable();
            $table->unsignedInteger('category_id')->nullable();
            $table->unsignedInteger('file_id')->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['order', 'page_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_pages');
    }
}
