<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="stylesheet" href="/css/auth.css"/>
		<title>{{ $title }}</title>
	</head>
	<body>
		<span class="loader"></span>
		<section class="auth">
			<header class="auth__header">
				<h2 class="auth--title">Регистрация</h2>
			</header>
			<form
				data-action="{{ route('users.registration') }}"
				enctype="multipart/form-data"
				class="auth__form"
			>
				@csrf
				<input
					class="input--primary"
					type="text"
					placeholder="Введите имя"
					name="first_name"
				/>
				<input
					class="input--primary"
					type="text"
					placeholder="Введите фамилию"
					name="last_name"
				/>
				<input
					class="input--primary"
					type="text"
					placeholder="Введите отчество"
					name="patronymic"
				/>
				<input
					class="input--primary"
					type="text"
					placeholder="Введите электронную почту"
					name="email"
				/>
				<input
					class="input--primary"
					type="text"
					placeholder="Введите серию паспорта"
					name="passport_series"
				/>
				<input
					class="input--primary"
					type="text"
					placeholder="Введите номер паспорта"
					name="passport_id"
				/>
				<input class="btn--submit" type="submit" value="Зарегистрироваться" />
			</form>
			<div class="auth__generate-password">
				<button class="btn--primary btn--generate-password">Сгенерировать новый пароль</button>
				<pre class="auth--password-result">aksjd113_+</pre>
			</div>
			<footer class="auth__footer">
				<p class="auth__footer-text">
					Уже есть аккаунт? <a class="link--primary" href="/auth/login">Войти</a>
				</p>
			</footer>
		</section>
	</body>
	
	<script src="/js/helpers/getDataFromForm.js"></script>
	<script src="/js/helpers/setCookie.js"></script>
	<script src="/js/helpers/getCookie.js"></script>
	<script src="/js/authCheck.js"></script>
	<script src="/js/registration.js"></script>
</html>