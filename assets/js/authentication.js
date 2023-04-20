const API_URL = "https://cu-workstudy-backend.cyclic.app";
// const API_URL = "http://127.0.0.1:3000";

const token = localStorage.getItem("token");

fetch(`${API_URL}/users/verify`, {
	method: "GET",
	headers: {
		Authorization: `token ${token}`,
	},
})
	.then((response) => response.json())
	.then((data) => {
		if (data.error) {
			window.location.href = "/portal/login.html";
		}
		role = data.role;
		checkAuthorization(role);
	});

function checkAuthorization(role) {
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
	// Remove the token from local storage
	localStorage.removeItem("token");

	// Redirect to the login page
	window.location.href = "/portal/login.html";
}
