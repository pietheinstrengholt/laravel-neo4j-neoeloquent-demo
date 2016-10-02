<?php

use Vinelab\NeoEloquent\Schema\Blueprint;
use Vinelab\NeoEloquent\Facade\Neo4jSchema;
use Vinelab\NeoEloquent\Migrations\Migration;

class CreateTermsLabel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Neo4jSchema::label('Term', function(Blueprint $label) {
			$label->unique('id');
			$label->index('term_name');
			$label->index('term_definition');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Neo4jSchema::label('Term', function(Blueprint $label) {
			$label->dropUnique('id');
			$label->dropIndex('term_name');
			$label->dropIndex('term_definition');
		});
	}

}
