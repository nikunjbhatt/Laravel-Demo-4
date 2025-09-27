<!DOCTYPE html>
<html>
	<title>Custom title</title>
	<style>
		a { text-decoration: none; }
	</style>
</html>
<body>
	<p style="text-align:center">This is header</p>
	<p style="text-align:center">
		<a href="{{ route('page1') }}" @style(['text-decoration:underline' => Route::currentRouteName() == 'page1'])>Page 1</a> &bull;
		<a href="{{ route('page2') }}" @style(['text-decoration:underline' => request()->route()->getName() == 'page2'])>Page 2</a>
	</p>
	<p>Current route name: {{ Route::currentRouteName() }} / {{ request()->route()->getName() }}</p>
