<nav class="menu font-italic font-bold">
	<a href="{{ url('/') }}" class="btn-menu {{ request()->routeIs('home') ? 'btn-active' : '' }}">Compra en SERVITECAS</a>
	<a href="{{ url('/bases') }}" class="btn-menu {{ request()->routeIs('bases') ? 'btn-active' : '' }}">Bases</a>
	<a href="{{ url('/contacto') }}" class="btn-menu {{ request()->routeIs('contacto') ? 'btn-active' : '' }}">Contáctanos</a>
	<a href="{{ url('/serviteca') }}" class="btn-menu {{ request()->routeIs('serviteca') || request()->routeIs('login') || request()->routeIs('compra/revisar') || request()->routeIs('venta') ? 'btn-active' : '' }}">Usuarios</a>
</nav>