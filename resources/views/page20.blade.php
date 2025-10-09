<form method=post enctype="multipart/form-data">
	@csrf
	<p>Name: <input name=name value="{{ old('name') === null ? 'Null' : old('name') }}"></p>
	<p>
		Gender:
		<label><input type=radio name=gender value=Male {{ old('gender') == 'Male' ? 'checked' : '' }}> Male</label>
		&nbsp; &nbsp;
		<label><input type=radio name=gender value=Female {{ old('gender') == 'Female' ? 'checked' : '' }}> Female</label></p>
	<p>Date of Birth: <input type=date name=dob value="{{ old('dob') }}"></p>
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
	<p>Upload File 1: <input type=file name=file1></p>
	<p>Upload File 2: <input type=file name=file2></p>
	<p><button>Submit</button></p>
</form>
