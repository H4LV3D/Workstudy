<?php  
//export.php  
include 'config.php';
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM student_data order by 1 desc";
 $result = mysqli_query($con, $query);
 if(mysqli_num_rows($result) > 0)
 {
  $output .= '
   <table class="table" bordered="1">  
                    <tr>  
                         <th>id</th>  
                         <th>Name</th>
                         <th>Matric No</th> 
                         <th>Email:</th>  
                         <th>Program</th>
                         <th>Level</th>  
                         <th>Placement</th>

                    </tr>
  ';
  $i = 0;
  while($row = mysqli_fetch_array($result))
  {
    $sl = ++$i;
   $output .= '
    <tr>  
                         <td > '.$sl.' </td> 
                         <td>'.$row["Other_Name"]  .$row["U_Last_name"].'</td>  
                         <td>'.$row["Matric_No"].'</td>  
                         <td>'.$row["Email"].'</td>  
                         <td>'.$row["Program"].'</td>  
                         <td>'.$row["Level"].'</td> 
                         <td>'.$row["Placement"].'</td>

                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=STUDENTSDATA.xls');
  echo $output;
 }
}
?>