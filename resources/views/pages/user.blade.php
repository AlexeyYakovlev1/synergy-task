@extends("layouts.profile")
@section("title")
	{{ $title }}
@stop
@section("content")
	<header class="profile__header">
		<div class="profile__header-left">
			<img
				class="profile__avatar"
				src="http://127.0.0.1:8000/storage/avatars/{{ $userData['avatar'] }}"
				alt="фото {{ $userData['first_name'] }}"
			/>
			<div class="profile__header-info">
				<h2 class="profile__name">
					{{ $userData["last_name"] }}
					{{ $userData["first_name"] }}
					{{ $userData["patronymic"] }}
				</h2>
				<span class="profile__age small">
					Возраст: {{ $userData["age"] }}
				</span>
				<span class="profile__city small">
					Город: {{ $userData["city"] }}
				</span>
				<p class="profile__description">
					{{ $userData["description"] }}
				</p>
			</div>
		</div>
		<div class="profile__header-right">
			@if ($notMyProfile === false)
				<button class="btn__primary profile__settings">
					<a href="/settings">Настройки</a>
				</button>
			@else
				<button class="btn__primary profile__follow">
					Подписаться
				</button>
			@endif
			
		</div>
	</header>
	<div class="profile__content">
		<p>Контент пользователя...</p>
	</div>
@stop