const API_URL = "https://cu-workstudy-backend.cyclic.app";
// const API_URL = "http://127.0.0.1:3000";

const preloader = document.getElementById("preloader");

const login = async (e) => {
	e.preventDefault();

	// Get the username and password from the form
	const username = document.getElementById("username").value;
	const password = document.getElementById("password").value;

	// Create a new object to send to the server
	const user = {
		username,
		password,
	};

	preloader.style.display = "flex";
	try {
		const response = await fetch(`${API_URL}/users/login`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify(user),
		});
		const data = await response.json();

		if (data.login.token) {
			preloader.style.display = "none";
			// Save the token to local storage
			localStorage.setItem("token", data.login.token);

			// Redirect to the appropriate page based on user role
			if (data.login.role === "student") {
				window.location.href = "/portal/";
			} else {
				window.location.href = "/portal/admin-dashboard.html";
			}
		} else {
			preloader.style.display = "none";
			alert(data.login.error);
		}
	} catch (error) {
		console.log(error);
	}
};
