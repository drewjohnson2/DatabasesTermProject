<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$studentid = $_GET["studentid"];
$cnum = $_GET["cnum"];

$sql = "select coursesection.sectionid, coursesection.coursenum, course.title, course.credits, 
        coursesection.semester, coursesection.seatstaken, coursesection.maxseats
        from coursesection join course on coursesection.coursenum = course.coursenum
        where coursesection.coursenum = $cnum";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    display_oracle_error_message($cursor);
    die("query failed");
}

echo "<center><table border=1>";
echo "<tr><th>Section ID</th> <th>Course Number</th> <th>Title</th><th>Credits</th> 
      <th>Semester</th><th>Seats Taken</th><th>Max Seats</th></tr>";
  // Fetch the result from the cursor one by one
  while ($values = oci_fetch_array ($cursor)){
    $sid = $values[0];
    $coursenum= $values[1];
    $title = $values[2];
    $credits = $values[3];
    $semester = $values[4];
    $seatstaken = $values[5];
    $maxseats = $values[6];
    
    echo("<tr>".
         "<td>$sid</td><td>$coursenum</td> <td>$title</td> <td>$credits</td> <td>$semester</td>
          <td>$seatstaken</td><td>$maxseats</td>".
         "<td> <a href=\"enroll_confirm.php?sessionid=$sessionid&coursenumber=$coursenum&studentid=$studentid&sid=$sid\">Enroll</a></td>".
         "</tr>");
}
echo("</center></table>");
echo("<center>");
echo("<br><br>");
echo("<form method=\"post\" action=\"enroll.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
echo("<br><br>");

?>
