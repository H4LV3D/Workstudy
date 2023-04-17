const API_URL = "http://127.0.0.1:3000";

let login = (e) => {
	console.log(e);
	e.preventDefault();
	console.log("Login button clicked!");
	// Prevent the form from submitting
	// e.preventDefault();

	// Get the username and password from the form
	let username = document.getElementById("username").value;
	let password = document.getElementById("password").value;

	// Create a new object to send to the server
	let user = {
		username: username,
		password: password,
	};

	// Send the user object to the server
	fetch(`${API_URL}/user/login`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(user),
	})
		.then((response) => response.json())
		.then((data) => {
			console.log(data);
			// Save the token to cookies
			document.cookie = `token=${data.token}`;
			// Redirect to the home page
			window.location.href = "/";
		})
		.catch((error) => {
			console.log(error);
		});
};
