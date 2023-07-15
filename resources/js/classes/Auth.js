import Utils from "./Utils";
import Request from "./Request";

const utils = new Utils();
const request = new Request();

class Auth {
	constructor() {
		this.csrf = utils.getCsrf();
		this.host = utils.getHost();
	}

	login(data) {
		const params = { data };

		return request.post("/auth/login", params);
	}

	registration(data) {
		const params = { data };

		return request.post("/auth/registration", params);
	}
}

export default Auth;