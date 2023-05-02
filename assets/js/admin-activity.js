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

let table;
const buildTable = (attendance) => {
    table = $('#myTable').DataTable({
        data: attendance,
        columns: [
            {
                title: 'S/N',
                data: null,
                className: 'text-center',
                render: (data, type, row, meta) => meta.row + 1,
            },
            {
                title: 'Full Name',
                data: 'fullname',
                className: 'text-center',
            },
            {
                title: 'Username',
                data: 'username',
                className: 'text-center',
            },
            {
                title: 'Total Hours',
                data: 'totalHours',
                className: 'text-center',
                defaultContent: '0',
            },
            {
                title: 'Level',
                data: 'level',
                className: 'text-center',
            },
            {
                title: 'Placement',
                data: 'placement',
                className: 'text-center',
            },
        ],
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5'],
    });
};
