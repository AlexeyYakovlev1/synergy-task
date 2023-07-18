import Modal from "../classes/Modal";

const modal = new Modal(document.querySelector(".modal"));

function close(btnDelete, stay, close) {
	btnDelete.addEventListener("click", () => modal.show());
	stay.addEventListener("click", () => modal.close());
	close.addEventListener("click", () => modal.close());
}

export default close;