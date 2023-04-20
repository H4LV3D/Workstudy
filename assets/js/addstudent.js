let addStudent = (e) => {
	e.preventDefault();

	// Get the username and password from the form
	let fullname = document.getElementById("fullname").value;
	let matricNumber = document.getElementById("matric_no").value;
	let email = document.getElementById("email").value;
	let program = document.getElementById("program").value;
	let level = document.getElementById("level").value;
	let placement = document.getElementById("placement").value;

	// Create a new object to send to the server
	let user = {
		username: matricNumber,
		password: matricNumber,
		email,
		fullname,
		placement,
		course: program,
		level,
	};

	// Send the user object to the server
	fetch(`${API_URL}/user/register`, {
		method: "POST",
		headers: {
			"Content-Type": "application/json",
		},
		body: JSON.stringify(user),
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.message === "Account Created!") {
				alert("Student added successfully!");
				window.location.href = "/portal/admin-addstudent.html";
			}
		})
		.catch((error) => {
			console.log(error);
		});
};
