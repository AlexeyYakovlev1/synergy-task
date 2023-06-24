import Modal from "../../classes/Modal";
import Cookie from "js-cookie";
import User from "../../classes/User";
import Alert from "../../classes/Alert";
import Loader from "../../classes/Loader";
import Utils from "../../classes/Utils";

const modal = new Modal(document.querySelector(".modal"));
const user = new User();
const alert = new Alert();
const loader = new Loader();
const utils = new Utils();

const settingsBack = document.querySelector(".settings__back");
const btnOpenModal = document.querySelector(".btn__open-modal");
const btnStay = document.querySelector(".btn__stay");
const modalClose = document.querySelector(".modal__close");
const btnExit = document.querySelector(".btn__exit");
const settingsForm = document.querySelector(".settings__form");

// Back
settingsBack.addEventListener("click", () => {
	const userId = utils.getCurrentUserId();

	window.location.href = `http://127.0.0.1:8000/user/${userId}`;
});

// Modal
btnOpenModal.addEventListener("click", () => modal.show());
btnStay.addEventListener("click", () => modal.close());
modalClose.addEventListener("click", () => modal.close());

// Exit
btnExit.addEventListener("click", () => {
	Cookie.remove("token");
	window.location.href = "http://127.0.0.1:8000/auth/login";
});

// Update data
settingsForm.addEventListener("submit", (event) => {
	event.preventDefault();

	const fd = new FormData(settingsForm);
	const promiseUpdate = user.update(fd);

	promiseUpdate
		.then((response) => response.json())
		.then((data) => {
			const { success, message, errors } = data;

			loader.close();

			if (message) alert.show(success, message);
			if (success === false || (errors && Object.entries(errors).length)) return;
		})
		.catch((error) => {
			alert.show(false, error.message);

			loader.close();

			console.error(error.message, error);
		});
});