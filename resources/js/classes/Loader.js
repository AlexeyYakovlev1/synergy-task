class Loader {
	constructor() {
		this.loaderElement = document.querySelector(".loader");
	}

	show() { this.loaderElement.style.display = "block"; }

	close() { this.loaderElement.style.display = "none"; }
}

export default Loader;