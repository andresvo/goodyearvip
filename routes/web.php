<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\TarjetaController;
use App\Http\Controllers\DisenoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    $regiones = App\Models\Region::orderBy('numero')->get();
    return View::make('region')->with('regiones', $regiones);
});

Route::get('migrate', function() {
	define('STDIN',fopen("php://stdin","r"));
	$output = Artisan::call('migrate', ['--quiet' => true, '--force' => true]);
	dd($output);
});

Route::get('ciudad/listar/{id_region}', function($id_region)
{
    $ciudades = App\Models\Ciudad::where('id_region', '=', $id_region)->orderBy('nombre')->get();
    return response()->json($ciudades);
});

Route::get('comuna/listar/{id_ciudad}', function($id_ciudad)
{
    $comunas = App\Models\Comuna::where('id_ciudad', '=', $id_ciudad)->orderBy('nombre')->get();
    return response()->json($comunas);
});

Route::post('distribuidores', function(Request $request)
{
	$comuna = $request->input('comuna');
    $distribuidores = App\Models\Distribuidor::leftJoin('comuna', 'comuna.id', '=', 'distribuidor.id_comuna')->where('id_comuna','=',$comuna)->select('distribuidor.*', 'comuna.nombre AS comuna')->get();
    return view('distribuidor')->with('distribuidores', $distribuidores);
});

Route::get('la-tarjeta-vip', function()
{
    return view('la-tarjeta-vip');
});

Route::get('como-funciona', function()
{
    return view('como-funciona');
});

Route::get('contacto', function()
{
    return view('contacto')->with('enviado', false);
});

Route::post('contacto', function(Request $request)
{
    $nombre = $request->input('nombre');
    $email = $request->input('email');
    $comentario = $request->input('comentario');
    Mail::send('emails.contacto', array('nombre' => $nombre, 'email' => $email, 'comentario' => $comentario), function($message)
    {
        $message->from('noresponder@clientevipgoodyear.cl', 'Web Cliente VIP');
        $message->to('clientevipgoodyear@clientevipgoodyear.cl', 'Goodyear Cliente VIP')->subject('Contacto');
    });
    return view('contacto')->with('enviado', true);
});



Route::any('login', function(Request $request)
{
	$email = $request->input('email');
	$password = $request->input('password');
	if($email) {
		if (Auth::attempt(array('email' => $email, 'password' => $password))) {
			if(Auth::user()->profile == 2) return Redirect::to('admin');
			return Redirect::to('serviteca');
        } elseif (Auth::attempt(array('email' => $email, 'password' => substr($password, 0, 10)))) {
            if(Auth::user()->profile == 2) return Redirect::to('admin');
            return Redirect::to('serviteca');
        } else {
			return view('login')->with('error', 'Usuario o contraseña incorrectos');
		}
    } else return view('login');
})->name('login');

Route::get('logout', function() {
	Auth::logout();
	return Redirect::to('login');
});


Route::any('serviteca', ['middleware' => 'auth', function(Request $request) {
	$codigo = $request->input('codigo');
	$mensaje = '';
	if($codigo) {
		$productos = App\Models\Producto::where('activo',1)->orderBy('nombre')->get();
        if(strlen($codigo) == 4) $codigo = 'GY'.$codigo;
        if(substr($codigo, 0, 1) == 'E') {
            $codigo = str_replace('-','', $codigo);
            $empresa = substr($codigo, 0, 2);
            $codigo = 'GY' . substr($codigo, 2) . $empresa;
        }
		$tarjeta = App\Models\Tarjeta::where('codigo','=',strtoupper($codigo))->get();
		if(isset($tarjeta[0])) {
            if($tarjeta[0]->cupo_actual > 4) $cupo = 4;
			else $cupo = $tarjeta[0]->cupo_actual;
			$id_tarjeta = $tarjeta[0]->id;
		}
		else {
			$mensaje = 'sasdca';
			return view('serviteca', array('mensaje' => $mensaje));
		}
	} else {
		$productos = null;
		$cupo = null;
		$id_tarjeta = null;
	}
	return view('serviteca', array('codigo' => $codigo, 'mensaje' => $mensaje, 'productos' => $productos, 'cupo' => $cupo, 'id_tarjeta' => $id_tarjeta));
}]);

Route::get('usuario/crear/{email}/{pwd}/{id_distribuidor}', function($email, $pwd, $id_distribuidor)
{
	$password = Hash::make($pwd);
	$user = new App\Models\User;
	$user->name = 'Prueba';
	$user->email = $email;
	$user->password = $password;
	$user->id_distribuidor = $id_distribuidor;
	$user->save();
	return 'Ok';
});

