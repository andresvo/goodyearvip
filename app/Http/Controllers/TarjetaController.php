<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Tarjeta;
use App\Models\Diseno;
use App\Models\Empresa;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use App\Exports\TarjetasExport;
use Maatwebsite\Excel\Facades\Excel;

class TarjetaController extends Controller
{
    public function getIndex() {
		if(Auth::user()->profile == 2) {
			$empresas = DB::select( DB::raw("SELECT e.*, count(t.id) as tarjetas, min(numero) as minimo, max(numero) as maximo
				FROM empresa e LEFT JOIN tarjeta t ON t.id_empresa = e.id AND t.tipo = 1
				GROUP BY e.id ORDER BY e.id") );
			$codigos = Tarjeta::where('tipo', '=', 2)->get();
			$codempresa = array();
			foreach ($codigos as $key => $row) {
				$codempresa[$row['id_empresa']][] = $row['codigo'];
			}
			$disenos = Diseno::orderBy('nombre')->get();
			foreach($disenos as $diseno) {
				$diseno->imagen = url('admin/diseno/imagen/' . $diseno->id);
			}
			return view('admin/tarjetas')->with(compact('empresas', 'codempresa', 'disenos'));
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
			$codigo = $this->generarAleatorio() . $sufijo;
			$tarj = new Tarjeta;
			$tarj->codigo = $codigo;
			$tarj->numero = $i;
			$tarj->cupo_inicial = 4;
			$tarj->cupo_actual = 4;
			$tarj->id_empresa = $id_empresa;
			$tarj->tipo = 1;
			$tarj->save();
		}
		return redirect('admin/tarjetas');
	}

	protected function generarAleatorio() {
		$random = strtoupper(bin2hex(random_bytes(3)));
		$tarjeta = Tarjeta::where('codigo', $random)->first();
		while($tarjeta) {
			$random = strtoupper(bin2hex(random_bytes(3)));
			$tarjeta = Tarjeta::where('codigo', $random)->first();
		}
		return $random;
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

	public function postGenerar(Request $request) {
		$id_empresa = intval($request->input('id_empresa'));
		$desde = intval($request->input('desde'));
		$cantidad = intval($request->input('cantidad'));
		$id_diseno = intval($request->input('id_diseno'));
		exec(implode(' ', ['php', base_path() . '/artisan tarjetas:imagenes', $id_empresa, $desde, $cantidad, $id_diseno, '> /dev/null &']), $output);
		return json_encode($output);
	}

	public function getGenerarProgreso() {
		return file_get_contents(storage_path('logs/bg.log'));
	}

	public function postDescargar(Request $request) {
		$id_empresa = intval($request->input('id_empresa'));
		$desde = intval($request->input('desde'));
		$cantidad = intval($request->input('cantidad'));
        $empresa = Empresa::find($id_empresa);
		$zip_filename = 'tarjetas-' . $empresa->sufijo . '-' . $desde . '-' . ($desde + $cantidad -1) . '.zip';
		return response()->download(storage_path('app/public/tarjetas.zip'), $zip_filename, ['Content-Type' => 'application/octet-stream']);
	}

	public function exportar($id_empresa) {
		if(Auth::user()->profile == 2) {
			$export = new TarjetasExport;
			$export->id_empresa = $id_empresa;
			return Excel::download($export, 'tarjetas.xlsx');
		} else return 'No autorizado para acceder a esta sección';
	}
}
