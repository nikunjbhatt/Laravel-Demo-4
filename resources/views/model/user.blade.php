<form method=post action="{{ isset($user) ? route('model.user-update', ['userId' => $user->id]) : route('model.user-create') }}">
	@csrf
	<table border=1 cellspacing=0 cellpadding=5 align=center>
		<tr>
			<td>Name</td>
			<td><input name=name value="{{ isset($user) ? $user->name : '' }}"></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>
				<label><input type=radio name=gender value=male {{ (isset($user) and $user->gender == 'M') ? 'checked=checked' : '' }}> Male</label>
				<label><input type=radio name=gender value=female {{ (isset($user) and $user->gender == 'F') ? 'checked=checked' : '' }}> Female</label>
			</td>
		</tr>
		<tr>
			<td>Email</td>
			<td><input type=email name=email value="{{ isset($user) ? $user->email : '' }}"></td>
		</tr>
		<tr>
			<td>Password</td>
			<td><input type=password name=password></td>
		</tr>
	</table>
	<p style="text-align: center">
		<button>{{ isset($user) ? 'Update' : 'Create' }} User</button>
	</p>
</form>
