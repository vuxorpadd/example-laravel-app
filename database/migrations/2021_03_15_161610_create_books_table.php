<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("books", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table
                ->foreignId("author_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->string("subtitle")->nullable();
            $table->text("description")->nullable();
            $table->text("preview")->nullable();
            $table->string("cover");
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
        Schema::dropIfExists("books");
    }
}
