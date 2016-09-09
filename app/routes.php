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

Route::get('migrate', function() {
	define('STDIN',fopen("php://stdin","r"));
	$output = Artisan::call('migrate', ['--quiet' => true, '--force' => true]);
	dd($output);
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
    $distribuidores = Distribuidor::leftJoin('comuna', 'comuna.id', '=', 'distribuidor.id_comuna')->where('id_comuna','=',$comuna)->select('distribuidor.*', 'comuna.nombre AS comuna')->get();
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

Route::get('concursa', function()
{
    return View::make('concursa')->with('enviado', false);
});

Route::post('concursa', function()
{
    $nombre = Input::get('nombre');
    $email = Input::get('email');
    $marca = Input::get('marca');
    $modelo = Input::get('modelo');

    $c = new Concursante;
    $c->nombre = $nombre;
    $c->email = $email;
    $c->marca = $marca;
    $c->modelo = $modelo;
    $c->save();

    Mail::send('emails.concursa', array('nombre' => $nombre, 'email' => $email, 'marca' => $marca, 'modelo' => $modelo), function($message)
    {
        $message->from('noresponder@clientevipgoodyear.cl', 'Web Cliente VIP');
        $message->to('clientevipgoodyear@clientevipgoodyear.cl', 'Goodyear Cliente VIP')->subject('Concursa');
    });
    return View::make('concursa')->with('enviado', true);
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
		$productos = Producto::where('activo',1)->orderBy('nombre')->get();
        if(strlen($codigo) == 4) $codigo = 'GY'.$codigo;
        if(substr($codigo, 0, 1) == 'E') {
            $codigo = str_replace('-','', $codigo);
            $empresa = substr($codigo, 0, 2);
            $codigo = 'GY' . substr($codigo, 2) . $empresa;
        }
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
    $medidas = Medida::where('activo',1)->where('id_producto', '=', $id_producto)->orderBy('nombre')->get();
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
    $precio = Input::get('precio');

	return View::make('venta', array('id_tarjeta' => $id_tarjeta, 'codigo' => $t->codigo, 'cantidad' => $cantidad, 'producto' => $p, 'medida' => $m, 'boleta' => $boleta, 'factura' => $factura, 'precio' => $precio));

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
    $compra->precio = Input::get('precio');
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
		$where = '';
        $id_empresa = Input::get('id_empresa');
		if($id_empresa) $where .= ' AND tarjeta.id_empresa = ' . intval($id_empresa);
        $id_usuario = Input::get('id_usuario');
		if($id_usuario) $where .= ' AND compra.id_usuario = ' . intval($id_usuario);

		$compras = DB::select( DB::raw("SELECT compra.id, usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id WHERE true $where ORDER BY compra.id DESC") );

        $empresas = Empresa::all();
		$opcionesemp = array('' => 'Todas las empresas');
		foreach($empresas as $e) $opcionesemp[$e->id] = $e->nombre;

        $usuarios = User::all();
		$opciones = array('' => 'Todos los usuarios');
		foreach($usuarios as $u) $opciones[$u->id] = $u->email;

		return View::make('admin/admin', array('compras' => $compras, 'id_usuario' => $id_usuario, 'id_empresa' => $id_empresa, 'opciones' => $opciones, 'opcionesemp' => $opcionesemp));
	} else return 'No autorizado para acceder a esta sección';
}));

Route::any('admin/tarjetas', array('before' => 'auth', function()
{
	if(Auth::user()->profile == 2) {
		$empresas = DB::select( DB::raw("SELECT e.*, count(t.id) as tarjetas, min(codigo) as minimo, max(codigo) as maximo FROM empresa e LEFT JOIN tarjeta t ON t.id_empresa = e.id GROUP BY e.id ORDER BY e.id") );
		return View::make('admin/tarjetas', array('empresas' => $empresas));
	} else return 'No autorizado para acceder a esta sección';
}));

