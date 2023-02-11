"use strict";

const $profileName = document.querySelector(".profile--name");
const $profileAge = document.querySelector(".profile--age");
const $profileCity = document.querySelector(".profile--city");
const $profileDescription = document.querySelector(".profile--description");
const $profileSettings = document.querySelector(".profile--settings");

const user = getCookie("user");

if (user !== "undefined" && user !== undefined) {
	const { first_name, last_name, patronymic, age, city, description, id } = JSON.parse(user);
	const currentId = window.location.href.split("/").pop();

	if (id.toString() !== currentId.toString()) $profileSettings.remove();

	$profileName.textContent = `${last_name} ${first_name} ${patronymic}`;
	$profileAge.textContent = `Возраст: ${age}`;
	$profileCity.textContent = `Город: ${city}`;
	$profileDescription.textContent = description;
} else {
	$profileSettings.remove();
}