@extends('layout')

@section('content')
<p>This is page 1.</p>
<p>posted data: {{ request('data') }}</p>
<form method=post>
	@csrf
	<p>Data: <input name="data"></p>
	<p><button>Submit</button></p>
</form>
@endsection
