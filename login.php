<?php
// Initialize the session
session_start();

require_once "config.php";

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM student_data WHERE username = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION['start'] = time(); // Taking now logged in time.
                            // Ending a session in 30 minutes from the starting time.
                            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60 * 60);
                            header('Location: login.php');
                            // $_SESSION["Last_name"] = $Last_name;</strong>
                            // $_SESSION["Other_Name"] = $Other_Name;
                            // $_SESSION["Matric_No"] = $Matric_No;
                            // $_SESSION["Email"] = $Email;
                            // $_SESSION["Program"] = $Program;
                            // $_SESSION["Level"] = $Level;
                            // $_SESSION["username"] = $Placement;                            

                            // Redirect user to welcome page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "Invalid Username or password";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    $username_err = "Invalid Matric No.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
}
?>



<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://kit.fontawesome.com/2029614d15.js" crossorigin="anonymous"></script>
    <meta charset="utf-8">
    <title>Workstudy - work and earn as students</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/login.css">
</head>

<body>
    <div class="login-root">
        <div class="box-root flex-flex flex-direction--column" style="min-height: 100vh;flex-grow: 1;">
            <div class="loginbackground box-background--white padding-top--64">
                <div class="loginbackground-gridContainer">
                    <div class="box-root flex-flex" style="grid-area: top / start / 8 / end;">
                        <div class="box-root"
                            style="background-image: linear-gradient(white 0%, rgb(247, 250, 252) 33%); flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 2 / auto / 5;">
                        <div class="box-root box-divider--light-all-2 animationLeftRight tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 6 / start / auto / 2;">
                        <div class="box-root box-background--blue800" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 7 / start / auto / 4;">
                        <div class="box-root box-background--blue animationLeftRight" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 8 / 4 / auto / 6;">
                        <div class="box-root box-background--gray100 animationLeftRight tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 2 / 15 / auto / end;">
                        <div class="box-root box-background--cyan200 animationRightLeft tans4s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 3 / 14 / auto / end;">
                        <div class="box-root box-background--blue animationRightLeft" style="flex-grow: 1;"></div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 4 / 17 / auto / 20;">
                        <div class="box-root box-background--gray100 animationRightLeft tans4s" style="flex-grow: 1;">
                        </div>
                    </div>
                    <div class="box-root flex-flex" style="grid-area: 5 / 14 / auto / 17;">
                        <div class="box-root box-divider--light-all-2 animationRightLeft tans3s" style="flex-grow: 1;">
                        </div>
                    </div>
                </div>
            </div>


            <img src="/assets/images/logo.png" class="image" alt="logo">
            <div class="box-root flex-flex flex-direction--column center-center" style="flex-grow: 1; z-index: 9;">
                <div class="formbg-outer">
                    <div class="formbg">
                        <div class="formbg-inner padding-horizontal--48">
                            <h2 class="padding-bottom--8">Work Study Portal</h2>
                            <p class="padding-bottom--24">Sign in to your account</p>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="stripe-login"
                                method="post">
                                <div class="field form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                                    <label for="email">Matric No.</label>
                                    <input type="text" name="username" class="form-control"
                                        value="<?php echo $username; ?>">
                                    <p class="padding-bottom--15 padding-top--8 flex-flex center-center text-red">
                                        <?php echo $username_err; ?>
                                    </p>
                                </div>
                                <div
                                    class="field padding-bottom--24  form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" class="form-control">
                                    <p>
                                        <a href="reset-password.php" class="reset">Forgot your password?</a>
                                    </p>
                                </div>
                                <p class="padding-bottom--15 flex-flex center-center text-red">
                                    <?php echo $password_err; ?>
                                </p>
                                <div class="field padding-bottom--15">
                                    <button type="submit" name="submit" id="submit" class="btn">

                                        Login</button>
                                </div>
                            </form>
                            <div class="listing reset-pass padding-top--15 flex-flex center-center">
                                <p><a href="https://portal.workstudy.edu.ng">©workstudy</a></p>
                                <p><a href="https://workstudy.cu.edu.ng">Home</a></p>
                                <p><a href="mailto:seald@covenantuniversity.edu.ng">Contact</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>