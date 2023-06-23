class Alert {
	constructor() {
		this.alertElement = document.querySelector(".alert");
	}

	show(success, message) {
		this.alertElement.style.display = "block";
		this.alertElement.className = `alert ${success ? "success" : "error"}`

		// Удаляем (and n errors)
		const correctMessage = message.replace(" " + message.substr(message.indexOf("(")), "");

		document.querySelector(".alert__text").textContent = correctMessage;
		document.querySelector(".alert__title").textContent = success ? "Успех" : "Ошибка";
	}

	close() {
		this.alertElement.style.display = "none";
		this.alertElement.className = "alert";

		document.querySelector(".alert__title").textContent = "";
		document.querySelector(".alert__text").textContent = "";
	}
}

export default Alert;