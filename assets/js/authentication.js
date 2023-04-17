const API_URL = "http://127.0.0.1:3000";
let token;

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
			returnCookie();
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

let returnCookie = () => {
	token = getCookie("token");
};
