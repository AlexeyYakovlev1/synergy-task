<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		@vite(["resources/sass/404.sass"])
		<title>Страница не найдена</title>
	</head>
	<body>
		<span class="loader"></span>
		<div class="wrapper">
			<h1 class="title">404</h1>
			<h2 class="subtitle">Ууупс! Ничего не найдено</h2>
			<p class="text">
				Страница, которую вы ищете, могла быть удалена из-за
				изменения названия или временно недоступна.
				<a
					class="link__primary"
					href="http://127.0.0.1:8000/auth/login"
				>
					Перейти на страницу авторизации
				</a>
			</p>
		</div>
	</body>
</html>