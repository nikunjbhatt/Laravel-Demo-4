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
    </body>
</html>
