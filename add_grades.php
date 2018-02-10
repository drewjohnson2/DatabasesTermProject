<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$studentid = $_GET["sid"];

$sql = "select a.sectionid, b.coursenum, b.title, a.semester, b.credits
        from coursesection a, course b, studentcourse c
        where a.sectionid = c.sectionid
        and a.coursenum = b.coursenum
        and studentid = $studentid
        and grade is NULL";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}
echo("<br><br>");
echo("<center><h3>Classes this student is enrolled in</h3></center>");

echo "<center><table border=1>";
echo "<tr> <th>Section ID</th> <th>Course Number</th> <th>Title</th> <th>Semester</th><th>Credits</th></tr>";
  // Fetch the result from the cursor one by one
  while ($values = oci_fetch_array ($cursor)){
    $sid = $values[0];
    $cnum = $values[1];
    $title = $values[2];
    $semester = $values[3];
    $credits = $values[4];

    echo("<tr>".
         "<td>$sid</td> <td>$cnum</td> <td>$title</td> <td>$semester</td> <td>$credits</td>".
         "<td><a href=\"add_grades_confirm.php?sessionid=$sessionid&sid=$sid&studentid=$studentid\">
          Edit Grade</a></td>
	 </tr>");

}

echo("</table>");
echo("<center>");
echo("<br /> <br />");
echo("<form method=\"post\" action=\"adminpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  </center>");
?>
