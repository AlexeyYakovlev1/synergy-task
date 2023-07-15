import jwt_decode from "jwt-decode";
import Cookie from "js-cookie";
import Utils from "./Utils";
import Request from "../classes/Request";

const utils = new Utils();
const request = new Request();

class User {
	constructor() {
		this.csrf = utils.getCsrf();
		this.host = utils.getHost();
		this.userId = jwt_decode(Cookie.get("token")).id;
	}

	update(data) {
		const params = { data };

		return request.post(`/user/update/${this.userId}`, params);
	}
}

export default User;