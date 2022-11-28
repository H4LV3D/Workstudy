<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//
$now = time(); // Checking the time now when home page starts.

if ($now > $_SESSION['expire']) {
    session_destroy();
    header("location: login.php");
} else {
} //Starting this else one [else1]

// database connection
include('config.php');

$added = false;

// select user details
$sql = "SELECT * FROM student_data WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);


?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Work-study Portal</title>

    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="./assets/css/side.css">

    <script src="attendance.js"></script>
</head>

<body>
    <div class="sidebar">
        <div class="logo-details">
            <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">Work Study</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="home.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="activity.php">
                    <i class='bx bxs-calendar'></i>
                    <span class="links_name">Activity</span>
                </a>
                <span class="tooltip">Activity</span>
            </li>
            <li>
                <a href="attendance.php">
                    <i class='bx bx-pencil'></i>
                    <span class="links_name">Attendance</span>
                </a>
                <span class="tooltip">Attendance</span>
            </li>
            <li>
                <a href="settings.php">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Setting</span>
                </a>
                <span class="tooltip">Setting</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="profile.jpg">
                    <div class="name_job">
                        <div class="name">
                            <?php echo $row['Other_Name']; ?>
                        </div>
                        <div class="job">
                            <?php echo $row['Level'] . " " . "Level"; ?>
                        </div>
                    </div>
                </div>
                <a href="logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
            </li>
        </ul>
    </div>

    <section class="d-flex align-items-center justify-content-center vh-100">
        <div class="cards p-5 mx-auto shadow rounded" style="width: 24rem;">
            <div class="cards-body">
                <h3 class="card-title text-center">Attendance Card</h3>
                <p class="text-center">Please make sure to sign in and sign out properly. Any issues should be
                    reported to
                    Seald Office</p>

                <form action="attendance.php" id="loginFrm" class="pt-3" method="POST">

                    <button class="px-5 py-3 border-0 bg-primary w-100 rounded mb-3" type="submit" role="button"
                        name="signinbutton" type="submit">SIGN
                        IN</button>
                    <br>
                    <button class="px-5 py-3 border-0 bg-primary w-100 rounded" type="submit" role="button"
                        name="signoutbutton" type="submit">SIGN
                        OUT</button>
                </form>
                <?php $place = $row['Placement']; ?>
                <?php
                if (isset($_POST['signinbutton'])) {
                    $student = $_SESSION['id'];
                    $student_name = $row['Last_Name'] . " " . $row['Other_Name'];

                    $timein = date("H:i", strtotime("+1 HOURS"));
                    $timeout = '';
                    $total_time = '0';
                    $last_id = mysqli_insert_id($con);
                    // $timein = time.now();
                    $date = date("Y-m-d", strtotime("+1 HOURS"));
                    $sessid = $_SESSION['id'];

                    $whoursv = $con->query("SELECT `total_time` FROM time_table WHERE student_no = $sessid ORDER BY time_id DESC") or die(mysqli_error());
                    $pullwh = mysqli_fetch_array($whoursv, MYSQLI_ASSOC);
                    if ($pullwh != null) {
                        $whour = $pullwh['total_time'];
                    } else {
                        $whour = 0;
                    }

                    if ($whour <= 0) {
                        echo "<p class = 'para'>" . "You have already signed in</p>";
                    } else {
                        $con->query("INSERT INTO `time_table` VALUES('$last_id', '$student', '$student_name', '$timein', '$timeout', '$total_time', '$date')") or die(mysqli_error());
                        echo "<p class = 'para'>" . "Signed in " . " <label class = ''>at  " . date("h:i a", strtotime($timein)) . "</label></p>";
                    }
                }
                ?>

                <?php
                if (isset($_POST['signoutbutton'])) {
                    $student = $_SESSION['id'];
                    $timeout = date("H:i", strtotime("+1 HOURS"));
                    // $timeout = time();
                
                    $date = date("Y-m-d", strtotime("+1 HOURS"));
                    $student_name = $row['Last_Name'] . " " . $row['Other_Name'];

                    $last = "SELECT MAX(time_id) AS last_id FROM time_table WHERE student_no = '" . $_SESSION['id'] . "'";
                    $result = mysqli_query($con, $last);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $last_id = $row['last_id'];

                    $sessid = $_SESSION['id'];

                    $keep = $con->query("SELECT `timein` FROM time_table WHERE student_no = $sessid ORDER BY time_id DESC") or die(mysqli_error());
                    $pull = mysqli_fetch_array($keep, MYSQLI_ASSOC);
                    $timein = strtotime($pull['timein']);
                    $calctimeout = strtotime($timeout);

                    $whoursv = $con->query("SELECT `total_time` FROM time_table WHERE student_no = $sessid ORDER BY time_id DESC") or die(mysqli_error());
                    $pullwh = mysqli_fetch_array($whoursv, MYSQLI_ASSOC);
                    $whour = $pullwh['total_time'];

                    if ($whour > 0) {
                        echo "<p class = 'para'>" . "You have already signed out</p>";
                    } else {
                        $workingHours = ($calctimeout - $timein) / 3600;
                        $con->query("UPDATE `time_table` SET `timeout` = '$timeout' WHERE time_id = '$last_id'") or die(mysqli_error());
                        $con->query("UPDATE `time_table` SET `total_time` = '$workingHours' WHERE time_id = '$last_id'") or die(mysqli_error());

                        echo "<p class = 'para'>" . "Signed out " . " <label class = ''>at  " . date("h:i a", strtotime($timeout)) . "</label></p>";
                    }

                }
                ?>

            </div>
        </div>
    </section>
    <script>
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });
    </script>
</body>

</html>