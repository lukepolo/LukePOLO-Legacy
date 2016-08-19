<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertTechnologies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        foreach(\App\Models\Mongo\Project::get() as $project) {
//            $technologies = $project->technologies;
//            $project->unset('technologies');
//            $project->technologies()->sync($technologies);
//            $project->save();
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
