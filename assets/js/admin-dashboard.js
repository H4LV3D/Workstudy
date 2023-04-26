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

// const buildTable = (attendance) => {
//   const table = document.getElementById("myTable");
//   const tbody = table.querySelector("tbody");

//   attendance.forEach((data, index) => {
//     const row = document.createElement("tr");

//     const sl = document.createElement("td");
//     sl.classList.add("text-center");
//     sl.textContent = index + 1;

//     const name = document.createElement("td");
//     name.classList.add("text-center");
//     name.textContent = data.fullname;

//     const matric = document.createElement("td");
//     matric.classList.add("text-center");
//     matric.textContent = data.username;

//     const email = document.createElement("td");
//     email.classList.add("text-center");
//     email.textContent = data.email;

//     const program = document.createElement("td");
//     program.classList.add("text-center");
//     program.textContent = data.course;

//     const level = document.createElement("td");
//     level.classList.add("text-center");
//     level.textContent = data.level;

//     const placement = document.createElement("td");
//     placement.classList.add("text-center");
//     placement.textContent = data.placement;

//     row.appendChild(sl);
//     row.appendChild(name);
//     row.appendChild(matric);
//     row.appendChild(email);
//     row.appendChild(program);
//     row.appendChild(level);
//     row.appendChild(placement);

//     tbody.appendChild(row);
//   });

//   $(document).ready(function () {
//     $("#myTable").DataTable();
//   });
// };

// document.getElementById("exportButton").addEventListener("click", () => {
//   $("#myTable").DataTable({
//     dom: "Bfrtip",
//     buttons: ["excel", "pdf"],
//   });
// });

let table;
const buildTable = (attendance) => {
  table = $("#myTable").DataTable({
    data: attendance,
    columns: [
      {
        title: "SL",
        data: null,
        className: "text-center",
        render: (data, type, row, meta) => meta.row + 1,
      },
      { title: "Full Name", data: "fullname", className: "text-center" },
      { title: "Username", data: "username", className: "text-center" },
      { title: "Email", data: "email", className: "text-center" },
      { title: "Course", data: "course", className: "text-center" },
      { title: "Level", data: "level", className: "text-center" },
      { title: "Placement", data: "placement", className: "text-center" },
    ],
    dom: "Bfrtip",
    buttons: ["copyHtml5", "excelHtml5", "pdfHtml5"],
  });
};

$("#myTable").on("click", "tbody tr", function () {
  const rowData = table.row(this).data();
  showModal(rowData);
});

const modal = $("#editUserModal");

function showModal(rowData) {
  modal.find("#id").val(rowData.id);
  modal.find("#fullname").val(rowData.fullname);
  modal.find("#username").val(rowData.username);
  modal.find("#email").val(rowData.email);
  modal.find("#course").val(rowData.course);
  modal.find("#level").val(rowData.level);
  modal.find("#placement").val(rowData.placement);

  modal.find("form").submit(function (event) {
    event.preventDefault();
    const formData = $(this).serialize();
    fetch(`${API_URL}/users/${rowData.id}`, {
      method: "PUT",
      headers: {
        Authorization: `token ${token}`,
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.error) {
          alert(data.message);
        } else {
          alert(data.message);
          window.location.reload();
        }
      })
      .catch((error) => {
        console.log(error);
      });
  });
  modal.modal("show");
}

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
