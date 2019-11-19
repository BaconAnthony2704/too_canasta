<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Unidad_de_Medida;

class Unidad_de_MedidasController extends Controller
{
	public $show_action = true;
	public $view_col = 'NombreUnidad';
	public $listing_cols = ['id', 'NombreUnidad'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Unidad_de_Medidas', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Unidad_de_Medidas', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Unidad_de_Medidas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Unidad_de_Medidas');
		
		if(Module::hasAccess($module->id)) {
			return View('la.unidad_de_medidas.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new unidad_de_medida.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created unidad_de_medida in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Unidad_de_Medidas", "create")) {
		
			$rules = Module::validateRules("Unidad_de_Medidas", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Unidad_de_Medidas", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.unidad_de_medidas.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified unidad_de_medida.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Unidad_de_Medidas", "view")) {
			
			$unidad_de_medida = Unidad_de_Medida::find($id);
			if(isset($unidad_de_medida->id)) {
				$module = Module::get('Unidad_de_Medidas');
				$module->row = $unidad_de_medida;
				
				return view('la.unidad_de_medidas.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('unidad_de_medida', $unidad_de_medida);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("unidad_de_medida"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified unidad_de_medida.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Unidad_de_Medidas", "edit")) {			
			$unidad_de_medida = Unidad_de_Medida::find($id);
			if(isset($unidad_de_medida->id)) {	
				$module = Module::get('Unidad_de_Medidas');
				
				$module->row = $unidad_de_medida;
				
				return view('la.unidad_de_medidas.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('unidad_de_medida', $unidad_de_medida);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("unidad_de_medida"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified unidad_de_medida in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Unidad_de_Medidas", "edit")) {
			
			$rules = Module::validateRules("Unidad_de_Medidas", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Unidad_de_Medidas", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.unidad_de_medidas.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified unidad_de_medida from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Unidad_de_Medidas", "delete")) {
			Unidad_de_Medida::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.unidad_de_medidas.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('unidad_de_medidas')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Unidad_de_Medidas');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/unidad_de_medidas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Unidad_de_Medidas", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/unidad_de_medidas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Unidad_de_Medidas", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.unidad_de_medidas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
