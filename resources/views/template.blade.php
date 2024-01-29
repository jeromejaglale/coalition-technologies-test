<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('title', 'Untitled')@yield('base_title', ' | Tasks')</title>

		<link href="/css/main.css?v=1" rel="stylesheet" />
	</head>

	<body>
		@yield('content')
	</body>
</html>