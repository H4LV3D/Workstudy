<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

//
$now = time(); // Checking the time now when page starts.

  if ($now > $_SESSION['expire']) {
      session_destroy();
      header("location: login.php");
  }
  else { }//Starting this else one [else1]

// database connection
include('config.php');

$added = false;
?>

<!-- Session variables -->
<?php  if (isset($_SESSION['username'])) : ?>
<?php endif ?>
<?php  if (isset($_SESSION['id'])) : ?>
<?php endif ?>
<!--  -->
<!-- User Details -->
<?php
    $sql = "SELECT * FROM time_table WHERE student_no = '" . $_SESSION['id'] . "'";
    $result1 = mysqli_query($con,$sql);
    // $row1 = mysqli_fetch_array($result);

?>

<?php
    // database connection
    // include('config.php');

    $sql = "SELECT * FROM student_data WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    // echo "Hello, " . $row['Last_Name'] . " " . $row['Email'] . " ";

?>




<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <title> Work study Portal</title>
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
                    <span class="links_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="./assets/images/profile.jpg">
                    <div class="name_job">
                        <div class="name"><?php echo  $row['Other_Name']; ?> </div>
                        <div class="job"><?php echo $row['Level']." "."Level"; ?></div>
                    </div>
                </div>
                <a href="logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
            </li>
        </ul>
    </div>
    <section class="main-body">

        <div class="headers">
            <h2>Activity Board</h2>
            <h3>Hi, <?php echo " " . strtolower($row['Other_Name']); ?></h3>
            <h3>Work study Attendance sheet</h3>
            <br>
            <br>
        </div>

        <table class="table table-bordered table-striped table-hover" id="myTable">
            <thead>
                <tr>
                    <th class="text-center" scope="col">s/n</th>
                    <!-- <th class="text-center" scope="col">id</th> -->
                    <th class="text-center" scope="col">Date</th>
                    <th class="text-center" scope="col">Time In</th>
                    <th class="text-center" scope="col">Time Out</th>
                    <th class="text-center" scope="col">No. of hours</th>
                </tr>
            </thead>

            <?php
              // include ('config.php');
              // $get_data = "SELECT * FROM 'time_table' WHERE student_no = '" . $_SESSION['id'] . "'";
              // $run_data = mysqli_query($con,$get_data);
              $i = 0;
              while($row1 = mysqli_fetch_array($result1))
              {
                $sl = ++$i;
                $date = $row1['date'];
                $student_name = $row1['student_name'];
                $timein = $row1['timein'];
                $timeout = $row1['timeout'];
                $total_time = $row1['total_time'];
      
                echo "
                  <tr>
                      <td class='text-center'>$sl</td>
                      <td class='text-center'>$date</td>
                      <td class='text-center'>$timein</td>
                      <td class='text-center'>$timeout</td>
                      <td class='text-center'>$total_time</td>
                  </tr>
                ";
              }
        	  ?>
            <td class='text-center'></td>
            <td class='text-center'>Total Time:</td>
            <td class='text-center'>
                <?php
                // require('config.php');

                $table_sum="SELECT sum(total_time) as total FROM time_table WHERE student_no = '" . $_SESSION['id'] . "' ";

                $sum_table = mysqli_query($con,$table_sum);
                while ($row = mysqli_fetch_assoc($sum_table))
                { 
                  if ($row['total'] != null) {
                    echo round($row['total'], 2);
                  } else {
                    echo "No record found";
                  }
                }

                mysqli_close($con);
              ?>
            </td>
            <td class='text-center'></td>
            <td class='text-center'></td>



        </table>


    </section>


    <script>
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");

    closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        // menuBtnChange(); //calling the function(optional)
    });

    searchBtn.addEventListener("click", () => { // Sidebar open when you click on the search icons
        sidebar.classList.toggle("open");
        menuBtnChange(); //calling the function(optional)
    });

    // following are the code to change sidebar button(optional)
    function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the icons class
        } else {
            closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the icons class
        }
    }
    </script>
</body>

</html>