@if(session('update'))
	<p style="color:green;text-align:center">{{ session('update') }}</p>
@endif
<table cellpadding=4 cellspacing=0 border=1 style="margin:auto">
	<thead>
		<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Email Address</th>
			<th>Created At</th>
			<th>Updated At</th>
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
			</tr>
		@endforeach
	</tbody>
</table>