<form method=post action="{{ route('page18-abc') }}?param1=value1">
	@csrf
	@method('Patch')
	<p>Name: <input name=name></p>
	<p>
		Gender:
		<label><input type=radio name=gender value=Male> Male</label>
		&nbsp; &nbsp;
		<label><input type=radio name=gender value=Female> Female</label></p>
	<p>Date of Birth: <input type=date name=dob></p>
	<p>
		Hobbies:
		<label><input type=checkbox name="hobby[]" value=Reading> Reading</label>
		&nbsp; &nbsp;
		<label><input type=checkbox name="hobby[]" value=Dancing> Dancing</label>
		&nbsp; &nbsp;
		<label><input type=checkbox name="hobby[]" value=Singing> Singing</label>
		&nbsp; &nbsp;
		<label><input type=checkbox name="hobby[]" value=Music> Music</label>
		&nbsp; &nbsp;
		<label><input type=checkbox name="hobby[]" value=Movies> Movies</label>
	</p>
	<p><button>Submit</button></p>
</form>
<hr>
<form method=post action="{{ route('page19-abcd') }}" onsubmit="submitForm(event)">
	@csrf
	<p><button>Submit</button></p>
</form>

<script>
function submitForm(event) {
	event.preventDefault();

	var formData = {
		user: {
			name: 'Nikunj Bhatt',
			email: 'nikunj@example.com'
		},
		products: [
			{ name: 'Laptop', price: 55000 },
			{ name: 'Mobile', price: 20000 },
			{ name: 'Tablet', price: 28000 }
		],
	};

	fetch(event.target.action, {
		method: 'post',
		body: JSON.stringify(formData),
		headers: {
			'X-CSRF-TOKEN': event.target._token.value,
			'Content-Type': 'application/json'
		}
	});
}
</script>