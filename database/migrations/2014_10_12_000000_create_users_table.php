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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['teacher', 'student']);
            $table->foreignId('inviter_id')->nullable()->constrained()->references('id')->on('users');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::statement("ALTER TABLE users ADD CONSTRAINT inviter_id_only_for_student CHECK ((role = 'student' AND inviter_id IS NOT NULL) OR (role = 'teacher' AND inviter_id IS NULL))");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
