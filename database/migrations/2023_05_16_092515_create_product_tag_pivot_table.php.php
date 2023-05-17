<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'product_id_fk_8488128')->references('id')->on('products')->onDelete('cascade');
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id', 'tag_id_fk_8488128')->references('id')->on('tags')->onDelete('cascade');
        });
    }

};
