<h1 style="text-align:center">Reset Password</h1>

@if($errors->any())
	@foreach($errors->all() as $error)
		<p style="text-align: center; color:red">{{ $error }}</p>
	@endforeach
@endif

@if(session('status'))
	<p style="text-align: center; color:green">{{ session('status') }}</p>
@endif

<form method=post>
	@csrf
	<p style="text-align:center">Enter your email address<br><input type=email name=email></p>

	<p style="text-align:center">
		<button>Get Password Reset Link</button>
	</p>
</form>
