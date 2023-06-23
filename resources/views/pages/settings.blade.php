@extends("layouts.settings")
@section("title")
	Настройки пользователя
@stop
@section("content")
	<header class="settings__header">
		<div class="settings__header__left">
			<button class="btn__primary settings__back">Назад</button>
			<h1 class="settings__title">Настройки аккаунта</h1>
		</div>
		<button class="btn__primary btn__open-modal">Выход из аккаунта</button>
	</header>
	<form class="settings__form">
		@csrf
		<label for="first_name">
			Главная информация
		</label>
		<input
			id="first_name"
			type="text"
			class="input__primary"
			name="first_name"
			placeholder="Введите имя"
			value="{{ $user['first_name'] }}"
		/>
		<input
			type="text"
			class="input__primary"
			name="last_name"
			placeholder="Введите фамилию"
			value="{{ $user['last_name'] }}"
		/>
		<input
			type="text"
			class="input__primary"
			name="patronymic"
			placeholder="Введите отчество"
			value="{{ $user['patronymic'] }}"
		/>
		<input
			type="email"
			class="input__primary"
			name="email"
			placeholder="Введите почту"
			value="{{ $user['email'] }}"
		/>
		<input
			type="text"
			class="input__primary"
			name="passport_series"
			placeholder="Введите серию паспорта"
			value="{{ $passport['series'] }}"
		/>
		<input
			type="text"
			class="input__primary"
			name="passport_id"
			placeholder="Введите номер паспорта"
			value="{{ $passport['num'] }}"
		/>
		<label for="description">
			Анкета
		</label>
		<textarea
			id="description"
			class="input__primary"
			name="description"
			placeholder="Введите описание"
			value="{{ $user['description'] }}"
		>{{ $user['description'] }}</textarea>
		<input
			type="text"
			class="input__primary"
			name="city"
			placeholder="Введите название города"
			value="{{ $user['city'] }}"
		/>
		<input
			type="number"
			class="input__primary"
			name="age"
			placeholder="Введите возраст"
			value="{{ $user['age'] }}"
		/>
		<input class="btn__submit settings__submit" type="submit" value="Готово" />
	</form>
	
	@section("scripts")
		@vite(["resources/js/pages/user/settings"])
	@stop
@stop