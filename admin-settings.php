<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}
// database connection
include('config.php');

if (isset($_POST['registerBtn'])) {
    // get all of the form data 
    $id = mysqli_insert_id($con);
    $username = $_POST['username'];
    $password = $_POST['password'];
    $Last_Name = $_POST['Last_name'];
    $Other_Name = $_POST['Other_Name'];
    $Matric_No = $_POST['Matric_No'];
    $Email = $_POST['Email'];
    $Program = $_POST['Program'];
    $Level = $_POST['Level'];
    $Placement = $_POST['Placement'];

    // next code block
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

    // insert the user into the database
    mysqli_query($con, "INSERT INTO student_data VALUES (
        '{$id}', '{$username}', '{$param_password}', '{$Last_Name}', '{$Other_Name}', '{$Matric_No}', '{$Email}', '{$Program}', '{$Level}', '{$Placement}'
    )");

    // verify the user's account was created
    $query = mysqli_query($con, "SELECT * FROM student_data WHERE Email='{$Email}'");
    if (mysqli_num_rows($query) == 1) {

        $success = true;
    } else
        $error_msg = 'An error occurred and your account was not created.';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Work Study | Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://kit.fontawesome.com/2029614d15.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/side.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
    <link href="./assets/fontawesome-free-6.2.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="./assets/fontawesome-free-6.2.1-web/css/brands.css" rel="stylesheet">
    <link href="./assets/fontawesome-free-6.2.1-web/css/solid.css" rel="stylesheet">
</head>

<body>

    <div class="d-none d-md-block sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">Work Study</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="admin-dashboard.php">
                    <i class='bx bxs-grid-alt'></i>
                    <span class="links_name">Student Info</span>
                </a>
                <span class="tooltip">Student Info</span>
            </li>
            <li>
                <a href="admin-activity.php">
                    <i class='fas fa-calendar-days'></i>
                    <span class="links_name">Attendance Records</span>
                </a>
                <span class="tooltip">Attendance Records</span>
            </li>
            <li>
                <a href="addstudent.php">
                    <i class="fas fa-user-plus fa-lg fa-fw"></i>
                    <span class="links_name">Add Student</span>
                </a>
                <span class="tooltip">Add Student</span>
            </li>
            <li>
                <a href="admin-settings.php" class="active">
                    <i class="fas fa-gears fa-lg fa-fw"></i>
                    <span class="links_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <i class="fas fa-user-circle fa-4x fa-fw"></i>
                    <div class="name_job">
                        <div class="name">
                            <?php echo $row['Other_Name']; ?>
                        </div>
                        <div class="job">
                            <?php echo $row['Level'] . " " . "Level"; ?>
                        </div>
                    </div>
                </div>
                <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket" id="log_out"></i></a>
            </li>
        </ul>
    </div>

    <section class="main-body container my-5 mb-md-0">
        <div class="col-12 min-vh-100 mx-auto">
            <div class="container">
                <div class="page-header">
                    <p class="p-0 m-0 mb-2">
                        <small style="color: #996399;" class="text-center">Work-study Portal</small>
                    </p>
                    <h4>Hi
                        <b>
                            <?php echo htmlspecialchars($_SESSION["username"]); ?>,
                        </b>
                    </h4>
                </div>
                <button type="button" class="btn btn-warning shadow-none border-0 text-white px-5 px-sm-4 py-2"
                    style="background-color: #996399;" data-toggle="modal" data-target="#exampleModal">
                    Reset Your Password
                </button>
                <div class="d-md-none">
                    <p>Sign Out of Your Account
                    </p>
                    <a href="logout.php">
                        <button type="button" class="btn btn-warning shadow-none border-0 text-white px-5 px-sm-4 py-2">
                            Logout
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>
    <script>
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");
    let button = document.querySelector(".bx-menu");

    closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        $(button).toggleClass('bx-search bxs-x-square');
    });
    $(document).ready(function() {
        $('.dropdown-toggle').dropdown()
    });
    </script>
</body>

</html>