Route::post('admin/empresa/crear', array('before' => 'auth', function()
{
    $nombre = Input::get('nombre');

    $emp = Empresa::select(DB::raw('max(CAST(substring(sufijo,2) AS UNSIGNED)) as sufijo'))->first();
    $sufijo = 'E' . ($emp->sufijo + 1);
	$emp = new Empresa;
    $emp->nombre = $nombre;
    $emp->sufijo = $sufijo;
	$emp->save();
    return Redirect::to('admin/tarjetas');
}));

Route::post('admin/empresa/renombrar', array('before' => 'auth', function()
{
    $id = Input::get('id');
    $nombre = Input::get('nombre');

    $emp = Empresa::find($id);
    $emp->nombre = $nombre;
	$emp->save();
    return Redirect::to('admin/tarjetas');
}));

Route::post('admin/tarjetas/crear', array('before' => 'auth', function()
{
    $id_empresa = Input::get('id_empresa');
    $cantidad = Input::get('cantidad');

    $emp = Empresa::find($id_empresa);
    $sufijo = $emp->sufijo;
    $cant_actual = Tarjeta::where('id_empresa', $id_empresa)->count();
    $primera_nueva = $cant_actual + 1;
    $ultima_nueva = $cant_actual + $cantidad;
    for($i=$primera_nueva; $i<=$ultima_nueva; $i++) {
        $numero = 'GY' . str_pad($i, 4, '0', STR_PAD_LEFT) . $sufijo;
        $tarj = new Tarjeta;
        $tarj->codigo = $numero;
        $tarj->cupo_inicial = 4;
        $tarj->cupo_actual = 4;
        $tarj->id_empresa = $id_empresa;
        $tarj->save();
    }
    return Redirect::to('admin/tarjetas');
}));

Route::any('admin/concurso', array('before' => 'auth', function()
{
	if(Auth::user()->profile == 2) {
		$concursantes = Concursante::all();
		return View::make('admin/concurso', array('concursantes' => $concursantes));
	} else return 'No autorizado para acceder a esta sección';
}));

Route::get('admin/concursante/eliminar/{id}', array('before' => 'auth', function($id)
{
	if(Auth::user()->profile == 2) {
        $concursante = Concursante::find($id);
        if($concursante) $concursante->delete();
        return Redirect::to('admin/concurso');
	} else return 'No autorizado para acceder a esta sección';
}));

Route::get('excel/{id_empresa?}', array('before' => 'auth', function($id_empresa = null)
{
	if(Auth::user()->profile == 2) {
        $where = '';
		if($id_empresa != null) $where = ' WHERE tarjeta.id_empresa = ' . intval($id_empresa);

		$compras = DB::select( DB::raw("SELECT usuario.email, medida.nombre AS mnombre, producto.nombre AS pnombre, cantidad, tarjeta.codigo, compra.created_at, precio, boleta, factura FROM compra JOIN usuario ON compra.id_usuario = usuario.id JOIN medida ON compra.id_medida = medida.id JOIN producto ON medida.id_producto = producto.id JOIN tarjeta ON compra.id_tarjeta = tarjeta.id $where ORDER BY compra.id DESC") );

		Excel::create('ClienteVIP', function($excel) use($compras) {

			$excel->sheet('Ventas', function ($sheet) use($compras) {
			 	$row=1;
			 	$sheet->row($row, array('Usuario', 'Diseño', 'Medida', 'Cantidad', 'Tarjeta', 'Precio unitario', 'Boleta', 'Factura', 'Fecha creación'));
			 	foreach($compras as $c) {
			 		$row++;
			 		$sheet->row($row, array($c->email, $c->pnombre, $c->mnombre, $c->cantidad, $c->codigo, $c->precio, $c->boleta, $c->factura, $c->created_at));
			 	}
			});
		})->export('xls');
	} else return 'No autorizado para acceder a esta sección';
}));
