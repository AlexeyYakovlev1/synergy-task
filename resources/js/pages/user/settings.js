import Cookie from "js-cookie";
import User from "../../classes/User";
import Alert from "../../classes/Alert";
import Loader from "../../classes/Loader";
import Utils from "../../classes/Utils";

const user = new User();
const alert = new Alert();
const loader = new Loader();
const utils = new Utils();

const settingsBack = document.querySelector(".settings__back");
const btnExit = document.querySelector(".btn__exit");
const settingsForm = document.querySelector(".settings__form");

// Back
settingsBack.addEventListener("click", () => {
	const userId = utils.getCurrentUserId();

	window.location.href = `http://127.0.0.1:8000/user/${userId}`;
});

// Exit
btnExit.addEventListener("click", () => {
	Cookie.remove("token");
	window.location.href = "http://127.0.0.1:8000/auth/login";
});

// Update data
settingsForm.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.show();

	const fd = new FormData(settingsForm);
	const promiseUpdate = user.update(fd);

	promiseUpdate
		.then((data) => {
			const { success, message, errors } = data;

			if (message) alert.show(success, message);
			if (success === false || (errors && Object.entries(errors).length)) {
				loader.close();
				return
			}

			loader.close();
		})
		.catch((error) => {
			alert.show(false, error.message);

			loader.close();

			console.error(error.message, error);
		});
});