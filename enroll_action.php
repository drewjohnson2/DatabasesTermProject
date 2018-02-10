<?
include "utility_functions.php";

$sessionid = $_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warning.
ini_set("display_errors", 0);

// Obtain information for the record to be updated.
$studentid = $_GET["studentid"];
$sid = $_GET["sid"];
$cnum = $_GET["coursenumber"];

$sql = "select * from coursesection where sectionid = $sid for update";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    die("An error occurred");
}

$sql = "select seatstaken, maxseats from coursesection where sectionid = $sid";
$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    die("An error occurred");
}

$values = oci_fetch_array($cursor);

$seatstaken = $values[0];
$maxseats = $values[1];

if($seatstaken >= $maxseats)
{
    Header("Location:max_students_failure.php?sessionid=$sessionid");
}

$sql = "select count(b.sectionid) from  
	coursesection a, studentcourse b
	where a.sectionid = b.sectionid
	and b.studentid = $studentid
	and a.coursenum = $cnum
	and b.grade is NULL";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    die("An error occurred");
}

$values = oci_fetch_array($cursor);

$inClass = $values[0];

if($inClass > 0)
{
    Header("Location:already_enrolled_failure.php?sessionid=$sessionid");
}

$sql = "select count(b.sectionid) from  
        coursesection a, studentcourse b
        where a.sectionid = b.sectionid
        and b.studentid = $studentid
        and a.coursenum = $cnum
        and b.grade is not NULL";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    die("An error occurred");
}

$values = oci_fetch_array($cursor);

$takenClass = $values[0];

if($takenClass > 0)
{ //HERRREEEEE
    Header("Location:already_taken_failure.php?sessionid=$sessionid");
}

if(!($seatstaken >= $maxseats) && !($inClass > 0) && !($takenClass > 0))
{
    $sql = "update coursesection set seatstaken = seatstaken + 1 where sectionid = $sid";
    $result_array = execute_sql_in_oracle($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

    if($result == false)
    {
        die("An error occurred");
    }


    //if($sid == "") die("Field 'Password' cannot be left blank");

    $sql = "insert into studentcourse(studentid, sectionid) values ($studentid, $sid)";
    $result_array = execute_sql_in_oracle($sql);
    $result = $result_array["flag"];
    $cursor = $result_array["cursor"];

    if ($result == false){

            die("An error occurred");

    }

    // Record updated.  Go back.
    Header("Location:enroll_success.php?sessionid=$sessionid");
}

$sql = "commit";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    die("An error occurred");
}

?>                           
