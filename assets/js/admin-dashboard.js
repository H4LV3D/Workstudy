const preloader = document.getElementById('preloader');

preloader.style.display = 'flex';
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
            preloader.style.display = 'none';
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
        const fullName = document.getElementById('fullname').value;
        const username = document.getElementById('username').value;
        const email = document.getElementById('email').value;
        const course = document.getElementById('course').value;
        const level = document.getElementById('level').value;
        const placement = document.getElementById('placement').value;

        // Create a JavaScript object with the form data
        const formData = {
            fullName: fullName,
            username: username,
            email: email,
            course: course,
            level: level,
            placement: placement,
        };

        if (
            rowData.fullname === formData.fullName &&
            rowData.username === formData.username &&
            rowData.email === formData.email &&
            rowData.course === formData.course &&
            rowData.level === formData.level &&
            rowData.placement === formData.placement
        ) {
            alert('No changes made');
            modal.modal('hide');
        } else {
            preloader.style.display = 'flex';

            fetch(`${API_URL}/user/${rowData.username}`, {
                method: 'PUT',

                headers: {
                    Authorization: `token ${token}`,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(formData),
            })
                .then((response) => response.json())
                .then((data) => {
                    preloader.style.display = 'none';

                    if (data.error) {
                        alert(data.error);
                    } else {
                        alert(data.message);
                        window.location.reload();
                    }
                })
                .catch((error) => {
                    console.log(error);
                });
        }
    });

    modal.modal('show');
}
