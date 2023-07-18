const createInputCover = document.querySelector(".input__cover");
const createCoverView = document.querySelector(".cover__view");

createInputCover.addEventListener("change", (event) => {
	const file = event.target.files[0];
	const reader = new FileReader();

	reader.readAsDataURL(file);

	reader.onload = () => {
		createCoverView.src = reader.result;
	}

	reader.onerror = () => {
		alert.show(false, reader.error.message);
		console.error(reader.error);
	}
});