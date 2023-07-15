import Request from "./Request";

const request = new Request();

class Post {
	create(data) {
		const params = { data };

		return request.post("/post/create", params);
	}

	update(data, id) {
		const params = { data };

		return request.post(`/post/update/${id}`, params);
	}

	getByUserId(id) {
		return request.get(`/post/all/${id}`, {});
	}
}

export default Post;