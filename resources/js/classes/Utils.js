import jwt_decode from "jwt-decode";
import Cookie from "js-cookie";

class Utils {
	getCsrf() {
		return document.querySelector("meta[name=csrf-token]").content;
	}

	getHost() {
		return "http://127.0.0.1:8000";
	}

	generatePassword() {
		const length = 20;
		const wishlist = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz~!@-#$";

		return Array.from(crypto.getRandomValues(new Uint32Array(length)))
			.map((x) => wishlist[x % wishlist.length])
			.join("");
	}

	getCurrentUserId() {
		return jwt_decode(Cookie.get("token")).id;
	}
}

export default Utils;