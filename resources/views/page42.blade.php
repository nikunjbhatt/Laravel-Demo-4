<style>
p { margin-top: 0; margin-bottom: 20px; }
.is-invalid { border: 1px solid red; }
</style>
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
			<td>
				<input name=name class="@error('name') is-invalid @enderror" value="{{ old('name') }}">
				@error('name')
					<p>{{ $message }}</p>
				@enderror
			</td>
		</tr>
		<tr>
			<td>Email Address</td>
			<td>
				<input type=email name=email_address class="@error('email_address') is-invalid @enderror">
				@error('email_address')
					<p>{{ $message }}</p>
				@enderror
			</td>
		</tr>
		<tr>
			<td>Date of Birth</td>
			<td>
				<input type=date name=dob class="@error('dob') is-invalid @enderror">
				@error('dob')
					<p>{{ $message }}</p>
				@enderror
			</td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>
				<label><input type=radio name=gender value=Male> Male</label> &nbsp; 
				<label><input type=radio name=gender value=Female> Female</label>
			</td>
		</tr>
		<tr>
			<td>Occupation</td>
			<td>
				<input name=occupation class="@error('occupation') is-invalid @enderror">
				@error('occupation')
					<p>{{ $message }}</p>
				@enderror
			</td>
		</tr>
	</table>
	<button>Submit</button>
</form>