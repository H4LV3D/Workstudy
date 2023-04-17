const API_URL = "http://127.0.0.1:3000";

window.onload = () => {
	fetch(`${API_URL}/attendance/`, {
		method: "GET",
		headers: {
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			buildTable(data);
			fetch(`${API_URL}/user/`, {
				method: "GET",
				headers: {
					Authorization: `token ${token}`,
				},
			})
				.then((response) => response.json())
				.then((data) => {
					buildPage(data);
				})
				.catch((error) => {
					console.log(error);
				});
		})
		.catch((error) => {
			console.log(error);
		});
};

let buildTable = (attendance) => {
	const table = document.getElementById("myTable");
	const tbody = table.querySelector("tbody");

	attendance.forEach((data, index) => {
		const row = document.createElement("tr");
		const sl = document.createElement("td");
		sl.classList.add("text-center");
		sl.textContent = 1;

		const date = document.createElement("td");
		date.classList.add("text-center");
		date.textContent = attendance.date;

		const timeIn = document.createElement("td");
		timeIn.classList.add("text-center");
		timeIn.textContent = attendance.signInTime;

		const timeOut = document.createElement("td");
		timeOut.classList.add("text-center");

		if (attendance.signOutTime) {
			timeOut.textContent = attendance.signOutTime.substring(11, 19);
		} else {
			timeOut.textContent = "-";
		}

		const totalHours = document.createElement("td");
		totalHours.classList.add("text-center");
		totalHours.textContent = data.totalTime;

		row.appendChild(sl);
		row.appendChild(date);
		row.appendChild(timeIn);
		row.appendChild(timeOut);
		row.appendChild(totalHours);
		tbody.appendChild(row);
	});

	$(document).ready(function () {
		$("#myTable").DataTable();
	});
};

let buildPage = (data) => {
	let username = document.getElementById("sidebar-name");
	username.innerText = data.fullname.split(" ")[0];

	let sbLevel = document.getElementById("sidebar-level");
	sbLevel.innerText = data.level || "No level set";

	let totalHours = document.getElementById("totalHours");
	totalHours.innerText = data.totalHours || "No record found";

	let greetName = document.getElementById("greetName");
	greetName.innerText = data.fullname.split(" ")[0];
};
