window.onload = () => {
	// Send the user object to the server
	fetch(`${API_URL}/users/me`, {
		method: "GET",
		headers: {
			"Content-Type": "application/json",
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			buildPage(...data);
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
