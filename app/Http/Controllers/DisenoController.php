<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diseno;
use Auth;

class DisenoController extends Controller
{
    public function getIndex() {
		if(Auth::user()->profile == 2) {
			$disenos = Diseno::orderBy('nombre')->get();
			foreach($disenos as $diseno) {
				$diseno->imagen = url('admin/diseno/imagen/' . $diseno->id);
			}
			return view('admin/disenos')->with(compact('disenos'));
		} else return 'No autorizado para acceder a esta sección';
	}

	public function postCrear(Request $request) {
		$nombre = $request->input('nombre');
        $path = $request->file('imagen')->store('tarjeta');
		$diseno = new Diseno;
		$diseno->nombre = $nombre;
		$diseno->archivo = $path;
		$diseno->save();
		return redirect('admin/disenos');
	}

	public function postRenombrar(Request $request) {
		$id = $request->input('id');
		$nombre = $request->input('nombre');
		$diseno = Diseno::find($id);
		$diseno->nombre = $nombre;
		$diseno->save();
		return redirect('admin/disenos');
	}

	public function getEliminar($id) {
		$diseno = Diseno::destroy($id);
		return redirect('admin/disenos');
	}

	public function displayImage($id) {
		$diseno = Diseno::find($id);
		return response()->file(storage_path('app/' . $diseno->archivo));
	}
}
