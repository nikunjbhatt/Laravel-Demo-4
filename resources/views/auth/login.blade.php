@if($errors->any())
	@foreach($errors->all() as $error)
		<p style="text-align:center;color:red">{{ $error }}</p>
	@endforeach
@endif
<form method=post>
	@csrf
	<table cellspacing=0 cellpadding=6 border=1 align=center>
		<tr>
			<td>Email Address</td>
			<td><input type="email" name=email value="{{ old('email') }}" required></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type="password" name=password required></td>
		</tr>
		<tr>
			<td>Remember Login?</td>
			<td><input type="checkbox" name=remember_login value=true></td>
		</tr>
	</table>
	<p style="text-align: center">
		<button>Login</button>
	</p>
</form>
