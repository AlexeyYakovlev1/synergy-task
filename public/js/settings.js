const $settingsBack = document.querySelector(".settings--back");
const $settingsForm = document.querySelector(".settings__form");
const $csrfToken = document.querySelector("meta[name='csrf-token']");
const $settingsPasswordText = document.querySelector(".settings__password--text span");
const $btnPassword = document.querySelector(".btn--password");
const $btnExit = document.querySelector(".btn--exit");

const user = getCookie("user");
const { id } = JSON.parse(user);

(async function () {
	checkHidePassword();

	const currentId = window.location.href.split("/").pop();

	// если пользователь не является владельцем
	if (currentId.toString() !== id.toString()) {
		history.back();
		return;
	}
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
$btnExit.addEventListener("click", () => {
	setCookie("user", undefined, 1);
	setCookie("passwordUsr", undefined, 1);
	window.location.replace("http://127.0.0.1:8000/auth/login");
});

// кнопка назад
$settingsBack.addEventListener("click", () => history.back());

// работа с формой
$settingsForm.addEventListener("submit", (event) => {
	event.preventDefault();

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
			const { success, message, user: userFromServ } = data;

			alert(message);

			if (success) {
				setCookie("user", JSON.stringify(userFromServ), 1);
			}
		})
		.catch((error) => console.error(error));
});