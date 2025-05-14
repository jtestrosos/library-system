<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBooksCategoryIdForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the existing foreign key constraint
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Re-add the foreign key constraint with ON DELETE CASCADE
        Schema::table('books', function (Blueprint $table) {
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the modified foreign key constraint
        Schema::table('books', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        // Revert to the original foreign key constraint (without cascade)
        Schema::table('books', function (Blueprint $table) {
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories');
        });
    }
}