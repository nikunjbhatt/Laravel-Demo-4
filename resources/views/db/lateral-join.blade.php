<p><a href="https://laravel.com/docs/12.x/queries#lateral-joins">Lateral Join</a></p>
<p>Check this for MySQL database (not MariaDB)</p>
<table border=1 cellpadding=5 cellspacing=0 style="margin:auto">
	<tr>
		<th>User's Name</th>
		<th>Post Id</th>
		<th>Post Title</th>
		<th>Post Created At</th>
	</tr>
	@foreach ($users as $user)
		<tr>
			<td>{{ $user->name }}</td>
			<td>{{ $user->post_id }}</td>
			<td>{{ $user->post_title }}</td>
			<td>{{ $user->post_created_at }}</td>
		</tr>
	@endforeach
</table>
