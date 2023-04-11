const API_URL = "http://127.0.0.1:3000";
// const token = document.cookie.split("=")[1];
console.log(token);

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
	let username = document.getElementById("sidebar-name");
	username.innerText = data.fullname.split(" ")[0];

	let sbLevel = document.getElementById("sidebar-level");
	sbLevel.innerText = data.level || "No level set";

	let cardName = document.getElementById("card-fullname");
	cardName.innerText = data.fullname;

	let cardMatric = document.getElementById("card-matric");
	cardMatric.innerText = data.username;

	let cardLevel = document.getElementById("card-level");
	cardLevel.innerText = data.level || "No level set";

	let cardEmail = document.getElementById("card-email");
	cardEmail.innerText = data.email;

	let cardPlacement = document.getElementById("card-placement");
	cardPlacement.innerText = data.placement || "No placement set";
};
