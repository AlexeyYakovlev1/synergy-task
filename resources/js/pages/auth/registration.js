import Auth from "../../classes/Auth";
import Utils from "../../classes/Utils";
import Loader from "../../classes/Loader";
import Alert from "../../classes/Alert";
import Cookie from "js-cookie";

const auth = new Auth();
const utils = new Utils();
const loader = new Loader();
const alert = new Alert();

const authFormRegistration = document.querySelector(".auth__form.registration");
const btnGeneratePassword = document.querySelector(".btn__generate-password");
const authPasswordResult = document.querySelector(".auth__password-result");

// Генерация пароля
document.addEventListener("DOMContentLoaded", () => authPasswordResult.textContent = utils.generatePassword());
btnGeneratePassword.addEventListener("click", () => authPasswordResult.textContent = utils.generatePassword());

// Обработка ответа
authFormRegistration.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.show();

	const fd = new FormData(authFormRegistration);
	fd.append("password", authPasswordResult.textContent);

	const promiseRegistration = auth.registration(fd);

	promiseRegistration
		.then((data) => {
			const { success, message, password, errors } = data;

			loader.close();

			if (message) alert.show(success, message);
			if (success === false || (errors && Object.entries(errors).length)) return;

			const loginMessage = `Ваш пароль для входа в аккаунт: ${password}. Сохраните его!`;

			alert.show(success, loginMessage);
			Cookie.set("login-message", loginMessage);

			window.location.href = "http://127.0.0.1:8000/auth/login";
		})
		.catch((error) => {
			alert.show(false, error.message);

			loader.close();

			console.error(error.message, error);
		});
});