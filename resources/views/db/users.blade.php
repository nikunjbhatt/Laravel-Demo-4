@if(session('update'))
	<p style="color:green;text-align:center">{{ session('update') }}</p>
@endif
@if(session('delete'))
	<p style="color:green;text-align:center">{{ session('delete') }}</p>
@endif
<style>
th[onclick] { cursor: pointer }
</style>
<form id="form" method="post" data-action="{{ route('db.user-delete', ['userId' => 0]) }}" data-list-route="{{ route('db.users-list') }}">
	@csrf
	@method('delete')
	<table cellpadding=4 cellspacing=0 border=1 style="margin:auto">
		<thead>
			<tr>
				<th onclick="orderBy(this)" data-field="id">Id <span>@if($orderBy['field'] == 'id') @if($orderBy['order'] == 'desc') ∧ @else ∨ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="name">Name <span>@if($orderBy['field'] == 'name') @if($orderBy['order'] == 'desc') ∧ @else ∨ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="email">Email Address <span>@if($orderBy['field'] == 'email') @if($orderBy['order'] == 'desc') ∧ @else ∨ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="created_at">Created At <span>@if($orderBy['field'] == 'created_at') @if($orderBy['order'] == 'desc') ∧ @else ∨ @endif @endif</span></th>
				<th onclick="orderBy(this)" data-field="updated_at">Updated At <span>@if($orderBy['field'] == 'updated_at') @if($orderBy['order'] == 'desc') ∧ @else ∨ @endif @endif</span></th>
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
	let order = th.children[0].innerText == '∨' ? 'desc' : 'asc';
	location.href = document.getElementById('form').getAttribute('data-list-route') + '/' + field + ',' + order;
}
</script>