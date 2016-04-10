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
            
            ALTER TABLE ONLY persons
                DROP CONSTRAINT persons_institution_id_fkey;
            alter table persons drop column institution_id;
            
            alter table persons ADD column institution VARCHAR(256) DEFAULT NULL::character varying;
            alter table persons ADD column institution_type VARCHAR(64) DEFAULT NULL::character varying;
            
            alter table users add column email VARCHAR(256);
            update users set email = \'admin@admin.com\' where id = 1;
            
            select setval(\'activations_id_seq\',(select max(id) + 1 from activations));
            
            alter table software alter column devel_contacted drop NOT NULL; 

            insert into roles (id, slug, name, permissions, created_at, updated_at) VALUES
                ( 2,	\'user\',		\'User\',				NULL,				\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' ),
                ( 3,	\'public\',	    \'Public\',			    NULL,				\'2016-02-21 20:56:31\',	\'2016-02-21 20:56:31\' );
            
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
            
            alter table persons ADD column institution_id INTEGER;
            ALTER TABLE ONLY persons
                ADD CONSTRAINT persons_institution_id_fkey FOREIGN KEY (institution_id) REFERENCES institutions (id);
            
            alter table persons drop column institution;
            alter table persons drop column institution_type;
            
            alter table users drop column email;
        ');
    }
}
