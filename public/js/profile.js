const $profileName = document.querySelector(".profile--name");
const $profileAge = document.querySelector(".profile--age");
const $profileCity = document.querySelector(".profile--city");
const $profileDescription = document.querySelector(".profile--description");

const user = getCookie("user");
const { first_name, last_name, patronymic, age, city, description } = JSON.parse(user);

$profileName.textContent = `${last_name} ${first_name} ${patronymic}`;
$profileAge.textContent = `Возраст: ${age}`;
$profileCity.textContent = `Город: ${city}`;
$profileDescription.textContent = description;