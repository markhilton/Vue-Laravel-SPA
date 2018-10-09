<!DOCTYPE html>
<html lang="en">
<head>
	<title>@yield('title', config('app.name'))</title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

	<link href="{{ asset(mix('css/app.css')) }}" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
</head>
<body>
	<div id="app" v-cloak>
		<app />
	</div>

	<script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>
