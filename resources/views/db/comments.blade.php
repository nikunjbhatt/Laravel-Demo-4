<table border=1 cellpadding=5 cellspacing=0 style="margin:auto">
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
<p style="text-align: center;">
	<a href="{{ route('db.comments', ['offset' => ($offset <= 9 ? 0 : $offset - 10)]) }}">Previous</a>
	&nbsp; &nbsp; &nbsp; &nbsp;
	<a href="{{ route('db.comments', ['offset' => $offset + 10]) }}">Next</a>
</p>
