<?php

namespace App;

//use App\User;
use NeoEloquent;

class Term extends NeoEloquent
{
	protected $label = 'Term';

	protected $guarded = [];
	public $timestamps = false;

	protected $fillable = ['term_name','term_description'];

	public function author()
    {
        return $this->belongsTo('App\User', 'CREATED');
    }

}

?>
