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
    <title>Workstudy | Portal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
        <a href="x" target="_blank"><img
                src="x" alt=""
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
            <a href="addstudent.php" class="fa fa-plus">Add New Student</a>

        </button>

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