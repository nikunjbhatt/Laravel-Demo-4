<p>page 30, Key: {{ $key }}</p>
<form method=post action="{{ route('page31') }}">
	@csrf
	<p>Name: <input name=name value="{{ old('name') ? old('name') : session('name') }}"></p>
	<p><button>Submit</button></p>
</form>