<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Here we can generate the content of the welcome page
echo("<center>You have reached your administrator page. <br />");
echo("<br />");
echo("<a href=\"admin.php?sessionid=$sessionid\">View/edit records</a>");
echo("<br />");echo("<br />");
echo("<a href=\"student_add.php?sessionid=$sessionid\">Add Student</a>");
echo("<br />");echo("<br />");
echo("<a href=\"student_grades.php?sessionid=$sessionid\">Student Grades</a>");
echo("<br>");echo("<br />");
echo("Click <A HREF = \"logout_action.php?sessionid=$sessionid\">here</A> to Logout.</center>");
?>
