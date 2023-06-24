import Auth from "../../classes/Auth";
import Cookie from "js-cookie";
import Alert from "../../classes/Alert";
import Loader from "../../classes/Loader";

const auth = new Auth();
const alert = new Alert();
const loader = new Loader();

document.addEventListener("DOMContentLoaded", () => {
	if (!Cookie.get("login-message")) return;

	alert.show(true, Cookie.get("login-message"));
});

const authFormLogin = document.querySelector(".auth__form.login");

authFormLogin.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.show();

	const fd = new FormData(authFormLogin);
	const promiseLogin = auth.login(fd);

	promiseLogin
		.then((response) => response.json())
		.then((data) => {
			const { success, message, token, user_id, errors } = data;

			loader.close();

			if (message) alert.show(success, message);
			if (success === false || (errors && Object.entries(errors).length)) return;

			Cookie.set("token", token, { expires: 1 });
			Cookie.remove("login-message");

			window.location.href = `http://127.0.0.1:8000/user/${user_id}`;
		})
		.catch((error) => {
			alert.show(false, error.message);

			loader.close();

			console.error(error.message, error);
		});
});