<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="stylesheet" href="/css/auth.css"/>
		<title>{{ $title }}</title>
	</head>
	<body>
		<div class="alert"></div>
		<section class="auth">
			<header class="auth__header">
				<h2 class="auth--title">Вход</h2>
			</header>
			<form
				data-action="{{ route('users.login') }}"
				enctype="multipart/form-data"
				class="auth__form login"
			>
				@csrf	
				<input
					class="input--primary"
					type="text"
					placeholder="Введите электронную почту"
					name="email"
				/>
				<input
					class="input--primary"
					type="password"
					placeholder="Введите пароль"
					name="password"
				/>
				<input class="btn--submit" type="submit" value="Войти" />
				<footer class="auth__footer">
					<p class="auth__footer-text">
						Нет аккаунта? <a class="link--primary" href="/auth/registration">
							Зарегистрироваться
						</a>
					</p>
				</footer>
			</form>
		</section>
	</body>

	<script src="/js/helpers/getCookie.js"></script>
	<script src="/js/helpers/setCookie.js"></script>
	<script src="/js/helpers/getDataFromForm.js"></script>
	<script src="/js/authCheck.js"></script>
	<script src="/js/login.js"></script>
</html>