import jwt_decode from "jwt-decode";
import Cookie from "js-cookie";
import Utils from "./Utils";

const utils = new Utils();

class User {
	constructor() {
		this.csrf = utils.getCsrf();
		this.host = utils.getHost();
		this.userId = jwt_decode(Cookie.get("token")).id;
	}

	update(data) {
		const url = `${this.host}/user/update/${this.userId}`;

		return fetch(url, {
			method: "POST",
			headers: {
				"Accept": "application/json",
				"X-Requested-With": "XMLHttpRequest",
				"X-CSRF-TOKEN": this.csrf
			},
			body: data
		});
	}
}

export default User;