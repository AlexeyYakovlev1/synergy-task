<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	
	@include("../includes/csrf")

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	@vite(["resources/sass/post.sass", "resources/sass/components/header.sass"])
	
	<title>{{ $title }}</title>
</head>
<body>
	<x-loader />
	<x-alert />

	@include("../../includes/header")
	
	<main class="create container">
		<h2 class="create__title">Добавить новую запись</h2>
		<form class="create__form" autocomplete="off" enctype="multipart/form-data">
			@csrf
			<label for="content">
				Основной контент
				<textarea class="input__primary" name="content" id="content"></textarea>
			</label>
			<label for="cover">
				Обложка
				<input
					name="cover"
					class="create__input-cover"
					type="file"
					id="cover"
					accept="image/*"
				/>
			</label>
			<img
				class="create__cover-view"
				src=""
				alt="обложка поста"
			/>
			<input class="btn__submit create__submit" type="submit" value="Готово" />
		</form>
	</main>

	@vite([
		"resources/js/scripts/closeAlert", "resources/js/pages/post/create",
		"resources/js/scripts/uploadCover"
	])
</body>
</html>