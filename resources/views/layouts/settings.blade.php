<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8" />
		
		@include("../includes/csrf")

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		@vite(["resources/sass/settings.sass", "resources/sass/components/header.sass"])
		
		<title>@yield("title")</title>
	</head>
	<body>
		<x-loader />
		<x-alert />

		@include("../includes/header")

		<div class="modal hidden">
			<div class="modal__content">
				<header class="modal__header">
					<h1 class="modal__title">Вы уверены?</h1>
					<span class="modal__close">&#10006;</span>
				</header>
				<p class="modal__text">Чтобы войти вам потребуется текущий пароль</p>
				<footer class="modal__footer">
					<button class="btn__primary btn__exit">Выйти</button>
					<button class="btn__primary btn__stay">Остаться</button>
				</footer>
			</div>
		</div>
		<article class="settings container">
			@yield("content")
		</article>

		@vite(["resources/js/scripts/closeAlert"])
		@yield("scripts")
	</body>
</html>