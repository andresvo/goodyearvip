<?php

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

Route::get('/', function()
{
    $regiones = App\Region::orderBy('numero')->get();
    return View::make('region')->with('regiones', $regiones);
});

Route::get('migrate', function() {
	define('STDIN',fopen("php://stdin","r"));
	$output = Artisan::call('migrate', ['--quiet' => true, '--force' => true]);
	dd($output);
});

Route::get('ciudad/listar/{id_region}', function($id_region)
{
    $ciudades = App\Ciudad::where('id_region', '=', $id_region)->orderBy('nombre')->get();
    return Response::json($ciudades);
});

Route::get('comuna/listar/{id_ciudad}', function($id_ciudad)
{
    $comunas = App\Comuna::where('id_ciudad', '=', $id_ciudad)->orderBy('nombre')->get();
    return Response::json($comunas);
});

Route::post('distribuidores', function()
{
	$comuna = Input::get('comuna');
    $distribuidores = App\Distribuidor::leftJoin('comuna', 'comuna.id', '=', 'distribuidor.id_comuna')->where('id_comuna','=',$comuna)->select('distribuidor.*', 'comuna.nombre AS comuna')->get();
    return View::make('distribuidor')->with('distribuidores', $distribuidores);
});

Route::get('la-tarjeta-vip', function()
{
    return View::make('la-tarjeta-vip');
});

Route::get('como-funciona', function()
{
    return View::make('como-funciona');
});

Route::get('contacto', function()
{
    return View::make('contacto')->with('enviado', false);
});

Route::post('contacto', function()
{
    $nombre = Input::get('nombre');
    $email = Input::get('email');
    $comentario = Input::get('comentario');
    Mail::send('emails.contacto', array('nombre' => $nombre, 'email' => $email, 'comentario' => $comentario), function($message)
    {
        $message->from('noresponder@clientevipgoodyear.cl', 'Web Cliente VIP');
        $message->to('clientevipgoodyear@clientevipgoodyear.cl', 'Goodyear Cliente VIP')->subject('Contacto');
    });
    return View::make('contacto')->with('enviado', true);
});



Route::any('login', function()
{
	$email = Input::get('email');
	$password = Input::get('password');
	if($email) {
		if (Auth::attempt(array('email' => $email, 'password' => $password))) {
			if(Auth::user()->profile == 2) return Redirect::to('admin');
			return Redirect::to('serviteca');
        } elseif (Auth::attempt(array('email' => $email, 'password' => substr($password, 0, 10)))) {
            if(Auth::user()->profile == 2) return Redirect::to('admin');
            return Redirect::to('serviteca');
        } else {
			return View::make('login')->with('error', 'Usuario o contraseña incorrectos');
		}
    } else return View::make('login');
})->name('login');

Route::get('logout', function()
{
	Auth::logout();
	return Redirect::to('login');
});


Route::any('serviteca', ['middleware' => 'auth', function() {
	$codigo = Input::get('codigo');
	$mensaje = '';
	if($codigo) {
		$productos = App\Producto::where('activo',1)->orderBy('nombre')->get();
        if(strlen($codigo) == 4) $codigo = 'GY'.$codigo;
        if(substr($codigo, 0, 1) == 'E') {
            $codigo = str_replace('-','', $codigo);
            $empresa = substr($codigo, 0, 2);
            $codigo = 'GY' . substr($codigo, 2) . $empresa;
        }
		$tarjeta = App\Tarjeta::where('codigo','=',strtoupper($codigo))->get();
		if(isset($tarjeta[0])) {
            if($tarjeta[0]->cupo_actual > 4) $cupo = 4;
			else $cupo = $tarjeta[0]->cupo_actual;
			$id_tarjeta = $tarjeta[0]->id;
		}
		else {
			$mensaje = 'sasdca';
			return View::make('serviteca', array('mensaje' => $mensaje));
		}
	} else {
		$productos = null;
		$cupo = null;
		$id_tarjeta = null;
	}
	return View::make('serviteca', array('codigo' => $codigo, 'mensaje' => $mensaje, 'productos' => $productos, 'cupo' => $cupo, 'id_tarjeta' => $id_tarjeta));
}]);

Route::get('usuario/crear/{email}/{pwd}/{id_distribuidor}', function($email, $pwd, $id_distribuidor)
{
	$password = Hash::make($pwd);
	$user = new App\User;
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
    $medidas = App\Medida::where('activo',1)->where('id_producto', '=', $id_producto)->orderBy('nombre')->get();
    return Response::json($medidas);
});

Route::post('compra/revisar', ['middleware' => 'auth', function() {
	$id_tarjeta = Input::get('id_tarjeta');
	$t = App\Tarjeta::find($id_tarjeta);
	$cantidad = Input::get('cantidad');
	$id_producto = Input::get('producto');
	$p = App\Producto::find($id_producto);
	$id_medida = Input::get('medida');
	$m = App\Medida::find($id_medida);
	$boleta = Input::get('boleta');
    $factura = Input::get('factura');
    $precio = Input::get('precio');

	return View::make('venta', array('id_tarjeta' => $id_tarjeta, 'codigo' => $t->codigo, 'cantidad' => $cantidad, 'producto' => $p, 'medida' => $m, 'boleta' => $boleta, 'factura' => $factura, 'precio' => $precio));

}]);

