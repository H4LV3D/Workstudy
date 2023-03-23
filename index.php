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
?>

<!-- Session variables -->
<?php if (isset($_SESSION['username'])) : ?>
<?php endif ?>
<?php if (isset($_SESSION['id'])) : ?>
<?php endif ?>
<!--  -->
<!-- User Details -->
<?php
$sql = "SELECT * FROM student_data WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Work Study | Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="/assets/css/side.css">
    <link href="/assets/fontawesome-free-6.2.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.2.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.2.1-web/css/solid.css" rel="stylesheet">
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
                <a href="index.php" class="active">
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
                    <!-- <img src="/assets/images/profile.jpg"> -->
                    <i class="fas fa-user-circle fa-3x fa-fw"></i>
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

    <div class="d-md-none fixed-bottom mb-2">
        <div class="row d-flex justify-content-center items-align-center">
            <ul
                class="col-10 d-flex flex-row justify-content-between align-items-center my-auto py-3 px-5 border rounded-15 shadow bg-white">
                <a href="index.php" class="text-decoration-none text-light" class="active">
                    <i class='bx bx-grid-alt' style="color:#996399;"></i>
                </a>
                <a href="activity.php" class="text-decoration-none text-light">
                    <i class='bx bxs-calendar' style="color:#000;"></i>
                </a>
                <a href="attendance.php" class="text-decoration-none text-light">
                    <i class='bx bx-pencil' style="color:#000;"></i>
                </a>
                <a href="settings.php" class="text-decoration-none text-light">
                    <i class='bx bx-cog' style="color:#000;"></i>
                </a>
            </ul>
        </div>
    </div>

    <section class="home-section mb-md-0">
        <div class="min-vh-100 py-5 mx-auto col-md-12 col-12">
            <div class="row mx-1 mx-sm-3 pb-5xp">
                <div class="col-12 bg-white shadow rounded p-4 p-md-5">
                    <small class="text-center" style="color: #996399;text-align: center;">Work-study Portal</small>
                    <h3 class="text-center text-md-left pt-2">Profile</h3>
                    <div class="col-12 d-flex flex-md-row flex-column mt-4">
                        <div class="col-12 col-md-4 col-lg-3 text-center">
                            <i class="fas fa-user-circle fa-7x fa-fw"></i>
                        </div>
                        <div class="col-12 col-md-8 my-3 my-md-auto">
                            <h5>
                                <?php echo $row['Last_Name'] . " " . $row['Other_Name']; ?>
                            </h5>
                            <p class="text-secondary mb-1">
                                <?php echo $row['Matric_No']; ?>
                            </p>
                            <p class="text-muted font-size-sm">
                                <?php echo $row['Email']; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-12 mb-5 my-md-5 px-lg-5">
                        <!-- <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Reg No.</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        1801648
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Student Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?php echo $row['Email']; ?>
                                    </div>
                                </div> -->
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <h6 class="mb-0">Course / Program</h6>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                <?php echo $row['Program']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <h6 class="mb-0">Placement</h6>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                <?php echo $row['Placement']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <h6 class="mb-0">Level</h6>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                <?php echo $row['Level']; ?>
                            </div>
                        </div>
                        <!-- <hr>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                        <h6 class="mb-0">Telegram No.</h6>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                        07034567890
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                        <h6 class="mb-0">Hall / Room</h6>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                        Daniel Hall B204
                                    </div>
                                </div> -->
                        <hr>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                <h6 class="mb-0">Total Hours Worked</h6>
                            </div>
                            <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                <?php
                                $table_sum = "SELECT sum(total_time) as total FROM time_table WHERE student_no = '" . $_SESSION['id'] . "' ";
                                $sum_table = mysqli_query($con, $table_sum);
                                while ($row = mysqli_fetch_assoc($sum_table)) {
                                    if ($row['total'] != null) {
                                        echo round($row['total'], 2);
                                    } else {
                                        echo "No record found";
                                    }
                                }

                                mysqli_close($con);
                                ?>
                            </div>
                        </div>
                        <hr>
                        <div class="dropdown show">
                            <div class="text-secondary" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="row">
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                        <h6 class="mb-0">More Info</h6>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                        Click here to view
                                    </div>
                                </div>
                                <hr>
                            </div>

                            <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-item" href="#">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                            <h6 class="mb-0">Bank Name</h6>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                            <?php
                                                if($row['Bank_Name']) {
                                                    echo $row['Bank_Name'];
                                                } else {
                                                    echo "Bank Name not set";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <a class="dropdown-item" href="#">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                            <h6 class="mb-0">Account No.</h6>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                            <?php
                                                if($row['Account_No']) {
                                                    echo $row['Account_No'];
                                                } else {
                                                    echo "Account_No not set";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                </a>
                                <a class="dropdown-item" href="#">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-3">
                                            <h6 class="mb-0">Account Name</h6>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-6 col-lg-9 text-secondary">
                                            <?php
                                                if($row['Account_Name']) {
                                                    echo $row['Account_Name'];
                                                } else {
                                                    echo "Account_Name not set";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <hr>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <h5>Contact</h5>
                        <small>For complains or enquiries, please reach out to us.</small>
                        <div class="row mt-2">
                            <div class="col-12 col-sm-6 col-md-3 text-md-center">
                                <a href="https://www.instagram.com/studentcouncil_cu/" class="btn"><i
                                        class="fab fa-telegram fa-lg fa-fw pr-3"></i>Telegram</a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3  text-md-center">
                                <a href="change-password.php"
                                    class="btn d-flex align-items-center justify-content-center">
                                    <i class="fab fa-instagram fa-lg fa-fw pr-3"></i>
                                    <p class="my-auto">Instagram</p>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-md-center">
                                <a href="change-password.php" class="btn">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <i class="fas fa-globe fa-lg fa-fw pr-3"></i>
                                        <p class="my-auto">Website</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3 text-md-center">
                                <a href="mailt0:seald@covenantuniversity.edu.ng" class="btn  border-0">
                                    <i class="fas fa-envelope fa-lg fa-fw pr-3"></i>
                                    Mail</a>
                            </div>
                        </div>
                    </div>
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