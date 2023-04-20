const API_URL = "https://cu-workstudy-backend.cyclic.app";
// const API_URL = "http://127.0.0.1:3000";
const preloader = document.getElementById("preloader");

let login = (e) => {
	e.preventDefault();

	// Get the username and password from the form
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	// Create a new object to send to the server
	let user = {
		username: username,
		password: password,
	};

	preloader.style.display = "flex";
	// Send the user object to the server
	fetch(`${API_URL}/users/login`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(user),
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.login.token) {
				preloader.style.display = "none";
				// Save the token to cookies
				localStorage.setItem("token", data.login.token);

				// Redirect to the home page / dashboard
				if (data.login.role == "student") {
					window.location.href = "/portal/";
				} else {
					window.location.href = "/portal/admin-dashboard.html";
				}
			} else {
				alert(data.login.error);
			}
		})
		.catch((error) => {
			console.log(error);
		});
};
