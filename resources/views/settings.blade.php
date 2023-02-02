<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="csrf-token" content="{{ csrf_token() }}" />
		<link rel="stylesheet" href="/css/settings.css"/>
		<title>{{ $title }}</title>
	</head>
	<body>
		<span class="loader"></span>
		<div class="modal hidden">
			<div class="modal__content">
				<header class="modal__header">
					<h1 class="modal--title">Вы уверены?</h1>
					<span class="modal--close">&#10006;</span>
				</header>
				<p class="modal--text">Сохраните пароль, чтобы не потерять его</p>
				<footer class="modal__footer">
					<button class="btn--primary btn--exit">Выйти</button>
					<button class="btn--primary btn--stay">Остаться</button>
				</footer>
			</div>
		</div>
		<article class="settings container">
			<header class="settings__header">
				<div class="settings__header--left">
					<button class="btn--primary settings--back">Назад</button>
					<h1 class="settings--title">Настройки аккаунта</h1>
				</div>
				<button class="btn--primary btn--open-modal">Выход из аккаунта</button>
			</header>
			<form
				class="settings__form"
				enctype="multipart/form-data"
			>
				@csrf
				<label for="first_name">
					Главная информация
				</label>
				<input
					id="first_name"
					type="text"
					class="input--primary"
					name="first_name"
					placeholder="Введите имя"
					value="{{ $user['first_name'] }}"
				/>
				<input
					type="text"
					class="input--primary"
					name="last_name"
					placeholder="Введите фамилию"
					value="{{ $user['last_name'] }}"
				/>
				<input
					type="text"
					class="input--primary"
					name="patronymic"
					placeholder="Введите отчество"
					value="{{ $user['patronymic'] }}"
				/>
				<input
					type="email"
					class="input--primary"
					name="email"
					placeholder="Введите почту"
					value="{{ $user['email'] }}"
				/>
				<input
					type="text"
					class="input--primary"
					name="passport_series"
					placeholder="Введите серию паспорта"
					value="{{ $passport['series'] }}"
				/>
				<input
					type="text"
					class="input--primary"
					name="passport_id"
					placeholder="Введите номер паспорта"
					value="{{ $passport['num'] }}"
				/>
				<label for="description">
					Анкета
				</label>
				<textarea
					id="description"
					class="input--primary"
					name="description"
					placeholder="Введите описание"
					value="{{ $user['description'] }}"
				>{{ $user['description'] }}</textarea>
				<input
					type="text"
					class="input--primary"
					name="city"
					placeholder="Введите название города"
					value="{{ $user['city'] }}"
				/>
				<input
					type="number"
					class="input--primary"
					name="age"
					placeholder="Введите возраст"
					value="{{ $user['age'] }}"
				/>
				<input class="btn--submit settings--submit" type="submit" value="Готово" />
			</form>
			<div class="settings__password">
				<p class="settings__password--text">
					Пароль: <span data-hide="true"></span>
					<button class="btn--primary btn--password">Показать</button>
				</p>
			</div>
		</article>
	</body>

	<script src="/js/helpers/getDataFromForm.js"></script>
	<script src="/js/helpers/getCookie.js"></script>
	<script src="/js/helpers/setCookie.js"></script>
	<script src="/js/authCheck.js"></script>
	<script src="/js/settings.js"></script>
</html>