Route::post('compra/crear', ['middleware' => 'auth', function() {
	$id_tarjeta = Input::get('id_tarjeta');
	$cantidad = Input::get('cantidad');

	$compra = new App\Compra;
	$compra->id_usuario = Auth::user()->id;
	$compra->id_medida = Input::get('medida');
	$compra->id_tarjeta = $id_tarjeta;
	$compra->cantidad = $cantidad;
	$compra->boleta = Input::get('boleta');
    $compra->factura = Input::get('factura');
    $compra->precio = Input::get('precio');
	$compra->save();

	$tarjeta = App\Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo - $cantidad;
	$tarjeta->save();
	return Redirect::to('venta');
}]);

Route::get('compra/anular/{id_compra}', ['middleware' => 'auth', function($id_compra) {
	$compra = App\Compra::find($id_compra);
	$cantidad = $compra->cantidad;
	$id_tarjeta = $compra->id_tarjeta;
	$compra->cantidad = 0;
	$compra->save();

	$tarjeta = App\Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo + $cantidad;
	$tarjeta->save();
	return Redirect::to('admin');
}]);

Route::get('venta', ['middleware' => 'auth', function() {
    return View::make('venta')->with('ingresada',true);
}]);

Route::any('admin', ['middleware' => 'auth', function() {
	if(Auth::user()->profile == 2) {
		$where = '';
        $id_empresa = Input::get('id_empresa');
		if($id_empresa) $where .= ' AND tarjeta.id_empresa = ' . intval($id_empresa);
        $id_usuario = Input::get('id_usuario');
		if($id_usuario) $where .= ' AND compra.id_usuario = ' . intval($id_usuario);

		$compras = DB::select( DB::raw("SELECT compra.id, usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id WHERE true $where ORDER BY compra.id DESC") );

        $empresas = App\Empresa::all();
		$opcionesemp = array('' => 'Todas las empresas');
		foreach($empresas as $e) $opcionesemp[$e->id] = $e->nombre;

        $usuarios = App\User::all();
		$opciones = array('' => 'Todos los usuarios');
		foreach($usuarios as $u) $opciones[$u->id] = $u->email;

		return View::make('admin/admin', array('compras' => $compras, 'id_usuario' => $id_usuario, 'id_empresa' => $id_empresa, 'opciones' => $opciones, 'opcionesemp' => $opcionesemp));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::any('admin/tarjetas', 'TarjetaController@getIndex')->middleware('auth');
Route::post('admin/tarjetas/crear', 'TarjetaController@postCrear')->middleware('auth');
Route::get('tarjeta', 'TarjetaController@postDescargar');
Route::post('admin/codigo/crear', 'TarjetaController@postCodigoCrear')->middleware('auth');
Route::post('admin/empresa/crear', 'TarjetaController@postEmpresaCrear')->middleware('auth');
Route::post('admin/empresa/renombrar', 'TarjetaController@postEmpresaRenombrar')->middleware('auth');

Route::any('admin/concurso', ['middleware' => 'auth', function() {
	if(Auth::user()->profile == 2) {
		$concursantes = App\Concursante::all();
		return View::make('admin/concurso', array('concursantes' => $concursantes));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::get('admin/concursante/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $concursante = App\Concursante::find($id);
        if($concursante) $concursante->delete();
        return Redirect::to('admin/concurso');
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::any('admin/productos', ['middleware' => 'auth', function() {
	if(Auth::user()->profile == 2) {
        $productos = App\Producto::orderBy('nombre')->get();
		$opcionesprod = $opcionesmed = array();
		foreach($productos as $p) {
            $opcionesprod[$p->id] = array('nombre' => $p->nombre, 'activo' => $p->activo);
        }
        return View::make('admin/productos', array('productos' => $productos, 'json_productos' => json_encode($opcionesprod)));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::post('admin/producto/crear', ['middleware' => 'auth', function() {
    $nombre = Input::get('nombre');

    if($nombre != '') {
    	$producto = new App\Producto;
        $producto->nombre = $nombre;
        $producto->save();
    }
    return Redirect::to('admin/productos');
}]);

Route::post('admin/producto/editar', ['middleware' => 'auth', function() {
    $id = Input::get('id');
    $nombre = Input::get('nombre');
    $activo = Input::get('activo') == 1;

    if($nombre != '') {
        $producto = App\Producto::find($id);
        $producto->nombre = $nombre;
        $producto->activo = $activo;
        $producto->save();
    }
    return Redirect::to('admin/productos');
}]);

Route::get('admin/producto/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $producto = App\Producto::find($id);
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
        $producto = App\Producto::find($id_producto);
		$medidas = App\Producto::join('medida', 'medida.id_producto', '=', 'producto.id')->where('id_producto','=',$id_producto)->orderBy('medida.id_producto')->orderBy('medida.nombre')->get();
        return View::make('admin/medidas', array('producto' => $producto, 'medidas' => $medidas));
	} else return 'No autorizado para acceder a esta sección';
}]);

Route::post('admin/medida/crear', ['middleware' => 'auth', function() {
    $nombre = Input::get('nombre');
    $id_producto = Input::get('id_producto');

    if($nombre != '' && $id_producto != '') {
    	$medida = new App\Medida;
        $medida->nombre = $nombre;
        $medida->id_producto = $id_producto;
        $medida->save();
    }
    return Redirect::to('admin/medidas/' . $id_producto);
}]);

Route::get('admin/medida/eliminar/{id}', ['middleware' => 'auth', function($id) {
	if(Auth::user()->profile == 2) {
        $medida = App\Medida::find($id);
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
