<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('teacher_id')->nullable()->constrained();
            $table->foreignId('student_id')->nullable()->constrained();
        });
        DB::statement("ALTER TABLE users ADD CONSTRAINT only_one_fk_for_role CHECK ((role = 'student' AND student_id IS NOT NULL AND teacher_id IS NULL) OR (role = 'teacher' AND teacher_id IS NOT NULL AND student_id IS NULL))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE users DROP CHECK only_one_fk_for_role");
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('teacher_id');
            $table->dropConstrainedForeignId('student_id');
            $table->removeColumn('teacher_id');
            $table->removeColumn('student_id');
        });
    }
};
