<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Term;
use App\User;
use App\Relation;
use Auth;
use Redirect;

class ExcelController extends Controller
{
	public function upload()
	{
		if (!Auth::check()) {
			abort(403, 'Unauthorized action. You don\'t have access to this page');
		}

		return view('excel.upload');
	}

	public function getNameFromNumber($num)
	{
		$numeric = ($num - 1) % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval(($num - 1) / 26);
		if ($num2 > 0) {
			return getNameFromNumber($num2) . $letter;
		} else {
			return $letter;
		}
	}

	public function getExcelColumnNumber($num)
	{
		$numeric = ($num - 1) % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval(($num - 1) / 26);
		if ($num2 > 0) {
			return $this->getNameFromNumber($num2) . $letter;
		} else {
			return $letter;
		}
	}

	public function postexcel(Request $request)
	{
		//validate input form
		$this->validate($request, [
			'excel' => 'required|mimes:xls,xlsx'
		]);

		//create empty arrays for build structure and for validation
		$results = array();

		if ($request->file('excel')->isValid()) {

			$validation = Excel::load($request->file('excel'), function ($reader) use ($request, &$errors, &$results) {

				// Getting all sheets
				$reader->setReadDataOnly(true);
				$reader->ignoreEmpty();
				$sheets = $reader->get();

				//empty array for unique term names validation
				$term_names = array();

				foreach($sheets as $sheet) {

					$worksheetTitle = $sheet->getTitle();
					$arraySheet = $sheet->toArray();

					//get column and row count from imported excel
					$highestRow = count($arraySheet) + 1;
					if (array_key_exists(0,$arraySheet)) {
						$highestColumn = $this->getExcelColumnNumber(count($arraySheet[0]));
						$highestColumnIndex = count($arraySheet[0]) + 1;
					} else {
						$highestColumn = 0;
						$highestColumnIndex = 1;
					}

					//start counting unique id content
					$i = 0;

					if ($worksheetTitle == "terms") {

						if ($highestRow > 1) {

							for ($row = 1; $row <= $highestRow; ++ $row) {
								for ($column = 1; $column < $highestColumnIndex; ++ $column) {

									//set column letter and retrieve value
									$columnLetter = $this->getExcelColumnNumber($column);
									$val = $reader->getExcel()->getSheet(0)->getCell($columnLetter . $row)->getValue();

									//1th row is the heading
									if ($row == 1 && ($column == 1 && $val != 'id' || $column == 2 && $val != 'term_name' || $column == 3 && $val != 'term_definition')) {
										//validate if heading is correct
										abort(403, 'Incorrect header on first sheet.');
									}

									//check if the sequence is correct
									if ($row > 1 && $column == 1) {
										$results['terms'][$i]['id'] = $val;
										if ($val != $i) {
											abort(403, 'Sequence on first sheet incorrect.');
										}
									}
									if ($row > 1 && $column == 2) {
										$results['terms'][$i]['term_name'] = $val;
										if (in_array($val, $term_names)) {
											abort(403, 'Term name already exists.');
										}
										array_push($term_names, $val);
									}
									if ($row > 1 && $column == 3) {
										$results['terms'][$i]['term_definition'] = $val;
									}
								}
								$i++;
							}
						}
					}

					if ($worksheetTitle == "ontology") {

						if ($highestRow > 1) {

							for ($row = 1; $row <= $highestRow; ++ $row) {
								for ($column = 1; $column < $highestColumnIndex; ++ $column) {

									//set column letter and retrieve value
									$columnLetter = $this->getExcelColumnNumber($column);
									$val = $reader->getExcel()->getSheet(1)->getCell($columnLetter . $row)->getValue();

									//1th row is the heading
									if ($row == 1 && ($column == 1 && $val != 'subject_id' || $column == 2 && $val != 'object_id')) {
										//validate if heading is correct
										abort(403, 'Incorrect header on second sheet.');
									}

									//get the subject id and validate if a term with a given id exists
									if ($row > 1 && $column == 1) {
										$results['ontology'][$i]['subject_id'] = $val;
										if (!isset($results['terms'][$val])) {
											abort(403, 'subject id does not exist on terms sheet.');
										}
									}

									//get the object id and validate if a term with a given id exists
									if ($row > 1 && $column == 2) {
										$results['ontology'][$i]['object_id'] = $val;
										if (!isset($results['terms'][$val])) {
											abort(403, 'object id does not exist on terms sheet.');
										}
									}
								}
								$i++;
							}
						}
					}
				}
			});

			if (empty($results['terms'])) {
				abort(403, 'Incorrect Excel file. The terms sheet is empty.');
			}

			//find user
			$user = User::find(Auth::user()->id);

			foreach ($results['terms'] as $key => $term) {
				//create term
				$new_term = Term::create(['term_name' => $term['term_name'], 'term_definition' =>  $term['term_definition']]);

				//attach new term to user
				$user->terms()->attach($new_term);
			}

			if (!empty($results['ontology'])) {
				foreach ($results['ontology'] as $key => $ontology) {

					//set variables to lookup new term id's
					$subject_name = $results['terms'][$ontology['subject_id']]['term_name'];
					$object_name = $results['terms'][$ontology['object_id']]['term_name'];

					$subject = Term::where('term_name',$subject_name)->first();
					$object = Term::where('term_name',$object_name)->first();

					//if both subject and object are found create relation
					if (!empty($subject) && !empty($object)) {
						$subject->relationship($object)->create(['relation_name' => 'has a relation to', 'relation_description' => 'has a relation to']);
					}

				}
			}
		}

		return Redirect::to('/')->with('message', 'New content successfully uploaded.');
	}

	//function to export Excel template
	public function download()
	{
		Excel::create('import_template', function($excel) {

			// Our first sheet
			$excel->sheet('terms', function($sheet) {
				$sheet->SetCellValue('A1', 'id');
				$sheet->getStyle('A1')->getFont()->setBold(true);
				$sheet->getColumnDimension('A')->setWidth(6);
				$sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('dff0d8');
				$sheet->SetCellValue('B1', 'term_name');
				$sheet->getStyle('B1')->getFont()->setBold(true);
				$sheet->getStyle('B1')->getFill()->getStartColor()->setARGB('dff0d8');
				$sheet->getColumnDimension('B')->setWidth(30);
				$sheet->SetCellValue('C1', 'term_definition');
				$sheet->getStyle('C1')->getFont()->setBold(true);
				$sheet->getColumnDimension('C')->setWidth(150);
				$sheet->getStyle('C1')->getFill()->getStartColor()->setARGB('dff0d8');

				$sheet->cells('A1:C1', function($cells) {
					$cells->setBackground('#18bc9c');
				});
			});

			// Our second sheet
			$excel->sheet('ontology', function($sheet) {
				$sheet->SetCellValue('A1', 'subject_id');
				$sheet->getStyle('A1')->getFont()->setBold(true);
				$sheet->getColumnDimension('A')->setWidth(20);
				$sheet->getStyle('A1')->getFill()->getStartColor()->setARGB('dff0d8');
				$sheet->SetCellValue('B1', 'object_id');
				$sheet->getStyle('B1')->getFont()->setBold(true);
				$sheet->getColumnDimension('B')->setWidth(20);
				$sheet->getStyle('B1')->getFill()->getStartColor()->setARGB('dff0d8');

				$sheet->cells('A1:B1', function($cells) {
					$cells->setBackground('#18bc9c');
				});
			});

		})->download('xlsx');
	}
}
