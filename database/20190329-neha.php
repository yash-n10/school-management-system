<?php 

$conn = new mysqli("crm.feesclub.com", "root", "antigravity");
$result = mysqli_query($conn,"SHOW FULL PROCESSLIST");
while ($row=mysqli_fetch_array($result)) {
  $process_id=$row["Id"];
  if ($row["Time"] > 8 && $row["State"]!='Sending data') {
    $sql="KILL $process_id";
    mysqli_query($conn,$sql);
  }
}
?>