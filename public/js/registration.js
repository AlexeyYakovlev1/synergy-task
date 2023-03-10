"use strict";

const $btnSubmit = document.querySelector(".btn--submit");
const $btnGeneratePassword = document.querySelector(".btn--generate-password");
const $authPasswordResult = document.querySelector(".auth--password-result");
const $authForm = document.querySelector(".auth__form");
const $csrfToken = document.querySelector("meta[name='csrf-token']");
const $alertTitle = $alert.querySelector(".alert--title");
const $alertText = $alert.querySelector(".alert--text");

// генерация пароля для пользователя
const generatePassword = (
	length = 20,
	wishlist = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$"
) => {
	return Array.from(crypto.getRandomValues(new Uint32Array(length)))
		.map((x) => wishlist[x % wishlist.length])
		.join('');
};

$authPasswordResult.textContent = generatePassword();

$btnGeneratePassword.addEventListener("click", () => {
	$authPasswordResult.textContent = generatePassword();
});

// работа с формой
$authForm.addEventListener("submit", (event) => {
	event.preventDefault();
	$loader.style.display = "inline-block";

	const payload = getDataFromForm(event);
	payload.password = $authPasswordResult.textContent;

	// отправка данных
	fetch($authForm.getAttribute("data-action"), {
		method: "POST",
		headers: {
			"X-CSRF-TOKEN": $csrfToken.getAttribute("content"),
			"Content-Type": "application/json",
			"X-Requested-With": "XMLHttpRequest"
		},
		body: JSON.stringify(payload)
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, message } = data;

			$loader.style.display = "none";

			$alert.style.display = "block";
			$alertText.textContent = message;

			if (success) {
				$alertTitle.textContent = "Успех";
				$alert.className = "alert success";

				window.location.replace(`http://127.0.0.1:8000/auth/login?message=${message}`);
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