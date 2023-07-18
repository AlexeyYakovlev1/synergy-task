<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8" />
		
		@include("../includes/csrf")

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<meta http-equiv="X-UA-Compatible" content="ie=edge">
		
		@vite([
			"resources/sass/settings.sass",
			"resources/sass/components/header.sass",
			"resources/sass/components/modal.sass"
		])
		
		<title>@yield("title")</title>
	</head>
	<body>
		<x-loader />
		<x-alert />
		<x-modal
			title="Вы уверены?"
			description="Чтобы войти вам потребуется текущий пароль"
			btnGo="Выйти"
			btnStop="Остаться"
		/>

		@include("../includes/header")

		<article class="settings container">
			@yield("content")
		</article>

		@vite([
			"resources/js/scripts/closeAlert",
			"resources/js/scripts/closeModal"
		])
		@yield("scripts")
	</body>
</html>