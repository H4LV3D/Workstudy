window.onload = () => {
	// Send the user object to the server
	fetch(`${API_URL}/users/me`, {
		method: "GET",
		headers: {
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			if (!data.error) {
				buildPage(...data);
			} else {
				return;
			}
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

	let cardHours = document.getElementById("card-totalHours");
	cardHours.innerText = data.totalHours || "No record found";

	let cardProgram = document.getElementById("card-program");
	cardProgram.innerText = data.course;
};
