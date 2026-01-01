@auth
	<a href="{{ route('logout') }}">Logout</a>
@else
	<a href="{{ route('login-form') }}">Login</a>
@endauth
<h1>Welcome @auth User {{ auth()->id() }} @endauth</h1>