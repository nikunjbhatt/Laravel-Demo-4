<form method=post action="{{ route('user2.store') }}">
	@csrf
	<p>Name: <input name=name></p>
	<p>Your Email Service Provider:
		<select name=email_provider>
			<option value=gmail>Gmail</option>
			<option value=yahoo>Yahoo</option>
			<option value=outlook>Outlook</option>
		</select>
	</p>
	<p><button>Submit</button></p>
</form>