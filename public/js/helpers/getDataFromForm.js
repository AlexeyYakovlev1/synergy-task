function getDataFromForm(event) {
	if (event.target.nodeName !== "FORM") {
		throw new Error("Only <form></form> element!");
	}

	const payload = {};

	Array.from(event.target.children)
		.filter((child) => {
			return child.nodeName === "INPUT" && child.type !== "submit";
		})
		.forEach(({ name, value }) => payload[name] = value);

	return payload;
}