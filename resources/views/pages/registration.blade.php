@extends("layouts.auth")
@section("title")
	Регистрация
@stop
@section("content")
	<header class="auth__header">
		<h2 class="auth__title">Регистрация</h2>
	</header>
	<form class="auth__form registration">
		@csrf
		<input
			class="input__primary"
			type="text"
			placeholder="Введите имя"
			name="first_name"
		/>
		<input
			class="input__primary"
			type="text"
			placeholder="Введите фамилию"
			name="last_name"
		/>
		<input
			class="input__primary"
			type="text"
			placeholder="Введите отчество"
			name="patronymic"
		/>
		<input
			class="input__primary"
			type="text"
			placeholder="Введите электронную почту"
			name="email"
		/>
		<input
			class="input__primary"
			type="text"
			placeholder="Введите серию паспорта"
			name="passport_series"
		/>
		<input
			class="input__primary"
			type="text"
			placeholder="Введите номер паспорта"
			name="passport_id"
		/>
		<input class="btn__submit" type="submit" value="Зарегистрироваться" />
	</form>
	<div class="auth__generate-password">
		<button class="btn__primary btn__generate-password">Сгенерировать новый пароль</button>
		<pre class="auth__password-result">aksjd113_+</pre>
	</div>
	<footer class="auth__footer">
		<p class="auth__footer-text">
			Уже есть аккаунт? <a class="link__primary" href="/auth/login">Войти</a>
		</p>
	</footer>
@stop
@section("scripts")
	@vite(["resources/js/pages/auth/registration"])
@stop