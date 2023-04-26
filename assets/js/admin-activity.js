window.onload = () => {
    fetch(`${API_URL}/users`, {
        method: 'GET',
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

const buildTable = (attendance) => {
    const table = document.getElementById('myTable');
    const tbody = table.querySelector('tbody');

    attendance.forEach((data, index) => {
        const row = document.createElement('tr');
        const sl = document.createElement('td');
        sl.classList.add('text-center');
        sl.textContent = index + 1;

        const name = document.createElement('td');
        name.classList.add('text-center');
        name.textContent = data.fullname;

        const matric = document.createElement('td');
        matric.classList.add('text-center');
        matric.textContent = data.username;

        const level = document.createElement('td');
        level.classList.add('text-center');
        level.textContent = data.level;

        const placement = document.createElement('td');
        placement.classList.add('text-center');
        placement.textContent = data.placement;

        const totalHours = document.createElement('td');
        totalHours.classList.add('text-center');
        totalHours.textContent = data.totalHours || '0';

        row.appendChild(sl);
        row.appendChild(name);
        row.appendChild(matric);
        row.appendChild(totalHours);
        row.appendChild(level);
        row.appendChild(placement);

        tbody.appendChild(row);
    });

    $(document).ready(function () {
        $('#myTable').DataTable();
    });
};

fetch(`${API_URL}/users/`, {
    method: 'GET',
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
    const username = document.getElementById('sidebar-name');
    username.innerText = data.fullname;

    const sbLevel = document.getElementById('sidebar-level');
    sbLevel.innerText = data.level || 'No level set';

    const totalHours = document.getElementById('totalHours');
    totalHours.innerText = data.totalHours.toFixed(2) || 'No record found';

    const greetName = document.getElementById('greetName');
    greetName.innerText = data.fullname;
};
