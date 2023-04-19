const API_URL = "https://cu-workstudy-backend.cyclic.app";
// const API_URL = "http://127.0.0.1:3000";

let token;
let role;

function getCookie(name) {
	const cookies = document.cookie.split(";");
	for (let i = 0; i < cookies.length; i++) {
		const cookie = cookies[i].trim();
		if (cookie.startsWith(name + "=")) {
			return decodeURIComponent(cookie.substring(name.length + 1));
		}
	}
	return null;
}

if (!document.cookie || document.cookie == "") {
	window.location.href = "/portal/login.html";
} else {
	fetch(`${API_URL}/users/verify`, {
		method: "GET",
		credentials: "include",
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.error) {
				document.cookie = "token=";
				window.location.href = "/portal/login.html";
			}
			token = getCookie("token");
			role = data.role;
			checkAuthorization();
		});
}

function checkAuthorization() {
	if (role === "admin" && window.location.pathname.includes("/admin")) {
		// user has admin role and is trying to access admin page
		return;
	} else if (
		role === "student" &&
		window.location.pathname.includes("/admin")
	) {
		// user has student role and is trying to access admin page
		window.location.href = "/portal/";
	}
	// user has valid role for the page they are trying to access
}

function logout() {
	document.cookie = "token=";
	window.location.href = "/portal/login.html";
}
