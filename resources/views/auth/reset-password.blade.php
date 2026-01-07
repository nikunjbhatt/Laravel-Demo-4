@if($errors->any())
	@foreach($errors->all() as $error)
		<p style="text-align:center;color:red">{{ $error }}</p>
	@endforeach
@endif

<form method=post action="{{ route('password.update') }}">
	@csrf
	<input type=hidden name=token value="{{ $token }}">
	<table cellspacing=0 cellpadding=6 border=1 align=center>
		<tr>
			<td>Email Address</td>
			<td><input type="email" name=email value="{{ old('email') }}" required></td>
		</tr>
		<tr>
			<td>New Password</td>
			<td><input type="password" name=password required></td>
		</tr>
		<tr>
			<td>Confirm New Password</td>
			<td><input type="password" name=password_confirmation required></td>
		</tr>
	</table>

	<p style="text-align:center">
		<button>Change Password</button>
	</p>
</form>
