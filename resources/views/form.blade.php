<form method=post>
	<fieldset>
		<legend>/form</legend>
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<p>Name: <input name="name"></p>
		<p><button>Submit</button></p>
	</fieldset>
</form>

<form method=post action="{{ route('form2') }}">
	<fieldset>
		<legend>/form2</legend>
		<p>Name: <input name="name"></p>
		<p><button>Submit</button></p>
	</fieldset>
	@csrf
</form>

<form method=post action="{{ route('form3') }}">
	@method('delete')
	<fieldset>
		<legend>/form3</legend>
		<p><button>Submit</button></p>
	</fieldset>
	@csrf
</form>

<form method=post action="{{ route('form4') }}">
	<fieldset>
		<legend>/form4</legend>
		<p><button>Submit</button></p>
	</fieldset>
	@csrf
</form>

<form method=post action="{{ route('form5') }}">
	<fieldset>
		<legend>/form5</legend>
		<p><button>Submit</button></p>
	</fieldset>
	@csrf
</form>

