<table border=1 cellpadding=5 cellspacing=0 style="margin:auto">
	<tr>
		<th>Table</th>
		<th>Id</th>
		<th>Name</th>
		<th>Extra</th>
		<th>Created At</th>
		<th>Updated At</th>
	</tr>
	@foreach ($usersProducts as $up)
		<tr>
			<td>{{ $up->table }}</td>
			<td>{{ $up->id }}</td>
			<td>{{ $up->name }}</td>
			<td>{{ $up->extra }}</td>
			<td>{{ $up->created_at }}</td>
			<td>{{ $up->updated_at }}</td>
		</tr>
	@endforeach
</table>
