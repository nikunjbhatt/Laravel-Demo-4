<form method=post action="{{ route('page18-abc') }}?param1=value1">
	@csrf
	@method('Patch')
	<p>Name: <input name=name></p>
	<p><input type=submit></p>
</form>
