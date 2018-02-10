<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$sql = "Select clientid from myclientsession
        where sessionid='$sessionid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor))
{   
    oci_free_statement($cursor);
    $clientid = $values[0];
}

$sql = "select studentid from studentinfo where clientid = '$clientid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor))
{
    oci_free_statement($cursor);
    $studentid = $values[0];
}

$sql = "select a.sectionid, b.coursenum, b.title, a.semester, b.credits, c.grade
        from coursesection a, course b, studentcourse c
        where a.sectionid = c.sectionid
        and a.coursenum = b.coursenum
        and studentid = $studentid
        and grade is not NULL";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}
echo("<br><br>");
echo("<center><h3>Classes you've taken</h3></center>");

echo "<center><table border=1>";
echo "<tr> <th>Section ID</th> <th>Course Number</th> <th>Title</th> <th>Semester</th> 
      <th>Credits</th><th>Grade</th></tr>";
  // Fetch the result from the cursor one by one
  while ($values = oci_fetch_array ($cursor)){
    $sid = $values[0];
    $cnum = $values[1];
    $title = $values[2];
    $semester = $values[3];
    $credits = $values[4];
    $grade = $values[5];

    echo("<tr>".
         "<td>$sid</td> <td>$cnum</td> <td>$title</td><td>$semester</td><td>$credits</td>".
         "<td>$grade</td></tr>");

}



?>
