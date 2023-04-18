const API_URL = "http://127.0.0.1:3000";
let token;
let role;

if (!document.cookie || document.cookie == "") {
	window.location.href = "/login.html";
} else {
	fetch(`${API_URL}/users/verify`, {
		method: "GET",
		credentials: "include",
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.error) {
				document.cookie = "token=";
				window.location.href = "/login.html";
			}
			token = getCookie("token");
			role = data.role;
			checkAuthorization();
		});
}

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

function checkAuthorization() {
	if (role === "admin" && window.location.pathname.includes("/admin")) {
		// user has admin role and is trying to access admin page
		return;
	} else if (
		role === "student" &&
		window.location.pathname.includes("/admin")
	) {
		// user has student role and is trying to access admin page
		window.location.href = "/index.html";
	}
	// user has valid role for the page they are trying to access
}

function logout() {
	document.cookie = "token=";
	window.location.href = "/login.html";
}
