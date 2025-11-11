@if(session('update'))
	<p style="color:green;text-align:center">{{ session('update') }}</p>
@endif
@if(session('delete'))
	<p style="color:green;text-align:center">{{ session('delete') }}</p>
@endif
<style>
th[onclick] { cursor: pointer; }
th[onclick] span { position: relative; top: -2px; }
</style>
<form id="form" method="post" data-action="{{ route('db.user-delete', ['userId' => 0]) }}" data-list-route="{{ route('db.users-list') }}">
	@csrf
	@method('delete')
	<table cellpadding=4 cellspacing=0 border=1 style="margin:auto">
		<thead>
			<tr>
				<th onclick="orderBy(this)" data-field="u.id">Id <span>@if($orderBy['field'] == 'u.id') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="u.name">Name <span>@if($orderBy['field'] == 'u.name') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="u.email">Email Address <span>@if($orderBy['field'] == 'u.email') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="u.created_at">Created At <span>@if($orderBy['field'] == 'u.created_at') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="u.updated_at">Updated At <span>@if($orderBy['field'] == 'u.updated_at') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="posts_count">Posts <span>@if($orderBy['field'] == 'posts_count') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</th>
				<th onclick="orderBy(this)" data-field="comments_count">Comments <span>@if($orderBy['field'] == 'comments_count') @if($orderBy['order'] == 'desc') ↑ @else ↓ @endif @endif</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@foreach ($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ date('d-m-Y g:i a', strtotime($user->created_at)) }}</td>
					<td>{{ $user->updated_at ? date('d-m-Y g:i a', strtotime($user->updated_at)) : '' }}</td>
					<td>{{ $user->posts_count }}</td>
					<td>{{ $user->comments_count }}</td>
					<td><a href="{{ route('db.user-edit', ['userId' => $user->id]) }}">Edit</a></td>
					<td><button type="button" onclick="deleteUser({{ $user->id }})">Delete</button></td>
				</tr>
			@endforeach
		</tbody>
	</table>
</form>
<script>
function deleteUser(id) {
	if(confirm('Delete the user record?')) {
		let form = document.getElementById('form');
		form.action = form.getAttribute('data-action') + id;
		form.submit();
	}
}

function orderBy(th) {
	let field = th.getAttribute('data-field');
	let order = th.children[0].innerText == '↓' ? 'desc' : 'asc';
	location.href = document.getElementById('form').getAttribute('data-list-route') + '/' + field + ',' + order;
}
</script>