<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFksRoleUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_users', function ($table) {
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_users', function ($table) {
            $table->dropForeign('role_users_role_id_foreign');
            $table->dropForeign('role_users_user_id_foreign');
        });
    }
}
