let matricNumber;
window.onload = () => {
	fetch(`${API_URL}/user/`, {
		method: "GET",
		headers: {
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			matricNumber = data.username;
		})
		.catch((error) => {
			console.log(error);
		});
};

let signinAction = (e) => {
	let clickedButton = e.target.name;
	if (clickedButton == "signinbutton") {
		fetch(`${API_URL}/attendance`, {
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
				if (data.error) {
					alert(data.error);
				} else {
					alert(`User signed in at ${data.signInTime.substring(11, 19)}`);
				}
			});
	} else if (clickedButton == "signoutbutton") {
		fetch(`${API_URL}/attendance`, {
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
				if (data.message == "User not found or already signed out") {
					alert(data.message);
				} else if (data.date) {
					alert(`User signed out at ${data.signOutTime.substring(11, 19)}`);
				}
			});
	}
	e.preventDefault();
};
