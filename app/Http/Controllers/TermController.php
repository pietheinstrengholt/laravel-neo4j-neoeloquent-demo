<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Term;
use App\User;
use App\Relation;
use Auth;
use Redirect;

class TermController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$terms = Term::orderBy('term_name', 'asc')->get();
		return view('terms.index', compact('terms'));
	}

	public function create(Term $term, Request $request)
	{
		$terms = Term::orderBy('term_name', 'asc')->get();
		return view('terms.create', compact('terms'));
	}

	public function store(Request $request)
	{
		//validate input form
		$this->validate($request, [
			'term_name' => 'required|min:3',
			'term_definition' => 'required'
		]);

		//find user
		$user = User::find(Auth::user()->id);

		//create term
		$term = Term::create(['term_name' => $request->input('term_name'), 'term_definition' => $request->input('term_definition')]);

		//attach new term to user
		$user->terms()->attach($term);

		//if object has been set, create relation
		if ($request->has('object_id')) {
			if ($request->input('object_id') <> 0) {
				$object = Term::where('id',$request->input('object_id'))->first();
				$term->relationship($object)->create(['relation_name' => 'has a relation to', 'relation_description' => 'has a relation to']);
			}
		}

		return Redirect::to('/terms/')->with('message', 'Term created.');
	}

	public function edit(Term $term)
	{
		//check if id property exists
		if (!$term->id) {
			abort(403, 'This term no longer exists in the database.');
		}

		return view('terms.edit', compact('term'));
	}

	public function update(Term $term, Request $request)
	{
		//validate input form
		$this->validate($request, [
			'term_name' => 'required|min:3',
			'term_definition' => 'required'
		]);

		$term->update($request->all());

		return Redirect::to('/terms/')->with('message', 'Term updated.');
	}

	public function destroy(Term $term)
	{
		//check if id property exists
		if (!$term->id) {
			abort(403, 'This term no longer exists in the database.');
		}
		//delete term
		$term->delete();

		return Redirect::to('/terms/')->with('message', 'Term deleted.');
	}
}
