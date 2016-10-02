<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreateUsersLabel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Neo4jSchema::label('User', function(Blueprint $label) {
            $label->unique('email');
            $label->index('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Neo4jSchema::label('User', function(Blueprint $label) {
            $label->dropUnique('email');
            $label->dropIndex('name');
        });
    }

}
