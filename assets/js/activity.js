const preloader = document.getElementById("preloader");

preloader.style.display = "flex";
window.onload = () => {
	fetch(`${API_URL}/attendances/`, {
		method: "GET",
		headers: {
			Authorization: `token ${token}`,
		},
	})
		.then((response) => response.json())
		.then((data) => {
			preloader.style.display = "none";
			buildTable(data);
			fetch(`${API_URL}/users/`, {
				method: "GET",
				headers: {
					Authorization: `token ${token}`,
				},
			})
				.then((response) => response.json())
				.then((userData) => {
					buildPage(...userData);
				})
				.catch((error) => {
					console.log(error);
				});
		})
		.catch((error) => {
			preloader.style.display = "none";
			console.log(error);
		});
};

const buildTable = (attendance) => {
	const table = document.getElementById("myTable");
	const tbody = table.querySelector("tbody");

	attendance.forEach((data, index) => {
		const row = document.createElement("tr");
		const sl = document.createElement("td");
		sl.classList.add("text-center");
		sl.textContent = index + 1;

		const date = document.createElement("td");
		date.classList.add("text-center");
		date.textContent = data.date;

		const timeIn = document.createElement("td");
		timeIn.classList.add("text-center");
		timeIn.textContent = data.signInTime.substring(11, 19);

		const timeOut = document.createElement("td");
		timeOut.classList.add("text-center");
		timeOut.textContent = data.signOutTime
			? data.signOutTime.substring(11, 19)
			: "-";

		const totalHours = document.createElement("td");
		totalHours.classList.add("text-center");
		totalHours.textContent = data.totalTime.toFixed(3);

		row.appendChild(sl);
		row.appendChild(date);
		row.appendChild(timeIn);
		row.appendChild(timeOut);
		row.appendChild(totalHours);
		tbody.appendChild(row);
	});

	$(document).ready(() => {
		$("#myTable").DataTable();
	});
};

const buildPage = (data) => {
	const username = document.getElementById("sidebar-name");
	username.innerText = data.fullname;

	const sbLevel = document.getElementById("sidebar-level");
	sbLevel.innerText = data.level || "No level set";

	const totalHours = document.getElementById("totalHours");
	totalHours.innerText = data.totalHours.toFixed(2) || "No record found";

	const greetName = document.getElementById("greetName");
	greetName.innerText = data.fullname;
};
