<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);
$connection = oci_connect ("gq010", "wyojlr", "gqiannew2:1521/pdborcl");

if($connection == false)
{
	die("idk dude");
}

echo("<center><h3>Account info</h3></center>");

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

$sql = "select * from myclient
	where clientid='$clientid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($value = oci_fetch_array ($cursor))
{       
	oci_free_statement($cursor);
	$userID = $value[0];
	$password = $value[1];
	$type = $value[2];

	echo("<table border=1 align=center>");
	echo("<tr> <th>Username</th> <th>Password</th> <th>Account Type</th></tr>");
	echo("<tr> <td>$userID</td> <td>$password</td> <td>$type</td></tr>");
	echo("</table>");
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
echo("<center><h3>Classes you've enrolled in</h3></center>");

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
         "</tr>");

}

echo("</center></table>");

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
    
    if($grade >=  0 and $grade < 1)
    {
         $grade = 'F';
    }

    elseif($grade >=1 and $grade < 2)
    {
	$grade = 'D';
    }

    elseif($grade >= 2 and $grade < 3)
    {
	$grade = 'C';
    }

    elseif($grade >= 3 and $grade < 4)
    {
	$grade = 'B';
    }

    else
    {
	$grade = 'A';
    }
    echo("<tr>".
         "<td>$sid</td> <td>$cnum</td> <td>$title</td><td>$semester</td><td>$credits</td>".
         "<td>$grade</td></tr>");

}
echo("</center></table>");
echo("<br><br>");
echo "<center><table border=1>";
echo("<tr><th>Courses Completed</th><th>Total Credits Earned</th><th>GPA</th></tr>");

$sql = "select count(grade) from studentcourse where grade is not null and studentid= $studentid";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

$values = oci_fetch_array($cursor);

$count = $values[0];

$sql = "select sum(a.credits)
from course a, coursesection b, studentcourse c
where a.coursenum = b.coursenum
and b.sectionid = c.sectionid
and c.grade is not null
and studentid = $studentid";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

$values = oci_fetch_array($cursor);

$creditsearned = $values[0];

$sql = "select sum(c.grade) 
        from course a, coursesection b, studentcourse c
        where a.coursenum = b.coursenum
        and b.sectionid = c.sectionid
	and c.grade is not null
	and studentid = $studentid";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

$values = oci_fetch_array($cursor);

$totalgrade = $values[0];

$gpa = ($totalgrade * 3) / $creditsearned;

$sql = "begin
	changeStatus(:gpa, :student);
	end;";

$stmt = oci_parse($connection, $sql);

oci_bind_by_name($stmt, ":gpa", $gpa,40);


oci_bind_by_name($stmt, ":student", $studentid, 40);

oci_execute($stmt);
oci_commit($connection);

echo("<tr><td>$count</td><td>$creditsearned</td><td>$gpa</td></tr>");
echo("</center></table>");



echo("<center>");
echo("<br><br>");
echo("<form method=\"post\" action=\"studentpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");

