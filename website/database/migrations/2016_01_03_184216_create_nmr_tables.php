<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNmrTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->string("first_name", 256);
            $table->string("last_name", 256);
            $table->string("email", 256);
            $table->string("institution", 64);
            $table->string("pi", 64);
            $table->string("nmrbox_acct", 32)->nullable();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('software', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 32)->unique();
            $table->string("slug", 128)->unique();
            $table->string("short_title", 32)->nullable()->unique();
            $table->string("long_title", 128);
            $table->string("synopsis", 150);
            $table->boolean("public_release");
            $table->text('description')->nullable();
            $table->text("license_comment")->nullable();
            $table->string("free_to_redistribute", 16);
            $table->string("devel_contacted", 16)->default("false");
            $table->string("devel_include", 16);
            $table->string("custom_license", 16);
            $table->string("uchc_legal_approve", 16);
            $table->string("devel_redistrib_doc", 16);
            $table->string("devel_active", 16);
            $table->string("devel_status", 16);
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('svn_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string("type", 255)->nullable();
            $table->smallInteger("display")->nullable();
            $table->binary("bdata")->nullable();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('citation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 32);
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('citations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("citation_type_id")->unsigned();
            $table->foreign("citation_type_id")->references("id")->on("citation_types")->onDelete("cascade");
            $table->string("title", 256)->nullable();
            $table->string("author", 2000)->nullable();
            $table->smallInteger("year")->nullable();
            $table->string("journal", 128);
            $table->string("volume", 10)->nullable();
            $table->string("issue", 10)->nullable();
            $table->string("page_start", 10)->nullable();
            $table->string("page_end", 10)->nullable();
            $table->string("publisher", 64);
            $table->integer("pubmed")->nullable();
            $table->string("note", 1000)->nullable();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 255);
            $table->string("slug", 128)->unique();
            $table->string("label", 255);
            $table->binary("bdata")->nullable();
            $table->integer("size")->unsigned();
            $table->string('mime_type', 255)->nullable();
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->integer('role_id')->unsigned();
            $table->foreign("role_id")->references("id")->on("roles")->onDelete("cascade");
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->string("keyword", 128)->unique();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string("label", 32);
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('labs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 80);
            $table->string("institution", 80)->nullable();
            $table->string("pi", 80)->nullable();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('lab_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 80);
            $table->string("slug", 90)->nullable();
//            $table->timestamps(); // Gerard doesn't like timestamps
        });

        Schema::create('vms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->smallInteger("major");
            $table->smallInteger("minor");
            $table->smallInteger("variant");
//            $table->timestamps(); // Gerard doesn't like timestamps
            $table->unique(['major', 'minor']);
        });

        Schema::create('software_versions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("software_id")->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->string("version", 60);
//            $table->timestamps(); // Gerard doesn't like timestamps
            $table->unique(['software_id', 'version']);
        });

        DB::unprepared('
            CREATE OR REPLACE PROCEDURAL LANGUAGE plperl;
        ');

        DB::unprepared('
            CREATE EXTENSION IF NOT EXISTS plpgsql;
        ');

        DB::unprepared('
              CREATE FUNCTION software_name_upper() RETURNS trigger
                    LANGUAGE plperl
                    AS $_X$use strict;
                my $nname = $_TD->{new}{name};
                my $asupper = uc $nname;
                if ($asupper eq $nname) {
                   return;
                }
                $_TD->{new}{name} = $asupper;
                return "MODIFY";$_X$;
        ');

        DB::unprepared('
            CREATE TRIGGER software_name_upper_trigger
              BEFORE
              INSERT
              or
              UPDATE
              ON software FOR EACH row execute PROCEDURE software_name_upper();
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
            DROP TRIGGER IF EXISTS software_name_upper_trigger on software;
        ');
        DB::unprepared('
            DROP FUNCTION IF EXISTS software_name_upper();
        ');
//        DB::unprepared('
//            DROP EXTENSION IF EXISTS plpgsql;
//        ');
        DB::unprepared('
            DROP PROCEDURAL LANGUAGE IF EXISTS plperl;
        ');
        Schema::dropIfExists('persons');
        Schema::dropIfExists('software_versions');
        Schema::dropIfExists('lab_roles');
        Schema::dropIfExists('files');
        Schema::dropIfExists('software');
        Schema::dropIfExists('svn_documents');
        Schema::dropIfExists('citations');
        Schema::dropIfExists('citation_types');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('menus');
        Schema::dropIfExists('labs');
        Schema::dropIfExists('vms');
    }
}
