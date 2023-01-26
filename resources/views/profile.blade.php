<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="/css/profile.css"/>
		<title>{{ $title }}</title>
	</head>
	<body>
		<article class="profile container">
			<header class="profile__header">
				<div class="profile__header-left">
					<img
						class="profile--avatar"
						src="{{ $user['avatar'] }}"
						alt="фото {{ $user['first_name'] }}"
					/>
					<div class="profile__header-info">
						<h2 class="profile--name">
							{{ $user["last_name"] }}
							{{ $user["first_name"] }}
							{{ $user["patronymic"] }}
						</h2>
						<span class="profile--age small">
							Возраст: {{ $user["age"] }}
						</span>
						<span class="profile--city small">
							Город: {{ $user["city"] }}
						</span>
						<p class="profile--description">
							{{ $user["description"] }}
						</p>
					</div>
				</div>
				<div class="profile__header-right">
					<button class="btn--primary">
						<a href="/settings/{{ $user['id'] }}">Настройки</a>
					</button>
				</div>
			</header>
			<div class="profile__content">
				<p>Контент пользователя...</p>
			</div>
		</article>
	</body>

	<script src="/js/helpers/setCookie.js"></script>
	<script src="/js/helpers/getCookie.js"></script>
	<script src="/js/authCheck.js"></script>
	<script src="/js/profile.js"></script>
</html>