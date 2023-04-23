let matricNumber;

const preloader = document.getElementById("preloader");

preloader.style.display = "flex";
window.onload = () => {
	fetch(`${API_URL}/users`, {
		method: "GET",
		headers: {
			Authorization: `Bearer ${token}`,
		},
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Network response was not ok");
			}
			return response.json();
		})
		.then((data) => {
			preloader.style.display = "none";
			matricNumber = data[0].username;
		})
		.catch((error) => {
			preloader.style.display = "none";
			console.error("Error fetching user data:", error);
		});
};

const signIn = (e) => {
	e.preventDefault();
	preloader.style.display = "flex";
	fetch(`${API_URL}/attendances`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
			Authorization: `Bearer ${token}`,
		},
		body: JSON.stringify({
			matricNumber,
		}),
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Network response was not ok");
			}
			return response.json();
		})
		.then((data) => {
			preloader.style.display = "none";
			if (data.error) {
				alert(data.error);
			} else {
				alert(`User signed in at ${data.signInTime.substring(11, 19)}`);
			}
		})
		.catch((error) => {
			console.error("Error signing in user:", error);
		});
};

const signOut = (e) => {
	e.preventDefault();
	preloader.style.display = "flex";
	fetch(`${API_URL}/attendances`, {
		method: "PUT",
		headers: {
			"Content-Type": "application/json",
			Authorization: `Bearer ${token}`,
		},
		body: JSON.stringify({
			matricNumber,
		}),
	})
		.then((response) => {
			if (!response.ok) {
				throw new Error("Network response was not ok");
			}
			return response.json();
		})
		.then((data) => {
			preloader.style.display = "none";
			if (data.message == "User not found or already signed out") {
				alert(data.message);
			} else if (data.date) {
				alert(`User signed out at ${data.signOutTime.substring(11, 19)}`);
			}
		})
		.catch((error) => {
			console.error("Error signing out user:", error);
		});
};
