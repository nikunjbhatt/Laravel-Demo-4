<table border=1 align=center cellspacing=0 cellpadding=5>
	<thead>
		<tr>
			<th>Id</th>
			<th>Title</th>
			<th>Status</th>
			<th>Created At</th>
			<th>Comments</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($posts as $post)
			<tr>
				<td>{{ $post->id }}</td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->status }}</td>
				<td>{{ $post->created_at }}</td>
				<td>{{ $post->comments_count }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
