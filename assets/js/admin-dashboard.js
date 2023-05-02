// Fetch users data from the API and build the table
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

// Build the DataTable with the given data
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
            { title: 'Full Name', data: 'fullname', className: 'text-center' },
            { title: 'Username', data: 'username', className: 'text-center' },
            { title: 'Email', data: 'email', className: 'text-center' },
            { title: 'Course', data: 'course', className: 'text-center' },
            { title: 'Level', data: 'level', className: 'text-center' },
            { title: 'Placement', data: 'placement', className: 'text-center' },
        ],
        dom: 'Bfrtip',
        buttons: ['copyHtml5', 'excelHtml5', 'pdfHtml5'],
    });
};

// Show the edit modal when a row is clicked
$('#myTable').on('click', 'tbody tr', function () {
    const rowData = table.row(this).data();
    showModal(rowData);
});

const modal = $('#editUserModal');

// Populate the edit modal with the data and submit the form when it's submitted
function showModal(rowData) {
    modal.find('#id').val(rowData.id);
    modal.find('#fullname').val(rowData.fullname);
    modal.find('#username').val(rowData.username);
    modal.find('#email').val(rowData.email);
    modal.find('#course').val(rowData.course);
    modal.find('#level').val(rowData.level);
    modal.find('#placement').val(rowData.placement);

    modal.find('form').submit(function (event) {
        event.preventDefault();
        const formData = $(this).serialize();
        console.log('Form data:', formData);

        fetch(`${API_URL}/users/${rowData.id}`, {
            method: 'PUT',
            headers: {
                Authorization: `token ${token}`,
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.error) {
                    alert(data.message);
                } else {
                    alert(data.message);
                    // window.location.reload();
                }
            })
            .catch((error) => {
                console.log(error);
            });
    });

    modal.modal('show');
}
