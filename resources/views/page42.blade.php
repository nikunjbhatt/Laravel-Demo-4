@if($errors->any())
	@foreach($errors->all() as $error)
		<p>{{ $error }}</p>
	@endforeach
@endif
<form method=post>
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