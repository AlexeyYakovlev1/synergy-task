import Post from "../../classes/Post";
import Alert from "../../classes/Alert";
import Loader from "../../classes/Loader";

const post = new Post();
const alert = new Alert();
const loader = new Loader();

const createForm = document.querySelector(".create__form");

createForm.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.show();

	const fd = new FormData(createForm);

	const promiseCreate = post.create(fd);

	promiseCreate
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