<?php

namespace App;

use NeoEloquent;

class Term extends NeoEloquent
{
	protected $label = 'Term';

	protected $guarded = [];
	public $timestamps = false;

	protected $fillable = ['term_name','term_definition'];

	public function author()
    {
        return $this->belongsTo('App\User', 'CREATED');
    }

}

?>
