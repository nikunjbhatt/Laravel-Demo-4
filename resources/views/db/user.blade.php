@if($errors->any())
	@foreach ($errors->all() as $error)
		<p style="color:red;text-align:center">{{ $error }}</p>
	@endforeach
@endif
@if(session('insert'))
	<p style="color:green;text-align:center">{{ session('insert') }}</p>
@endif
<form method="post" action="{{ isset($user) ? route('db.user-update', ['userId' => $user->id]) : route('db.user-insert') }}">
	@csrf
	<table style="margin:auto" cellpadding=6>
		<tr>
			<td>Name</td>
			<td><input name=name value="{{ old('name') ? old('name') : (isset($user) ? $user->name : '') }}"></td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><input type=email name=email_address value="{{ old('email_address') ? old('email_address') : (isset($user) ? $user->email : '') }}"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type=password name=password></td>
		</tr>
		<tr>
			<td>Confirm Password</td>
			<td><input type=password name=password_confirmation></td>
		</tr>
	</table>
	<p style="text-align:center">
		<button>@if(isset($user)) Update @else Insert @endif</button>
	</p>
</form>
