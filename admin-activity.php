<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

//return 403:unauthorized if session id is not 1
if ($_SESSION["id"] !== 1) {
    header("HTTP/1.0 403 Unauthorized");
    exit;
}

// database connection
include('config.php');
$added = false;
?>

<?php if (isset($_SESSION['username'])) : ?>
<?php endif ?>
<?php if (isset($_SESSION['id'])) : ?>
<?php endif ?>

<?php
$sql = "SELECT * FROM student_data WHERE username = '" . $_SESSION['username'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Work Study | Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css" />
    <!-- <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css" /> -->
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
                <a href="admin-activity.php" class="active">
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
                <a href="admin-settings.php">
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

    <div class="container my-5 py-5">
        <!-- adding alert notification  -->
        <?php
        if ($added) {
            echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
        }

        ?>
        <div class="flex flex-row justify-content-end">
            <button class="btn" style="background-color:#996399;" type="button" data-toggle="modal"
                data-target="#myModal">
                <a href="addstudent.php" class="fa fa-plus text-decoration-none text-white">
                    <span>New Student</span>
                </a>
            </button>
        </div>
        <hr>
        <div class="my-5">
            <table class="table table-bordered table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th class="text-center" scope="col">id</th>
                        <th class="text-center" scope="col">Name</th>
                        <th class="text-center" scope="col">Matric No</th>
                        <th class="text-center" scope="col">Week</th>
                        <th class="text-center" scope="col">Total Hours</th>
                        <th class="text-center" scope="col">Level</th>
                        <th class="text-center" scope="col">Placement</th>
                    </tr>
                </thead>
                <?php
                $get_data = "SELECT time_id, total_time, date, student_name FROM time_table ORDER BY time_id desc";
                // $get_data = "SELECT MAX(time_id),MAX(total_time),MAX(date),MAX(student_name) FROM time_table GROUP BY student_no";
                $run_data = mysqli_query($con, $get_data);
                $i = 0;
                while ($row = mysqli_fetch_array($run_data)) {
                    $id = $row[0];
                    $Student_Name = $row[3];
                    // $Matric_No = $row['Matric_No'];
                    // $Email = $row['Email'];
                    // $Program = $row['Program'];
                    $Total_time = $row[1];
                    $Date = $row[2];
                    // $Level = $row['Level'];

                    echo "
					<tr>
						<td class='text-center'>$id</td>
						<td class='text-left'>$Student_Name</td>
						<td class='text-left'>1234567890</td>
						<td class='text-left'>$Date</td>
						<td class='text-center'>$Total_time</td>
						<td class='text-center'>x1000</td>
						<td class='text-center'>SEALED</td>
					</tr>
					";
                }

                ?>
            </table>
        </div>
        <form method="post" action="export.php">
            <input type="submit" name="export" class="btn  px-5 py-2" value="Export Record"
                style="background-color: #996399;color: #eee;" />
        </form>
    </div>

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
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
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

</html>