"use strict";

const $settingsBack = document.querySelector(".settings--back");
const $settingsForm = document.querySelector(".settings__form");
const $csrfToken = document.querySelector("meta[name='csrf-token']");
const $settingsPasswordText = document.querySelector(".settings__password--text span");
const $btnPassword = document.querySelector(".btn--password");
const $btnExit = document.querySelector(".btn--exit");
const $modal = document.querySelector(".modal");
const $modalContent = document.querySelector(".modal__content");
const $btnOpenModal = document.querySelector(".btn--open-modal");
const $btnStay = document.querySelector(".btn--stay");
const $modalClose = document.querySelector(".modal--close");
const $alertTitle = $alert.querySelector(".alert--title");
const $alertText = $alert.querySelector(".alert--text");

const user = getCookie("user");
const { id } = JSON.parse(user);

(async function () {
	$loader.style.display = "inline-block";
	checkHidePassword();

	const currentId = window.location.href.split("/").pop();

	// если пользователь не является владельцем
	if (currentId.toString() !== id.toString()) {
		$loader.style.display = "none";
		history.back();
		return;
	}
	$loader.style.display = "none";
})();

function checkHidePassword() {
	const pswd = getCookie("passwordUsr");
	const passwordUsr = JSON.parse(pswd);

	$settingsPasswordText.textContent = passwordUsr;

	if ($settingsPasswordText.dataset.hide === "true") {
		const hidePassword = $settingsPasswordText.textContent.split("").map(_ => "•").join("");
		$settingsPasswordText.textContent = hidePassword;
		$btnPassword.textContent = "Показать";
	} else if ($settingsPasswordText.dataset.hide === "false") {

		$settingsPasswordText.textContent = passwordUsr;
		$btnPassword.textContent = "Скрыть";
	}
}

// показать\скрыть пароль
$btnPassword.addEventListener("click", () => {
	if ($settingsPasswordText.dataset.hide === "true") {
		$settingsPasswordText.dataset.hide = "false";
	} else if ($settingsPasswordText.dataset.hide === "false") {
		$settingsPasswordText.dataset.hide = "true";
	}
	checkHidePassword();
});

// выход из профиля
$btnOpenModal.addEventListener("click", () => {
	$modal.classList.remove("hidden");
	document.body.style.overflow = "hidden";
});

$btnExit.addEventListener("click", () => {
	$loader.style.display = "inline-block";
	setCookie("user", undefined, 1);
	setCookie("passwordUsr", undefined, 1);
	$loader.style.display = "none";
	window.location.replace("http://127.0.0.1:8000/auth/login");
});

$modalContent.addEventListener("click", (event) => {
	event.stopPropagation();
});

$btnStay.addEventListener("click", () => {
	$modal.classList.add("hidden");
	document.body.style.overflow = "visible";
});

$modal.addEventListener("click", (event) => {
	if (!event.target.classList.contains("modal__content")) {
		$modal.classList.add("hidden");
		document.body.style.overflow = "visible";
	}
});

$modalClose.addEventListener("click", () => {
	$modal.classList.add("hidden");
	document.body.style.overflow = "visible";
});

// кнопка назад
$settingsBack.addEventListener("click", () => history.back());

// работа с формой
$settingsForm.addEventListener("submit", (event) => {
	event.preventDefault();
	$loader.style.display = "inline-block";

	const payload = getDataFromForm(event);
	const url = `http://127.0.0.1:8000/user/change/${id}?current_user_id=${id}`;

	// отправка данных
	fetch(url, {
		method: "PUT",
		headers: {
			"Content-Type": "application/json",
			"X-CSRF-TOKEN": $csrfToken.getAttribute("content"),
			"X-Requested-With": "XMLHttpRequest"
		},
		body: JSON.stringify(payload)
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, message, user: userFromServ, passport } = data;

			$loader.style.display = "none";

			$alert.style.display = "block";
			$alertText.textContent = message;

			if (success) {
				$alertTitle.textContent = "Успех";
				$alert.className = "alert success";

				setCookie("user", JSON.stringify({ ...userFromServ, ...passport }), 1);
			} else {
				$alertTitle.textContent = "Ошибка";
				$alert.className = "alert error";
			}
		})
		.catch((error) => {
			$loader.style.display = "none";

			$alert.className = "alert error";
			$alertText.textContent = error.message;

			console.error(error);
		});
});