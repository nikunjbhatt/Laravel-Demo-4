@extends('layout')

@section('content')
<p>This is page 2.</p>
request method: {{ request()->method() }}
<form method=post>
	@csrf
	<p>
		<select name="_method">
			<option>get</option>
			<option>post</option>
			<option>put</option>
			<option>patch</option>
			<option>delete</option>
			<option>options</option>
		</select>
	</p>
	<p><button>Submit</button></p>
</form>

@endsection
