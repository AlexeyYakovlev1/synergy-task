"use strict";

const $authFormLogin = document.querySelector(".auth__form.login");
const $csrfToken = document.querySelector("meta[name='csrf-token']");

// работа с формой
$authFormLogin.addEventListener("submit", async (event) => {
	event.preventDefault();

	const payload = getDataFromForm(event);

	// отправка данных
	fetch($authFormLogin.getAttribute("data-action"), {
		method: "POST",
		headers: {
			"X-CSRF-TOKEN": $csrfToken.getAttribute("content"),
			"Content-Type": "application/json"
		},
		body: JSON.stringify(payload)
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, message, user } = data;

			alert(message);

			if (success) {
				setCookie("user", JSON.stringify(user), 1);
				window.location.replace(`http://127.0.0.1:8000/profile/${user.id}`);
			}
		})
		.catch((error) => console.error(error));
});