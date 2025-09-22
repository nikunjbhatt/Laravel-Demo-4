@php
	$person = [ 'first_name' => 'nikunj', 'last_name' => 'bhatt' ];
	session(['status' => 'success']);
	$emptyArray = [];
	$days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
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
			@if($a % 2 == 0)
				@continue
			@endif
			<p>a = {{ $a }}</p>
		@endfor

		@foreach ($person as $key => $value)
			<p>person[{{ $key }}] = {{ $value }}
		@endforeach

		@while($a < 11)
			<p>a = {{ $a++ }}</p>
			@if($a > 8)
				@break
			@endif
		@endwhile

		@forelse($emptyArray as $value)
			<p>{{ $value }}</p>
		@empty
			<p>array is empty</p>
		@endforelse

<style>
.bold { font-weight: bold; }
</style>
		@foreach ($days as $day)
			@if($loop->first)
				<p>starting the loop</p>
			@endif
			@if($loop->last)
				<p>printing the last day:</p>
			@endif

			<p @class(['bold' => $loop->odd]) @style(['color:red' => $loop->even])>index: {{ $loop->index }}, iteration: {{ $loop->iteration }}, day: {{ $day }}</p>
		@endforeach

@php
	$gender = rand(0, 2);
@endphp
		<p>
			<input type="radio" @checked($gender == 1)> Male , 
			<input type="radio" @checked($gender == 2)> Female
		</p>

		<p>
			<select>
				<option @selected($gender == 0) @disabled($gender != 0)></option>
				<option @selected($gender == 1) @disabled($gender != 1)>Male</option>
				<option @selected($gender == 2) @disabled($gender != 2)>Female</option>
			</select>
		</p>

		<p><input @readonly($gender == 0)></p>
		<p>
			<form>
				<input name="name" @required($gender != 0)>
				<button>Submit</button>
			</form>
		</p>

		@include('includes.sub-view', ['status' => 'success'])
		@includeIf('includes.non-exist-view')
		@includeWhen($gender != 0, 'includes.gender')
		@each('includes.day', $days, 'day')
		{{-- this is a blade comment --}}
		<!-- this is html comment -->
		<x-alert some-text="this is some text" color="green" :$person />
		<x-sub-folder.compo :person="$person" ::attrib="some data" />
    </body>
</html>
