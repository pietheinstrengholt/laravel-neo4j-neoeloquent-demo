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

	public function relationship($morph=null)
	{
	    return $this->hyperMorph($morph, 'App\Relation', 'RELATION', 'TO');
	}

	public function object()
	{
	    return $this->belongsToMany('App\Term', 'RELATION');
	}

	public function whichRelation()
	{
	    return $this->morphMany('App\Relation','TO');
	}

}

?>
