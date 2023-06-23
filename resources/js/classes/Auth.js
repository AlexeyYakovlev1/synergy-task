import Utils from "./Utils";
import axios from "axios";

const utils = new Utils();

class Auth {
	constructor() {
		this.csrf = utils.getCsrf();
		this.host = utils.getHost();
	}

	login(data) {
		const url = `${this.host}/auth/login`;

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

	registration(data) {
		const url = `${this.host}/auth/registration`;

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

export default Auth;