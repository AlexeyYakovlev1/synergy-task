<div class="modal hidden">
	<div class="modal__content">
		<header class="modal__header">
			<h1 class="modal__title">{{ $title }}</h1>
			<span class="modal__close">&#10006;</span>
		</header>
		<p class="modal__text">{{ $description }}</p>
		<footer class="modal__footer">
			<button class="btn__primary btn__exit">{{ $btnGo }}</button>
			<button class="btn__primary btn__stay">{{ $btnStop }}</button>
		</footer>
	</div>
</div>