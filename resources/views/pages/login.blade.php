@extends("layouts.auth")
@section("title")
	Вход
@stop
@section("content")
	<header class="auth__header">
		<h2 class="auth__title">Вход</h2>
	</header>
	<form class="auth__form login">
		@csrf
		<input
			class="input__primary"
			type="text"
			placeholder="Введите электронную почту"
			name="email"
		/>
		<input
			class="input__primary"
			type="password"
			placeholder="Введите пароль"
			name="password"
		/>
		<input class="btn__submit" type="submit" value="Войти" />
		<footer class="auth__footer">
			<p class="auth__footer-text">
				Нет аккаунта? <a class="link__primary" href="/auth/registration">
					Зарегистрироваться
				</a>
			</p>
		</footer>
	</form>
	
	@section("scripts")
		@vite(["resources/js/pages/auth/login"])
	@stop
@stop