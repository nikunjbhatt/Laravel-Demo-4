@php
	$person = [ 'first_name' => 'nikunj', 'last_name' => 'bhatt' ];
	session(['status' => 'success']);
	$emptyArray = [];
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>
    </head>
    <body>
		<h1>{{ config('app.name') }}</h1>
		<h1>{{ env('APP_NAME') }}</h1>
		<p>app env {{ config('app.env') }}</p>
		<p>name: {{ $name }}</p>
		<p>surname: {{ $surname }}</p>
		<p>encoded html: {{ '<b>bold text &</b>' }}</p>
		<p>html: {!! '<b>bold text &</b>' !!}</p>
		<p>other framework: @{{ name }}</p>
		
		<script>
			var person = {{ Js::from($person) }}
			//alert(person.first_name);
		</script>
		
		@verbatim
			{{ name }} {{ surname }}
		@endverbatim

		@if($person['first_name'] == 'nimesh')
			<p>first name is nimesh</p>
		@else
			<p>first name is not nimesh</p>
		@endif
		
		@if($person['last_name'] == 'joshi')
			<p>last name is joshi</p>
		@elseif($person['last_name'] == 'bhatt')
			<p>last name is bhatt</p>
		@endif

		@unless($name == 'bhatt')
			<p>name is not bhatt</p>
		@endunless

		@isset($a)
			<p>$a is set</p>
		@else
			<p>$a is not set</p>
		@endisset

		@empty($dob)
			<p>DoB is empty</p>
		@endempty

		@auth
			<p>user is authenticated</p>
		@else
			<p>user is not authenticated</p>
		@endauth

		@guest
			<p>user is not authenticated</p>
		@endguest

		@auth('web')
			<p>user type (guard) 'web' is authenticated</p>
		@else
			<p>user type (guard) 'web' is not authenticated</p>
		@endauth

		@production
			<p>this is production environment</p>
		@endproduction

		@env('local')
			<p>this is local environment</p>
		@endenv

		@env(['staging', 'production'])
			<p>this is staging or production environment</p>
		@else
			<p>this is not staging or production environment</p>
		@endenv

		@section('s1')
			<p>this is s1 section</p>
		@endsection

		@yield('s1')
		@yield('s1')

		@hasSection('s2')
			@yield('s2')
		@else
			<p>section 's2' is not defined</p>
		@endif

		@sectionMissing('s2')
			<p>section 's2' is missing</p>
		@endif

		@session('status')
			<p>status: {{ session('status') }}</p>
		@endsession

		@switch($name)
			@case('nikunj')
				<p>name is nikunj</p>
				@break
			@default
				<p>name is not nikunj</p>
		@endswitch

		@for($a = 1; $a < 6; $a++)
			<p>a = {{ $a }}</p>
		@endfor

		@foreach ($person as $key => $value)
			<p>person[{{ $key }}] = {{ $value }}
		@endforeach

		@while($a < 11)
			<p>a = {{ $a++ }}</p>
		@endwhile

		@forelse($emptyArray as $value)
			<p>{{ $value }}</p>
		@empty
			<p>array is empty</p>
		@endforelse
    </body>
</html>
