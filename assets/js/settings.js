const API_URL = "http://127.0.0.1:3000";

window.onload = () => {
	// Send the user object to the server
	fetch(`${API_URL}/user/`, {
		method: "GET",
		headers: {
			"Content-Type": "application/json",
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			console.log(data);
			buildPage(data);
		})
		.catch((error) => {
			console.log(error);
		});
};

let buildPage = (data) => {
	let settingsUsername = document.getElementById("settings-username");
	settingsUsername.innerText = data.username;

	let username = document.getElementById("sidebar-name");
	username.innerText = data.fullname.split(" ")[0];

	let sbLevel = document.getElementById("sidebar-level");
	sbLevel.innerText = data.level || "No level set";
};
