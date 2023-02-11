"use strict";

const $authFormLogin = document.querySelector(".auth__form.login");
const $csrfToken = document.querySelector("meta[name='csrf-token']");
const $alertTitle = $alert.querySelector(".alert--title");
const $alertText = $alert.querySelector(".alert--text");

(function () {
	const urlSearchParams = new URLSearchParams(window.location.search);
	const params = Object.fromEntries(urlSearchParams.entries());

	if (!params.message) return;

	$alert.className = "alert success";
	$alertTitle.textContent = "Успех";
	$alert.style.display = "block";
	$alertText.textContent = params.message;
})();

// работа с формой
$authFormLogin.addEventListener("submit", async (event) => {
	event.preventDefault();
	$loader.style.display = "inline-block";

	const payload = getDataFromForm(event);

	// отправка данных
	fetch($authFormLogin.getAttribute("data-action"), {
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
			const { success, message, user, passwordUsr, token } = data;

			$loader.style.display = "none";

			$alert.style.display = "block";
			$alertText.textContent = message;

			if (success) {
				$alertTitle.textContent = "Успех";
				$alert.className = "alert success";

				setCookie("user", JSON.stringify(user), 1);
				setCookie("passwordUsr", JSON.stringify(passwordUsr));
				setCookie("token", token);

				window.location.replace(`http://127.0.0.1:8000/profile/${user.id}`);
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