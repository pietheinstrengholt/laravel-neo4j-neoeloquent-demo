<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreateRelationsLabel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Neo4jSchema::label('Relation', function(Blueprint $label) {
			$label->unique('id');
			$label->index('relation_name');
			$label->index('relation_description');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Neo4jSchema::label('Relation', function(Blueprint $label) {
			$label->dropUnique('id');
			$label->dropIndex('relation_name');
			$label->dropIndex('relation_description');
		});
	}

}
