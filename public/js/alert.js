"use strict";

const $alert = document.querySelector(".alert");

$alert.addEventListener("click", (event) => {
	if (event.target.classList.contains("alert--close")) {
		$alert.style.display = "none";
	}
});