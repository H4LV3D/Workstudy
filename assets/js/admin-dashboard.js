const API_URL = "http://127.0.0.1:3000";

window.onload = () => {
	fetch(`${API_URL}/users`, {
		method: "GET",
		headers: {
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			buildTable(data);
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
		sl.textContent = index + 1;

		const name = document.createElement("td");
		name.classList.add("text-center");
		name.textContent = data.fullname;

		const matric = document.createElement("td");
		matric.classList.add("text-center");
		matric.textContent = data.username;

		const email = document.createElement("td");
		email.classList.add("text-center");
		email.textContent = data.email;

		const program = document.createElement("td");
		program.classList.add("text-center");
		program.textContent = data.course;

		const totalHours = document.createElement("td");
		totalHours.classList.add("text-center");
		if (data.totalHours) {
			totalHours.textContent = data.totalHours;
		} else {
			totalHours.textContent = "0";
		}

		const level = document.createElement("td");
		level.classList.add("text-center");
		level.textContent = data.level;

		const placement = document.createElement("td");
		placement.classList.add("text-center");
		placement.textContent = data.placement;

		row.appendChild(sl);
		row.appendChild(name);
		row.appendChild(matric);
		row.appendChild(email);
		row.appendChild(program);
		row.appendChild(level);
		row.appendChild(placement);

		tbody.appendChild(row);
	});

	$(document).ready(function () {
		$("#myTable").DataTable();
	});
};
