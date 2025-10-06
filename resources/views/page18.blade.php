@php
	use App\Gender;
@endphp
<p>Name: {{ request()->input('name') }}</p>
<p>Default Name: {{ $name2 }}</p>
<p>Request URL: {{ request()->url() }}</p>
<p>Request Full URL: {{ request()->fullUrl() }}</p>
<p>Request Full URL with additional parameters: {{ request()->fullUrlWithQuery(['param2' => 'value2']) }}</p>
<p>Request Full URL without Query String: {{ request()->fullUrlWithoutQuery(['param1']) }}</p>
<hr>
<p>Host: {{ request()->host() }}</p>
<p>HTTP Host: {{ request()->httpHost() }}</p>
<p>Schema and HTTP Host: {{ request()->schemeAndHttpHost() }}</p>
<p>Request Method: {{ request()->method() }}</p>
<p>Referer: {{ request()->header('Referer') }}</p>
<p>User-Agent: {{ request()->header('User-Agent') }}</p>
<p>Custom-Header: {{ request()->header('Custom-Header', 'No value') }}</p>
<p>Bearer Token: {{ request()->bearerToken(); }}</p>
<p>IP Address: {{ request()->ip(); }}</p>
<hr>
<pre>
@php
	print_r(request()->all());
	print_r(request()->collect());

	echo "Hobbies: ";
	request()->collect('hobby')->each(function(string $hobby) {
		echo $hobby . ", ";
	});
	echo '<br>';

	print_r(request()->input());
	print_r(request()->query());
	echo 'Hobbies: '; print_r(request()->enums('hobby', App\Hobby::class));
	print_r(request()->only(['name', 'dob']));
	
	request()->whenHas('City', function($input) {
		echo "City ($input) is present in the request.<br>";
	}, function() {
    	echo "City is not present in the request.<br>";
	});

	if(request()->filled('name'))
		echo 'Name is filled.<br>';
	else
		echo 'Name is not filled.<br>';
	
	//if(request()->missing('city'))
	//	request()->merge(['city' => 'Ahmedabad']);
	request()->mergeIfMissing(['city' => 'Ahmedabad']);
@endphp
</pre>
<p>Country: {{ request()->input('country', 'India') }}</p>
<p>Value of param1: {{ request()->input('param1') }}</p>
<p>Value of param2: {{ request()->input('param2', '[No param2 parameter exist]') }}</p>
<p>DoB: {{ request()->date('dob')->addHour() }}</p>
<p>Gender: {{ request()->enum('gender', Gender::class, Gender::Male) }}</p>
<p>Name: {{ request()->name }}</p>
<p>Has Name and Age?: {{ request()->has('name', 'dob') }}</p>
<p>Has Name or City?: {{ request()->hasAny('name', 'city') }}</p>
<p>Has City or State?: {{ request()->hasAny('city', 'state') }}</p>
