<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
$sid = $_GET["sid"];
$studentid = $_GET["studentid"];
$connection = oci_connect ("gq010", "wyojlr", "gqiannew2:1521/pdborcl");

verify_session($sessionid);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);

$grade = $_POST["grade"];
if($grade == "") die("Field 'Grade' is required");

$convert = (int)$grade;

$sql = "select * from studentcourse where studentid = $studentid and sectionid = $sid for update";
$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
}

$sql = "update studentcourse set grade = $convert  where studentid = $studentid 
        and sectionid = $sid";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i> 

  <form method=\"post\" action=\"student_add?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"$eid\" name=\"eid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$start_date\" name=\"start_date\">
  <input type=\"hidden\" value = \"$dnumber\" name=\"dnumber\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

$sql = "commit";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
}

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

Header("Location:student_grades.php?sessionid=$sessionid");
?>
