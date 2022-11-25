<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>

<?php
    // database connection
    include('config.php');

    $sql = "SELECT * FROM student_data WHERE username = '" . $_SESSION['username'] . "'";
    $result = mysqli_query($con,$sql);
    $row = mysqli_fetch_array($result);

    // echo "Hello, " . $row['Last_Name'] . " " . $row['Email'] . " ";

?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Work study Portal</title>
    
  
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="side.css">
   </head>
<body>
    <!-- Side Nav menu -->
        <div class="sidebar">
        <div class="logo-details">
        <i class='bx bxl-c-plus-plus icon'></i>
            <div class="logo_name">Work Study</div>
            <i class='bx bx-menu' id="btn" ></i>
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
            <i class='bx bxs-calendar' ></i>
            <span class="links_name">Activity</span>
        </a>
        <span class="tooltip">Activity</span>
        </li>
        <li>
        <a href="attendance.php">
            <i class='bx bx-pencil' ></i>
            <span class="links_name">Attendance</span>
        </a>
        <span class="tooltip">Attendance</span>
        </li>
        <li>
        <a href="settings.php">
            <i class='bx bx-cog' ></i>
            <span class="links_name">Setting</span>
        </a>
        <span class="tooltip">Setting</span>
        </li>
        <li class="profile">
            <div class="profile-details">
            <img src="profile.jpg" >
            <div class="name_job">
                <div class="name"><?php echo  $row['Other_Name']; ?> </div>
                <div class="job"><?php echo $row['Level']." "."Level"; ?></div>
            </div>
            </div>
            <a href="logout.php" ><i class='bx bx-log-out' id="log_out"></i></a>
        </li>
        </ul>
    </div>


<!-- Navigation menu -->
<section class="main-body">

    <div class="container">
        <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</h1>
        </div>
        <hr>
        <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
        </div>
        
    </p>
	
</section>
	
	
    <script>
                let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchBtn = document.querySelector(".bx-search");

        closeBtn.addEventListener("click", ()=>{
            sidebar.classList.toggle("open");
            menuBtnChange();//calling the function(optional)
        });

        searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search icon
            sidebar.classList.toggle("open");
            menuBtnChange(); //calling the function(optional)
        });

        // following are the code to change sidebar button(optional)
        function menuBtnChange() {
        if(sidebar.classList.contains("open")){
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the icons class
        }else {
            closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the icons class
        }
        }
    </script>
</body>
</html>