<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
th[onclick] { cursor: pointer; }
th[onclick] span { position: relative; top: -2px; }
</style>

<table border=1 cellpadding=5 cellspacing=0 style="margin:auto" class="table table-bordered">
	<tr>
		<th onclick="orderBy(this)" data-field="id">Id <span>@if($orderBy['field'] == 'id') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
		<th onclick="orderBy(this)" data-field="post_id">Post Id <span>@if($orderBy['field'] == 'post_id') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
		<th onclick="orderBy(this)" data-field="user_id">User Id <span>@if($orderBy['field'] == 'user_id') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
		<th>Comment</th>
		<th onclick="orderBy(this)" data-field="created_at">Created At <span>@if($orderBy['field'] == 'created_at') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
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

<script>
function orderBy(th) {
	let field = th.getAttribute('data-field');
	let order = th.children[0].innerText == '↓' ? 'desc' : 'asc';
	let queryString = location.search.substr(1).split('&');

	for(let a = 0; a < queryString.length; a++) {
		if(queryString[a].substr(0, 7) == 'orderBy')
			queryString[a] = 'orderBy=' + field + ',' + order;
	}

	location.href = location.protocol + '//' + location.host + location.pathname + '?' + queryString.join('&')
}
</script>