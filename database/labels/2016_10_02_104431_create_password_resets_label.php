<?php

use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreatePasswordResetsLabel extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Neo4jSchema::label('PasswordReset', function(Blueprint $label) {
            $label->index('email');
            $label->index('token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Neo4jSchema::label('PasswordReset', function(Blueprint $label) {
            $label->dropIndex('email');
            $label->dropIndex('token');
        });
    }

}
