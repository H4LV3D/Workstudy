window.onload = () => {
	fetch(`${API_URL}/attendances/`, {
		method: "GET",
		credentials: "include",
	})
		.then((response) => response.json())
		.then((data) => {
			buildTable(data);
			fetch(`${API_URL}/users/`, {
				method: "GET",
				credentials: "include",
			})
				.then((response) => response.json())
				.then((data) => {
					buildPage(...data);
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
		sl.textContent += index + 1;

		const date = document.createElement("td");
		date.classList.add("text-center");
		date.textContent = data.date;

		const timeIn = document.createElement("td");
		timeIn.classList.add("text-center");
		timeIn.textContent = data.signInTime.substring(11, 19);

		const timeOut = document.createElement("td");
		timeOut.classList.add("text-center");

		if (data.signOutTime) {
			timeOut.textContent = data.signOutTime.substring(11, 19);
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
	username.innerText = data.fullname;

	let sbLevel = document.getElementById("sidebar-level");
	sbLevel.innerText = data.level || "No level set";

	let totalHours = document.getElementById("totalHours");
	totalHours.innerText = data.totalHours || "No record found";

	let greetName = document.getElementById("greetName");
	greetName.innerText = data.fullname;
};
