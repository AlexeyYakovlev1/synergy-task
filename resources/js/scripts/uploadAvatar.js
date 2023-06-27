import Alert from "../classes/Alert";

const alert = new Alert();

const settingsInputAvatar = document.querySelector(".settings__input-avatar");
const settingsAvatarView = document.querySelector(".settings__avatar-view");

settingsInputAvatar.addEventListener("change", (event) => {
	const reader = new FileReader();
	const file = event.target.files[0];

	reader.readAsDataURL(file);

	reader.onload = () => {
		settingsAvatarView.src = reader.result;
	}

	reader.onerror = () => {
		alert.show(false, reader.error.message);
		console.error(reader.error);
	}
});