// Route::get('usuario/cambiarpwd/{email}/{pwd}', function($email, $pwd)
// {
// 	$password = Hash::make($pwd);
// 	$user = User::where('email', '=', $email)->first();
// 	$user->password = $password;
// 	$user->save();
// 	return 'Ok';
// });

Route::get('medida/listar/{id_producto}', function($id_producto)
{
    $medidas = App\Models\Medida::where('activo',1)->where('id_producto', '=', $id_producto)->orderBy('nombre')->get();
    return response()->json($medidas);
});

Route::post('compra/revisar', ['middleware' => 'auth', function(Request $request) {
	$id_tarjeta = $request->input('id_tarjeta');
	$t = App\Models\Tarjeta::find($id_tarjeta);
	$cantidad = $request->input('cantidad');
	$id_producto = $request->input('producto');
	$p = App\Models\Producto::find($id_producto);
	$id_medida = $request->input('medida');
	$m = App\Models\Medida::find($id_medida);
	$boleta = $request->input('boleta');
    $factura = $request->input('factura');
    $precio = $request->input('precio');

	return view('venta', array('id_tarjeta' => $id_tarjeta, 'codigo' => $t->codigo, 'cantidad' => $cantidad, 'producto' => $p, 'medida' => $m, 'boleta' => $boleta, 'factura' => $factura, 'precio' => $precio));

}]);

Route::post('compra/crear', ['middleware' => 'auth', function(Request $request) {
	$id_tarjeta = $request->input('id_tarjeta');
	$cantidad = $request->input('cantidad');

	$compra = new App\Models\Compra;
	$compra->id_usuario = Auth::user()->id;
	$compra->id_medida = $request->input('medida');
	$compra->id_tarjeta = $id_tarjeta;
	$compra->cantidad = $cantidad;
	$compra->boleta = $request->input('boleta');
    $compra->factura = $request->input('factura');
    $compra->precio = $request->input('precio');
	$compra->save();

	$tarjeta = App\Models\Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo - $cantidad;
	$tarjeta->save();
	return Redirect::to('venta');
}]);

Route::get('compra/anular/{id_compra}', ['middleware' => 'auth', function($id_compra) {
	$compra = App\Models\Compra::find($id_compra);
	$cantidad = $compra->cantidad;
	$id_tarjeta = $compra->id_tarjeta;
	$compra->cantidad = 0;
	$compra->save();

	$tarjeta = App\Models\Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo + $cantidad;
	$tarjeta->save();
	return Redirect::to('admin');
}]);

Route::get('venta', ['middleware' => 'auth', function() {
    return view('venta')->with('ingresada',true);
}]);

