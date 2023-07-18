import Alert from "../../classes/Alert";
import Loader from "../../classes/Loader";
import Post from "../../classes/Post";

const alert = new Alert();
const loader = new Loader();
const post = new Post();

const editForm = document.querySelector(".create__form");

editForm.addEventListener("submit", (event) => {
	event.preventDefault();

	loader.show();

	const idPost = window.location.href.split("/").at(-1);

	const fd = new FormData(editForm);
	const updatePromise = post.update(fd, idPost);

	updatePromise
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