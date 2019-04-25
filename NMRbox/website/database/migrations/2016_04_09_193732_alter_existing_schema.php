<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterExistingSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            alter table persons rename column address to address1;
            
            select setval(\'activations_id_seq\',(select max(id) + 1 from activations));
            
            alter table software add column display boolean NOT NULL DEFAULT false;
            
            update users set email = \'admin@admin.com\' where id = 1;
            update users set password = \'$2y$10$.1gCCXy5O71lLknqfGUONubk2SzQs7BK6k4ehJJF/YrqkuM2avh7q\' where id = 1;
            
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('
            alter table persons rename column address1 to address;
            alter table software drop column display;
        ');
    }
}
