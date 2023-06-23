class Modal {
	constructor(modalElement) {
		this.modal = modalElement;
	}

	show() { this.modal.classList.remove("hidden"); }

	close() { this.modal.classList.add("hidden"); }
}

export default Modal;