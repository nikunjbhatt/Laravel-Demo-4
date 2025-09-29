<table cellspacing=0 cellpadding=6 border=1 style="margin:auto">
	<tr>
		<th>Id</th>
		<td>{{ $user->id }}</td>
	</tr>
	<tr>
		<th>Name</th>
		<td>{{ $user->name }}</td>
	</tr>
	<tr>
		<th>Email Address</th>
		<td>{{ $user->email }}</td>
	</tr>
	<tr>
		<th>Created At</th>
		<td>{{ $user->created_at }}</td>
	</tr>
</table>
