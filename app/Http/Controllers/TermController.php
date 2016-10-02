<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Term;
use App\User;
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
		return view('terms.create');
	}

	public function store(Request $request)
	{
		//validate input form
		$this->validate($request, [
			'term_name' => 'required|min:3',
			'term_definition' => 'required'
		]);

		$user = User::find(Auth::user()->id);
		$term = Term::create(['term_name' => $request->input('term_name'), 'term_definition' => $request->input('term_definition')]);
		$user->terms()->attach($term);

		return Redirect::to('/terms/')->with('message', 'Term created.');
	}
}
