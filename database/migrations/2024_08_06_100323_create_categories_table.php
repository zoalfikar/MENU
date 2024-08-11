<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string("title")->nullable(false);
            $table->enum('type', ['parentCa', 'itemsCa']);
            $table->integer("discountPercent")->nullable(true);
            $table->unsignedBigInteger('parentId')->nullable();
            $table->foreign("parentId")->references("id")->on("categories")->onDelete("Cascade")->onUpdate("Cascade");
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
        Schema::dropIfExists('categories');
    }
}
