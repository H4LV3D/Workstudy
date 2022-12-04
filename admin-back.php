<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// database connection
include('config.php');

$added = false;

?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title> Work Study | Admin Dashboard</title>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
    <script src="https://kit.fontawesome.com/2029614d15.js" crossorigin="anonymous"></script>
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
                <a href="index.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Student Info</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="activity.php">
                    <i class='bx bxs-calendar'></i>
                    <span class="links_name">Attendance Records</span>
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

    <div class="container">
        <a href="https://lexacademy.in" target="_blank"><img
                src="https://lexacademy.in/wp-content/uploads/2021/07/lex-academy-online-learning-platform-1.png" alt=""
                width="350px"></a><br>
        <hr>

        <!-- adding alert notification  -->
        <?php
	if($added){
		echo "
			<div class='btn-success' style='padding: 15px; text-align:center;'>
				Your Student Data has been Successfully Added.
			</div><br>
		";
	}

?>

        <a href="logout.php" class="btn btn-success"><i class="fa fa-lock"></i> Logout</a>
        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#myModal">
            <!-- <a href="addstudent.php" class="fa fa-plus"></a> Add New Student -->
            <a href="addstudent.php" class="fa fa-plus text-decoration-none text-white"><span>Add New Student</span>
            </a>

        </button>
        <a href="export.php" class="btn btn-success pull-right"><i class="fa fa-download"></i> Export Data</a>
        <hr>
        <table class="table table-bordered table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th class="text-center" scope="col">id</th>
                    <th class="text-center" scope="col">Name</th>
                    <th class="text-center" scope="col">Matric No</th>
                    <th class="text-center" scope="col">Email</th>
                    <th class="text-center" scope="col">Program</th>
                    <th class="text-center" scope="col">Level</th>
                    <th class="text-center" scope="col">Placement</th>
                </tr>
            </thead>
            <?php

        	$get_data = "SELECT * FROM student_data order by 1 desc";
        	$run_data = mysqli_query($con,$get_data);
			$i = 0;
        	while($row = mysqli_fetch_array($run_data))
        	{
				$id = $row['id'];
				$Last_Name = $row['Last_Name'];
				$Other_Name = $row['Other_Name'];
				$Matric_No = $row['Matric_No'];
				$Email = $row['Email'];
				$Program = $row['Program'];
				$Placement = $row['Placement'];
				$Level = $row['Level'];

        		echo "
				<tr>
					<td class='text-center'>$id</td>
					<td class='text-left'>$Last_Name   $Other_Name</td>
					<td class='text-left'>$Matric_No</td>
					<td class='text-left'>$Email</td>
					<td class='text-center'>$Program</td>
					<td class='text-center'>$Level</td>
					<td class='text-center'>$Placement</td>
				</tr>
        		";
        	}

        	?>



        </table>
        <form method="post" action="export.php">
            <input type="submit" name="export" class="btn btn-success" value="Export Data" />
        </form>
    </div>




    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();

    });
    </script>

</body>

</html>