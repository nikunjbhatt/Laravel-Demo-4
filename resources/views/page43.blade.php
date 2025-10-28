<form method=post action="/page43" onsubmit="submitForm(event)">
	@csrf
	<table>
		<tr>
			<td>Name</td>
			<td><input name=name></td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td><input type=email name=email_address></td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td><input type=date name=dob></td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>
				<label><input type=radio name=gender value=Male> Male</label> &nbsp; 
				<label><input type=radio name=gender value=Female> Female</label>
			</td>
		</tr>
	</table>
	<button>Submit</button>
</form>

<script>
function submitForm(event) {
	event.preventDefault();
	let form = event.target;

	fetch(form.action, {
		method: 'POST',
		headers: { 'Accept': 'application/json' },
		body: new FormData(form)
	})
	.then(response => {
		if(!response.ok) {
			return response.json().then(error => {
				throw error;		
			});
		}

		return response.json();
	})
	.then(response => {
		console.log(response);
		alert('Data submitted successfully.');
	})
	.catch(error => {
		//console.log(error);
		for(err in error.errors)
			alert(error.errors[err]);
	})
}
</script>