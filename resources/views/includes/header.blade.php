<header class="header container">
	<a href="/" class="header__logo">Социальная Сеть</a>
	<div class="header__search-wrapper">
		<input
			type="text"
			class="header__search-input input__primary"
			placeholder="Поиск..."
		/>
	</div>
	@if (!$notMyProfile)
		<nav class="header__nav">
			<ul class="header__list">
				<li title="Создать пост">
					<a href="/create">
						<x-create-post-icon />
					</a>
				</li>
				<li title="Страница пользователя">
					<a href="/user/{{ $user['id'] }}">
						<x-user-icon />
					</a>
				</li>
			</ul>
		</nav>
	@else
		<nav class="header__nav not-auth">
			<a href="/auth/login">Войти</a>
		</nav>
	@endif
</header>