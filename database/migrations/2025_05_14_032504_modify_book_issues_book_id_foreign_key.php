<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyBookIssuesBookIdForeignKey extends Migration
{
    public function up()
    {
        // Drop the existing foreign key constraint
        Schema::table('book_issues', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
        });

        // Add the foreign key constraint with ON DELETE CASCADE
        Schema::table('book_issues', function (Blueprint $table) {
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        // Drop the modified foreign key constraint
        Schema::table('book_issues', function (Blueprint $table) {
            $table->dropForeign(['book_id']);
        });

        // Revert to the original foreign key constraint (without cascade)
        Schema::table('book_issues', function (Blueprint $table) {
            $table->foreign('book_id')
                  ->references('id')
                  ->on('books');
        });
    }
}