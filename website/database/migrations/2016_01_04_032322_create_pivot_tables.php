<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePivotTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_role_person', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
                $table->foreign("person_id")->references("id")->on("persons")->onDelete("cascade");
            $table->integer('lab_role_id')->unsigned();
                $table->foreign("lab_role_id")->references("id")->on("lab_roles")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->integer('software_id')->unsigned();
                $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->primary(['person_id', 'lab_role_id', "software_id"]);
        });

        Schema::create('citation_person', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->foreign("person_id")->references("id")->on("persons")->onDelete("cascade");
            $table->integer('citation_id')->unsigned();
            $table->foreign("citation_id")->references("id")->on("citations")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['person_id', 'citation_id']);
        });

        Schema::create('person_software', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->foreign("person_id")->references("id")->on("persons")->onDelete("cascade");
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['person_id', 'software_id']);
        });

        Schema::create('lab_person', function (Blueprint $table) {
            $table->integer('person_id')->unsigned();
            $table->foreign("person_id")->references("id")->on("persons")->onDelete("cascade");
            $table->integer('lab_id')->unsigned();
            $table->foreign("lab_id")->references("id")->on("labs")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['person_id', 'lab_id']);
        });

        Schema::create('citation_software', function (Blueprint $table) {
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('citation_id')->unsigned();
            $table->foreign("citation_id")->references("id")->on("citations")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_id', 'citation_id']);
        });

        Schema::create('software_tag', function (Blueprint $table) {
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('tag_id')->unsigned();
            $table->foreign("tag_id")->references("id")->on("tags")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_id', 'tag_id']);
        });

        Schema::create('svn_document_software', function (Blueprint $table) {
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('svn_document_id')->unsigned();
            $table->foreign("svn_document_id")->references("id")->on("svn_documents")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_id', 'svn_document_id']);
        });

        Schema::create('menu_software', function (Blueprint $table) {
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('menu_id')->unsigned();
            $table->foreign("menu_id")->references("id")->on("menus")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_id', 'menu_id']);
        });

        Schema::create('lab_software', function (Blueprint $table) {
            $table->integer('software_id')->unsigned();
            $table->foreign("software_id")->references("id")->on("software")->onDelete("cascade");
            $table->integer('lab_id')->unsigned();
            $table->foreign("lab_id")->references("id")->on("labs")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_id', 'lab_id']);
        });

        Schema::create('software_version_vm', function (Blueprint $table) {
            $table->integer('software_version_id')->unsigned();
            $table->foreign("software_version_id")->references("id")->on("software_versions")->onDelete("cascade");
            $table->integer('vm_id')->unsigned();
            $table->foreign("vm_id")->references("id")->on("vms")->onDelete("cascade");
//            $table->nullableTimestamps();
            $table->primary(['software_version_id', 'vm_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('svn_document_software');
        Schema::dropIfExists('lab_role_person');
        Schema::dropIfExists('citation_person');
        Schema::dropIfExists('person_software');
        Schema::dropIfExists('lab_person');
        Schema::dropIfExists('citation_software');
        Schema::dropIfExists('software_tag');
        Schema::dropIfExists('document_software');
        Schema::dropIfExists('menu_software');
        Schema::dropIfExists('lab_software');
        Schema::dropIfExists('software_version_vm');
    }
}
