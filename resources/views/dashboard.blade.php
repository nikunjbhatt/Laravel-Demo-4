@auth
	<a href="#">Logout</a>
@else
	<a href="{{ route('login-form') }}">Login</a>
@endauth
<h1>Welcome</h1>