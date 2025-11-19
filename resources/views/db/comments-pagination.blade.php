<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<table border=1 cellpadding=5 cellspacing=0 style="margin:auto" class="table table-bordered">
	<tr>
		<th>Id</th>
		<th>Post Id</th>
		<th>User Id</th>
		<th>Comment</th>
		<th>Created At</th>
	</tr>
	@foreach ($comments as $comment)
		<tr>
			<td>{{ $comment->id }}</td>
			<td>{{ $comment->post_id }}</td>
			<td>{{ $comment->user_id }}</td>
			<td>{{ $comment->comment }}</td>
			<td>{{ $comment->created_at }}</td>
		</tr>
	@endforeach
</table>

{{ $comments->links() }}
