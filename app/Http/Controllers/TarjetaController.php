<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Tarjeta;
use App\Empresa;

class TarjetaController extends Controller
{
    public function getIndex() {
		if(Auth::user()->profile == 2) {
			$empresas = DB::select( DB::raw("SELECT e.*, count(t.id) as tarjetas, min(codigo) as minimo, max(codigo) as maximo
				FROM empresa e LEFT JOIN tarjeta t ON t.id_empresa = e.id AND t.tipo = 1
				GROUP BY e.id ORDER BY e.id") );
			$codigos = Tarjeta::where('tipo', '=', 2)->get();
			$codempresa = array();
			foreach ($codigos as $key => $row) {
				$codempresa[$row['id_empresa']][] = $row['codigo'];
			}
			return view('admin/tarjetas')->with(compact('empresas', 'codempresa'));
		} else return 'No autorizado para acceder a esta sección';
	}

	public function postCrear(Request $request) {
		$id_empresa = $request->input('id_empresa');
		$cantidad = $request->input('cantidad');

		$emp = Empresa::find($id_empresa);
		$sufijo = $emp->sufijo;
		$cant_actual = Tarjeta::where('id_empresa', $id_empresa)->where('tipo', '=', 1)->count();
		$primera_nueva = $cant_actual + 1;
		$ultima_nueva = $cant_actual + $cantidad;
		for($i=$primera_nueva; $i<=$ultima_nueva; $i++) {
			$numero = 'GY' . str_pad($i, 4, '0', STR_PAD_LEFT) . $sufijo;
			$tarj = new Tarjeta;
			$tarj->codigo = $numero;
			$tarj->cupo_inicial = 4;
			$tarj->cupo_actual = 4;
			$tarj->id_empresa = $id_empresa;
			$tarj->tipo = 1;
			$tarj->save();
		}
		return redirect('admin/tarjetas');
	}

	public function postCodigoCrear(Request $request) {
		$tarj = new Tarjeta;
		$tarj->codigo = strtoupper($request->input('codigo'));
		$tarj->cupo_inicial = $request->input('cupo');
		$tarj->cupo_actual = $request->input('cupo');
		$tarj->id_empresa = $request->input('id_empresa');
		$tarj->tipo = 2;
		$tarj->save();
		return redirect('admin/tarjetas');
	}

	public function postEmpresaCrear(Request $request) {
		$nombre = $request->input('nombre');
		$emp = Empresa::select(DB::raw('max(CAST(substring(sufijo,2) AS UNSIGNED)) as sufijo'))->first();
		$sufijo = 'E' . ($emp->sufijo + 1);
		$emp = new Empresa;
		$emp->nombre = $nombre;
		$emp->sufijo = $sufijo;
		$emp->save();
		return redirect('admin/tarjetas');
	}

	public function postEmpresaRenombrar(Request $request) {
		$id = $request->input('id');
		$nombre = $request->input('nombre');
		$emp = Empresa::find($id);
		$emp->nombre = $nombre;
		$emp->save();
		return redirect('admin/tarjetas');
	}

	public function postDescargar() {
		$tarjetas = Tarjeta::where('tipo', 1)->where('id_empresa', 28)->take(10)->get();
		foreach($tarjetas as $tarjeta) {
			$im = imagecreatefrompng(storage_path('app/tarjeta/dacsa.png'));
			$negro = imagecolorallocate($im, 0, 0, 0);
			$fuente = storage_path('app/tarjeta/OpenSans-SemiBold.ttf');
			imagettftext($im, 24, 0, 350 , 223, $negro, $fuente, $tarjeta->codigo);
			imagepng($im, storage_path('app/public/' . $tarjeta->codigo . '.png'));
			imagedestroy($im);
		}
	}
}
