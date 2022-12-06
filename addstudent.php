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

        /* IF WE ARE HERE THEN THE ACCOUNT WAS CREATED! YAY! */
        /* WE WILL SEND EMAIL ACTIVATION CODE HERE LATER */

        $success = true;
    } else
        $error_msg = 'An error occurred and your account was not created.';
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> Work Study | Admin Dashboard</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
                <a href="admin-attendance.php">
                    <i class='bx bx-pencil'></i>
                    <span class="links_name">Add Student</span>
                </a>
                <span class="tooltip">Add Student</span>
            </li>
            <li>
                <a href="addstudent.php">

                    <i class="fas fa-user-plus fa-lg fa-fw"></i>
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

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-12 col-sm-10 col-md-8 mx-auto card p-4 rounded-15 ">
            <div class="modal-header px-5">
                <div class="row w-100">
                    <div class="col-10 col-sm-6 p-2">
                        <h4 class="modal-title">Add New Student</h4>
                    </div>
                    <div class="col-2 col-sm-6 text-end p-2">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <form action="addstudent.php" class="form" method="POST">
                    <div class="">
                        <?php
                                if (isset($success) && $success == true) {
                                    echo '<p color="green">New Student added successfully!<p>';
                                }
                                // check to see if the error message is set, if so display it
                                else if (isset($error_msg))
                                    echo '<p color="red">' . $error_msg . '</p>';
                                ?>
                    </div>

                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Username</label>
                            <input type="text" class="form-control" name="username" value=""
                                placeholder="enter a username" autocomplete="on" autofocus required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Password</label>
                            <input type="password" class="form-control" name="password" value=""
                                placeholder="enter a password" autocomplete="on" required />
                        </div>
                    </div> -->

                    <div class="py-4">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Last name</label>
                            <input type="text" class="form-control" name="Last_name" value="" placeholder="Last Name"
                                autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">First Name</label>
                            <input type="text" class="form-control" name="First_Name" value="" placeholder="First Name"
                                autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Matric No</label>
                            <input type="text" class="form-control" name="Matric_No" value=""
                                placeholder="enter a Matric No" autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" name="Email" value=""
                                placeholder="provide an email" autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Program</label>
                            <input type="text" class="form-control" name="Program" value=""
                                placeholder="provide an Program" autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Level</label>
                            <input type="number" class="form-control" name="Level" value=""
                                placeholder="provide an Level" autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Placement</label>
                            <input type="text" class="form-control" name="Placement" value=""
                                placeholder="provide an placement" autocomplete="on" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Phone Number (Telegram)</label>
                            <input type="text" class="form-control" name="Phone_Number" value=""
                                placeholder="provide an Phone Number" autocomplete="on" required />
                        </div>
                    </div>
                    <div class="form-group col-md-12 mt-3 d-flex justify-content-end">
                        <button class="col-md-4 btn btn-info btn-block btn-large w-100 py-3" type="submit"
                            style="background-color: #996399; border: 1px solid #996399;">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>