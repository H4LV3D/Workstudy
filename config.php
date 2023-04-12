<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'workstudy.cu.edu.ng');
define('DB_USERNAME', 'workstudy_dbadmin');
define('DB_PASSWORD', 'Mgz5;TO8x^we');
define('DB_NAME', 'workstudy_portal');
 
/* Attempt to connect to MySQL database */
$con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($con === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>