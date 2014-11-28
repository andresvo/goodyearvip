<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
    $regiones = Region::orderBy('numero')->get();
    return View::make('region')->with('regiones', $regiones);
});

Route::get('ciudad/listar/{id_region}', function($id_region)
{
    $ciudades = Ciudad::where('id_region', '=', $id_region)->orderBy('nombre')->get();
    return Response::json($ciudades);
});

Route::get('comuna/listar/{id_ciudad}', function($id_ciudad)
{
    $comunas = Comuna::where('id_ciudad', '=', $id_ciudad)->orderBy('nombre')->get();
    return Response::json($comunas);
});

Route::post('distribuidores', function()
{
	$comuna = Input::get('comuna');
    $distribuidores = Distribuidor::where('id_comuna','=',$comuna)->get();
    return View::make('distribuidor')->with('distribuidores', $distribuidores);
});

Route::any('login', function()
{
	$email = Input::get('email');
	$password = Input::get('password');
	if($email) {
		if (Auth::attempt(array('email' => $email, 'password' => $password))) {
			if(Auth::user()->profile == 2) return Redirect::to('admin');
			return Redirect::to('serviteca');
		} else {
			return View::make('login')->with('error', 'Usuario o contraseña incorrectos');
		}
    } else return View::make('login');


});

Route::get('logout', function()
{
	Auth::logout();
	return Redirect::to('login');
});

Route::any('serviteca', array('before' => 'auth', function()
{
	$codigo = Input::get('codigo');
	$mensaje = '';
	if($codigo) {
		$productos = Producto::orderBy('nombre')->get();
		$tarjeta = Tarjeta::where('codigo','=',strtoupper($codigo))->get();
		if(isset($tarjeta[0])) {
			$cupo = $tarjeta[0]->cupo_actual;
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
}));

Route::get('usuario/crear/{email}/{pwd}/{id_distribuidor}', function($email, $pwd, $id_distribuidor)
{
	$password = Hash::make($pwd);
	$user = new User;
	$user->name = 'Prueba';
	$user->email = $email;
	$user->password = $password;
	$user->id_distribuidor = $id_distribuidor;
	$user->save();
	return 'Ok';
});

Route::get('medida/listar/{id_producto}', function($id_producto)
{
    $medidas = Medida::where('id_producto', '=', $id_producto)->orderBy('nombre')->get();
    return Response::json($medidas);
});

Route::post('compra/revisar', array('before' => 'auth', function()
{
	$id_tarjeta = Input::get('id_tarjeta');
	$t = Tarjeta::find($id_tarjeta);
	$cantidad = Input::get('cantidad');
	$id_producto = Input::get('producto');
	$p = Producto::find($id_producto);
	$id_medida = Input::get('medida');
	$m = Medida::find($id_medida);
	$boleta = Input::get('boleta');
	$factura = Input::get('factura');
	
	return View::make('venta', array('id_tarjeta' => $id_tarjeta, 'codigo' => $t->codigo, 'cantidad' => $cantidad, 'producto' => $p, 'medida' => $m, 'boleta' => $boleta, 'factura' => $factura));

}));

Route::post('compra/crear', array('before' => 'auth', function()
{
	$id_tarjeta = Input::get('id_tarjeta');
	$cantidad = Input::get('cantidad');
	
	$compra = new Compra;
	$compra->id_usuario = Auth::user()->id;
	$compra->id_medida = Input::get('medida');
	$compra->id_tarjeta = $id_tarjeta;
	$compra->cantidad = $cantidad;
	$compra->boleta = Input::get('boleta');
	$compra->factura = Input::get('factura');
	$compra->save();
	
	$tarjeta = Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo - $cantidad;
	$tarjeta->save();
	return Redirect::to('venta');
}));

Route::get('compra/anular/{id_compra}', array('before' => 'auth', function($id_compra)
{	
	$compra = Compra::find($id_compra);
	$cantidad = $compra->cantidad;
	$id_tarjeta = $compra->id_tarjeta;
	$compra->cantidad = 0;
	$compra->save();
	
	$tarjeta = Tarjeta::find($id_tarjeta);
	$cupo = $tarjeta->cupo_actual;
	$tarjeta->cupo_actual = $cupo + $cantidad;
	$tarjeta->save();
	return Redirect::to('admin');
}));

Route::get('venta', array('before' => 'auth', function()
{
    return View::make('venta')->with('ingresada',true);
}));

Route::any('admin', array('before' => 'auth', function()
{
	if(Auth::user()->profile == 2) {
		$id_usuario = Input::get('id_usuario');
		$where = '';
		if($id_usuario) $where = 'WHERE compra.id_usuario = ' . intval($id_usuario);
		$compras = DB::select( DB::raw("SELECT compra.id, usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id $where ORDER BY compra.id DESC") );
		$usuarios = User::all();
		$opciones = array('' => 'Todos los usuarios');
		foreach($usuarios as $u) $opciones[$u->id] = $u->email;
		return View::make('admin', array('compras' => $compras, 'id_usuario' => $id_usuario, 'opciones' => $opciones));
	} else return 'No autorizado para acceder a esta sección';
}));

Route::get('excel', array('before' => 'auth', function()
{
	if(Auth::user()->profile == 2) {
		$compras = DB::select( DB::raw("SELECT usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id ORDER BY compra.id DESC") );

		Excel::create('ClienteVIP', function($excel) use($compras) {
		
			$excel->sheet('Ventas', function ($sheet) use($compras) {
			 	$row=1;
			 	$sheet->row($row, array('Usuario', 'Diseño', 'Medida', 'Cantidad', 'Tarjeta', 'Fecha creación'));
			 	foreach($compras as $c) {
			 		$row++;
			 		$sheet->row($row, array($c->email, $c->pnombre, $c->mnombre, $c->cantidad, $c->codigo, $c->created_at));
			 	}
			});
		})->export('xls');
	} else return 'No autorizado para acceder a esta sección';
}));

