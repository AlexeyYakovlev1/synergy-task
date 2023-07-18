<li class="post" data-id="${post.id}">
							<header class="post__header">
								<div class="post__header-owner">
									<img
										class="post__header-owner-avatar"
										src="http://127.0.0.1:8000/storage/avatars/${owner.avatar}"
										alt="${owner.last_name} ${owner.first_name} ${owner.patronymic}"
									/>
									<div class="post__header-owner-data">
										<span class="post__header-owner-name">
											<a href="/user/${userId}">${owner.last_name} ${owner.first_name} ${owner.patronymic}</a>
										</span>
										<span class="post__header-owner-date">
											${createdAt}
										</span>
									</div>
								</div>
								<div class="post__header-settings" data-id="${post.id}">
									<?xml version="1.0" encoding="UTF-8"?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g id="surface1">
									<path style="fill-rule:nonzero;fill:#fff;fill-opacity:1;stroke-width:2.739244;stroke-linecap:butt;stroke-linejoin:round;stroke:#fff;stroke-opacity:1;stroke-miterlimit:4;" d="M 981.73715 -70.625 L 994.98715 -70.625 L 994.98715 -57.375 L 981.73715 -57.375 Z M 981.73715 -70.625 " transform="matrix(0,0.1875,-0.1875,0,0,-173.317903)"/>
									<path style="fill-rule:nonzero;fill:#fff;fill-opacity:1;stroke-width:2.739244;stroke-linecap:butt;stroke-linejoin:round;stroke:#fff;stroke-opacity:1;stroke-miterlimit:4;" d="M 949.73715 -70.625 L 962.98715 -70.625 L 962.98715 -57.375 L 949.73715 -57.375 Z M 949.73715 -70.625 " transform="matrix(0,0.1875,-0.1875,0,0,-173.317903)"/>
									<path style="fill-rule:nonzero;fill:#fff;fill-opacity:1;stroke-width:2.739244;stroke-linecap:butt;stroke-linejoin:round;stroke:#fff;stroke-opacity:1;stroke-miterlimit:4;" d="M 1013.73715 -70.625 L 1026.98715 -70.625 L 1026.98715 -57.375 L 1013.73715 -57.375 Z M 1013.73715 -70.625 " transform="matrix(0,0.1875,-0.1875,0,0,-173.317903)"/>
									</g>
									</svg>
									<div class="post__header-settings-place hidden" data-id="${post.id}">
										<ul class="post__header-settings-place-list">
											<li data-do="change">
												<span>Изменить</span>
											</li>
										</ul>
									</div>
								</div>
							</header>
							<div class="post__content">
								<p class="post__content-text">${post.content}</p>
								<ul class="post__content-images">
									<li>
										<img
											src="http://127.0.0.1:8000/storage/covers/${post.cover}"
											alt="image"
										>
									</li>
								</ul>
							</div>
							<footer class="post__footer">
								<button class="post__reaction like">
									<?xml version="1.0" ?><svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2zM4 10h2v9H4v-9zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7v1.819z"/></svg>
								</button>
								<button class="post__reaction dislike press">
									<?xml version="1.0" ?><svg height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M20 8h-5.612l1.123-3.367c.202-.608.1-1.282-.275-1.802S14.253 2 13.612 2H12c-.297 0-.578.132-.769.36L6.531 8H4c-1.103 0-2 .897-2 2v9c0 1.103.897 2 2 2h13.307a2.01 2.01 0 0 0 1.873-1.298l2.757-7.351A1 1 0 0 0 22 12v-2c0-1.103-.897-2-2-2zM4 10h2v9H4v-9zm16 1.819L17.307 19H8V9.362L12.468 4h1.146l-1.562 4.683A.998.998 0 0 0 13 10h7v1.819z"/></svg>
								</button>
								<button class="post__reaction comments">
									<?xml version="1.0" encoding="UTF-8"?>
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g id="surface1">
									<path style=" stroke:none;fill-rule:nonzero;fill:#fff;fill-opacity:1;" d="M 0 1.199219 L 0 14.398438 L 2.398438 14.398438 L 2.398438 18.601562 C 2.398438 18.929688 2.667969 19.199219 3 19.199219 C 3.160156 19.199219 3.3125 19.136719 3.425781 19.023438 C 4.960938 17.484375 8.046875 14.398438 8.046875 14.398438 L 20.398438 14.398438 L 20.398438 1.199219 Z M 1.199219 2.398438 L 19.199219 2.398438 L 19.199219 13.199219 L 7.550781 13.199219 L 3.601562 17.152344 L 3.601562 13.199219 L 1.199219 13.199219 Z M 3.601562 4.800781 L 3.601562 6 L 13.199219 6 L 13.199219 4.800781 Z M 21.601562 4.800781 L 21.601562 6 L 22.800781 6 L 22.800781 16.800781 L 20.398438 16.800781 L 20.398438 20.75 L 16.449219 16.800781 L 7.199219 16.800781 L 6 18 L 15.953125 18 C 15.953125 18 19.039062 21.085938 20.574219 22.625 C 20.6875 22.738281 20.839844 22.800781 21 22.800781 C 21.332031 22.800781 21.601562 22.53125 21.601562 22.199219 L 21.601562 18 L 24 18 L 24 4.800781 Z M 3.601562 7.199219 L 3.601562 8.398438 L 8.398438 8.398438 L 8.398438 7.199219 Z M 3.601562 9.601562 L 3.601562 10.800781 L 15.601562 10.800781 L 15.601562 9.601562 Z M 3.601562 9.601562 "/>
									</g>
									</svg>
								</button>
							</footer>
						</li>