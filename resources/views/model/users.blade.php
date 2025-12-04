<table border=1 align=center cellspacing=0 cellpadding=5>
	<thead>
		<tr>
			<th>Name</th>
			<th>Gender</th>
			<th>Email</th>
			<th>Created At</th>
			<th>Posts</th>
			<th>Comments</th>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $user)
			<tr>
				<td>{{ $user->name }}</td>
				<td>{{ $user->gender }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->created_at }}</td>
				<td><a href="{{ route('model.user-posts', ['userId' => $user->id]) }}">{{ $user->posts_count }}</td>
				<td>{{ $user->comments_count }}</td>
				<td><a href="{{ route('model.user-edit', ['userId' => $user->id]) }}">Edit</a></td>
			</tr>
		@endforeach
	</tbody>
</table>
