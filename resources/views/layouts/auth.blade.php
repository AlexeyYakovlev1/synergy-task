<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8" />
		
		@include("../includes/csrf")
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		@vite(["resources/sass/auth.sass"])
		
		<title>@yield("title")</title>
	</head>
	<body>
		<x-loader />
		<x-alert />

		<main class="auth">
			@yield("content")
		</main>

		@vite(["resources/js/scripts/closeAlert"])
		@yield("scripts")
	</body>
</html>