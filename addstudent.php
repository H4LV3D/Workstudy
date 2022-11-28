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

// header("Location: ./index.php", TRUE, 301);
// exit;
?>


<!-- html -->
<html>

<head>
    <title>Add New Student</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <!-- error message code here -->

    <!-- registration form html code here -->

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-body">
                    <form action="addstudent.php" class="form" method="POST">

                        <div class="modal-body">
                            <?php
                                // check to see if the user successfully created an account
                                if (isset($success) && $success == true) {
                                    echo '<p color="green">Yay!! Your account has been created. <a href="./login.php">Click here</a> to login!<p>';
                                }
                                // check to see if the error message is set, if so display it
                                else if (isset($error_msg))
                                    echo '<p color="red">' . $error_msg . '</p>';

                                ?>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Username</label>
                                <input type="text" class="form-control" name="username" value=""
                                    placeholder="enter a username" autocomplete="off" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Password</label>
                                <input type="password" class="form-control" name="password" value=""
                                    placeholder="enter a password" autocomplete="off" required />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Last name</label>
                                <input type="text" class="form-control" name="Last_name" value=""
                                    placeholder="enter a Last name" autocomplete="off" required />
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Other Names</label>
                                <input type="text" class="form-control" name="Other_Name" value=""
                                    placeholder="enter a other names" autocomplete="off" required />
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Matric No</label>
                            <input type="text" class="form-control" name="Matric_No" value=""
                                placeholder="enter a Matric No" autocomplete="off" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="email" class="form-control" name="Email" value=""
                                placeholder="provide an email" autocomplete="off" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Program</label>
                            <input type="text" class="form-control" name="Program" value=""
                                placeholder="provide an Program" autocomplete="off" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Level</label>
                            <input type="number" class="form-control" name="Level" value=""
                                placeholder="provide an Level" autocomplete="off" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">Placement</label>
                            <input type="text" class="form-control" name="Placement" value=""
                                placeholder="provide an placement" autocomplete="off" required />
                        </div>


                        <div class="modal-footer">
                            <input class="btn btn-info btn-large" type="submit" name="registerBtn"
                                value="create account" />
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>