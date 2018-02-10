<?
include "utility_functions.php";

$sessionid = $_GET["sessionid"];
verify_session($sessionid);
$studentid = $_GET["studentid"];
$sid = $_GET["sid"];
$cnum = $_GET["coursenumber"];

echo("<center><p>Are you sure you want to enroll in </center> </p>");
echo("<br>");

$sql = "select course.coursenum, coursesection.sectionid, course.title, coursesection.semester
        from coursesection join course on coursesection.coursenum = course.coursenum
	where coursesection.sectionid = $sid";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    display_oracle_error_message($cursor);
    die("query failed");
}

$values = oci_fetch_array($cursor);

echo("<center><p>$values[0] $values[1] $values[2]</center></p>");
echo("<br>");
echo("<center><p>for $values[3]?</center></p>
");

echo("<center>
  <form method=\"post\" action=\"enroll_action.php?sessionid=$sessionid&coursenumber=$cnum&studentid=$studentid&sid=$sid\">
  <input type=\"submit\" value=\"Enroll\">
  </form></center>");


?>

