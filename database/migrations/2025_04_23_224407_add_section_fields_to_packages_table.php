<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSectionFieldsToPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('section')->after('id'); // A, B, C, D
            $table->integer('subsection')->after('section'); // 1-4
            $table->string('grave_id')->after('subsection'); // A001, B203, etc.
        });
    }

    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['section', 'subsection', 'grave_id']);
        });
    }
}