Route::any('admin', ['middleware' => 'auth', function(Request $request) {
	if(Auth::user()->profile == 2) {
		$where = '';
        $id_empresa = $request->input('id_empresa');
		if($id_empresa) $where .= ' AND tarjeta.id_empresa = ' . intval($id_empresa);
        $id_usuario = $request->input('id_usuario');
		if($id_usuario) $where .= ' AND compra.id_usuario = ' . intval($id_usuario);

		$compras = DB::select( DB::raw("SELECT compra.id, usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id WHERE true $where ORDER BY compra.id DESC") );

        $empresas = App\Models\Empresa::all();
		$opcionesemp = array('' => 'Todas las empresas');
		foreach($empresas as $e) $opcionesemp[$e->id] = $e->nombre;

        $usuarios = App\Models\User::all();
		$opciones = array('' => 'Todos los usuarios');
		foreach($usuarios as $u) $opciones[$u->id] = $u->email;

		return view('admin/admin', array('compras' => $compras, 'id_usuario' => $id_usuario, 'id_empresa' => $id_empresa, 'opciones' => $opciones, 'opcionesemp' => $opcionesemp));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::any('admin/tarjetas', [TarjetaController::class, 'getIndex'])->middleware('auth');
Route::post('admin/tarjetas/crear', [TarjetaController::class, 'postCrear'])->middleware('auth');
Route::post('admin/tarjetas/descargar', [TarjetaController::class, 'postDescargar']);
Route::get('admin/tarjetas/exportar/{id_empresa}', [TarjetaController::class, 'exportar']);
Route::any('admin/disenos', [DisenoController::class, 'getIndex'])->middleware('auth');
Route::any('admin/diseno/imagen/{id}', [DisenoController::class, 'displayImage'])->middleware('auth');
Route::post('admin/diseno/crear', [DisenoController::class, 'postCrear'])->middleware('auth');
Route::post('admin/diseno/renombrar', [DisenoController::class, 'postRenombrar'])->middleware('auth');
Route::any('admin/diseno/eliminar/{id}', [DisenoController::class, 'getEliminar'])->middleware('auth');
Route::post('admin/codigo/crear', [TarjetaController::class, 'postCodigoCrear'])->middleware('auth');
Route::post('admin/empresa/crear', [TarjetaController::class, 'postEmpresaCrear'])->middleware('auth');
Route::post('admin/empresa/renombrar', [TarjetaController::class, 'postEmpresaRenombrar'])->middleware('auth');

Route::any('admin/concurso', ['middleware' => 'auth', function() {
	if(Auth::user()->profile == 2) {
		$concursantes = App\Models\Concursante::all();
		return view('admin/concurso', array('concursantes' => $concursantes));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::get('admin/concursante/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $concursante = App\Models\Concursante::find($id);
        if($concursante) $concursante->delete();
        return Redirect::to('admin/concurso');
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::any('admin/productos', ['middleware' => 'auth', function() {
	if(Auth::user()->profile == 2) {
        $productos = App\Models\Producto::orderBy('nombre')->get();
		$opcionesprod = $opcionesmed = array();
		foreach($productos as $p) {
            $opcionesprod[$p->id] = array('nombre' => $p->nombre, 'activo' => $p->activo);
        }
        return view('admin/productos', array('productos' => $productos, 'json_productos' => json_encode($opcionesprod)));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::post('admin/producto/crear', ['middleware' => 'auth', function(Request $request) {
    $nombre = $request->input('nombre');

    if($nombre != '') {
    	$producto = new App\Models\Producto;
        $producto->nombre = $nombre;
        $producto->save();
    }
    return Redirect::to('admin/productos');
}]);

Route::post('admin/producto/editar', ['middleware' => 'auth', function(Request $request) {
    $id = $request->input('id');
    $nombre = $request->input('nombre');
    $activo = $request->input('activo') == 1;

    if($nombre != '') {
        $producto = App\Models\Producto::find($id);
        $producto->nombre = $nombre;
        $producto->activo = $activo;
        $producto->save();
    }
    return Redirect::to('admin/productos');
}]);

Route::get('admin/producto/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $producto = App\Models\Producto::find($id);
        if($producto) {
            try{
                $res = $producto->delete();
                return Redirect::to('admin/productos');
            }
            catch (Illuminate\Database\QueryException $e){
                return 'No se pudo eliminar debido a que tiene registros asociados.';
            }
        }
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::any('admin/medidas/{id_producto}', ['middleware' => 'auth', function($id_producto = null) {
	if(Auth::user()->profile == 2) {
        $producto = App\Models\Producto::find($id_producto);
		$medidas = App\Models\Producto::join('medida', 'medida.id_producto', '=', 'producto.id')->where('id_producto','=',$id_producto)->orderBy('medida.id_producto')->orderBy('medida.nombre')->get();
        return view('admin/medidas', array('producto' => $producto, 'medidas' => $medidas));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::post('admin/medida/crear', ['middleware' => 'auth', function(Request $request) {
    $nombre = $request->input('nombre');
    $id_producto = $request->input('id_producto');

    if($nombre != '' && $id_producto != '') {
    	$medida = new App\Models\Medida;
        $medida->nombre = $nombre;
        $medida->id_producto = $id_producto;
        $medida->save();
    }
    return Redirect::to('admin/medidas/' . $id_producto);
}]);

Route::get('admin/medida/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $medida = App\Models\Medida::find($id);
        $id_producto = $medida->id_producto;
        if($medida) {
            try{
                $res = $medida->delete();
                return Redirect::to('admin/medidas/' . $id_producto);
            }
            catch (Illuminate\Database\QueryException $e){
                return 'No se pudo eliminar debido a que tiene registros asociados.';
            }
        }
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::get('excel/{id_empresa?}', ['middleware' => 'auth', function($id_empresa = null) {
	if(Auth::user()->profile == 2) {
		$export = new App\Exports\ComprasExport;
		$export->id_empresa = $id_empresa;
		return Excel::download($export, 'ventas.xlsx');
	} else return 'No autorizado para acceder a esta sección';
}]);


Route::get('productos/importar', function() {
	$result = Maatwebsite\Excel\Facades\Excel::import(new App\Imports\ProductosImport, 'productos.xlsx');
	return response()->json($result);
});