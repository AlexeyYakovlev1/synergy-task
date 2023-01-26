(async function () {
	const user = getCookie("user");

	let flag = false;

	if ((user === "undefined" || !user) && !window.location.href.includes("auth")) {
		window.location.replace("http://127.0.0.1:8000/auth/login");
		return;
	} else if ((user !== "undefined" && user) && window.location.href.includes("auth")) {
		flag = true;
	} else if ((user === "undefined" || !user) && window.location.href.includes("auth")) {
		return;
	}

	const { id } = JSON.parse(user);

	fetch(`http://127.0.0.1:8000/auth/check/${id}`, {
		method: "GET"
	})
		.then((response) => response.json())
		.then((data) => {
			const { success, user: userFromServ } = data;

			if (success) {
				setCookie("user", JSON.stringify(userFromServ));
				if (flag) {
					window.location.replace(`http://127.0.0.1:8000/profile/${id}`);
				}
			} else {
				if (!window.location.href.includes("auth")) {
					window.location.replace("http://127.0.0.1:8000/auth/login");
				}
			}
		})
		.catch((error) => console.error(error));
})();