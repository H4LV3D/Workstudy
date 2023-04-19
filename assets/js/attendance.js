let matricNumber;
const preloader = document.getElementById("preloader");

fetch(`${API_URL}/users/`, {
	method: "GET",
	headers: {
		Authorization: `token ${token}`,
	},
})
	.then((response) => response.json())
	.then((data) => {
		matricNumber = data[0].username;
	})
	.catch((error) => {
		console.log(error);
	});

let signinAction = (e) => {
	let clickedButton = e.target.name;
	if (clickedButton == "signinbutton") {
		preloader.style.display = "flex";
		fetch(`${API_URL}/attendances`, {
			method: "POST",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				matricNumber: matricNumber,
			}),
		})
			.then((response) => response.json())
			.then((data) => {
				preloader.style.display = "none";
				if (data.error) {
					alert(data.error);
				} else {
					alert(`User signed in at ${data.signInTime.substring(11, 19)}`);
				}
			});
	} else if (clickedButton == "signoutbutton") {
		preloader.style.display = "flex";
		fetch(`${API_URL}/attendances`, {
			method: "PUT",
			headers: {
				"Content-Type": "application/json",
			},
			body: JSON.stringify({
				matricNumber: matricNumber,
			}),
		})
			.then((response) => response.json())
			.then((data) => {
				preloader.style.display = "none";
				if (data.message == "User not found or already signed out") {
					alert(data.message);
				} else if (data.date) {
					alert(`User signed out at ${data.signOutTime.substring(11, 19)}`);
				}
			});
	}
	e.preventDefault();
};
