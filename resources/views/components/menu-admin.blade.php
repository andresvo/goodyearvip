<nav class="menu menu-admin font-italic font-bold">
	<a class="{{ (substr(url()->current(), -5) == 'admin')? 'btn-active' : '' }}" href="{{ url('admin') }}">Ventas</a>
	<a class="{{ (strstr(url()->current(), 'tarjetas') !== false)? 'btn-active' : '' }}" href="{{ url('admin/tarjetas') }}">Tarjetas</a>
	<a class="{{ (strstr(url()->current(), 'disenos') !== false)? 'btn-active' : '' }}" href="{{ url('admin/disenos') }}">Diseños Tarjetas</a>
	<a class="{{ (strstr(url()->current(), 'concurso') !== false)? 'btn-active' : '' }}" href="{{ url('admin/concurso') }}">Concurso</a>
	<a class="{{ (strstr(url()->current(), 'productos') !== false || strstr(url()->current(), 'medidas') !== false)? 'btn-active' : '' }}" href="{{ url('admin/productos') }}">Productos</a>
</nav>