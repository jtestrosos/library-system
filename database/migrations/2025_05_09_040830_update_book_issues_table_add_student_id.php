<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateBookIssuesTableAddStudentId extends Migration
{
    public function up()
    {
        Schema::table('book_issues', function (Blueprint $table) {
            if (!Schema::hasColumn('book_issues', 'student_id')) {
                $table->unsignedBigInteger('student_id')->after('id');
                $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('book_issues', function (Blueprint $table) {
            // Revert changes: drop student_id and restore user_id
            $table->dropForeign(['student_id']);
            $table->dropColumn('student_id');

            $table->unsignedBigInteger('user_id')->after('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}