import Alert from "../classes/Alert";

const alertClose = document.querySelector(".alert__close");

const alert = new Alert();

if (alertClose) alertClose.addEventListener("click", () => alert.close());