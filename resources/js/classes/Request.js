import Utils from "./Utils";

const utils = new Utils();

class Request {
	constructor() {
		this.csrf = utils.getCsrf();
		this.host = utils.getHost();
	}

	post(url, params) {
		const allHeaders = Object.assign({
			"Accept": "application/json",
			"X-Requested-With": "XMLHttpRequest",
			"X-CSRF-TOKEN": this.csrf
		}, params.headers);

		return fetch(`${this.host}${url}`, {
			method: "POST",
			headers: allHeaders,
			body: params.data
		})
			.then((response) => response.json());
	}

	get(url, params) {
		const allHeaders = Object.assign({
			"Accept": "application/json",
			"X-Requested-With": "XMLHttpRequest",
			"X-CSRF-TOKEN": this.csrf
		}, params.headers);

		return fetch(`${this.host}${url}`, {
			method: "GET",
			headers: allHeaders
		})
			.then((response) => response.json());
	}
}

export default Request;