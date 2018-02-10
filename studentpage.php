<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Here we can generate the content of the welcome page
echo("<center>");
echo("You have reached your student page <br />");

echo("<br />");
echo("View your records (classes you're enrolled in) <a href=\"student.php?sessionid=$sessionid\">here</a>.<br>");
echo("<a href=\"student_information.php?sessionid=$sessionid\">Personal info</a><br>");
echo("<br>");
echo("<a href=\"change_pass.php?sessionid=$sessionid\">Change your password</a> <br>");
echo("<br />");
echo("<a href=\"enroll.php?sessionid=$sessionid\">Enroll</a><br>");
echo("<br />");
echo("Click <A HREF = \"logout_action.php?sessionid=$sessionid\">here</A> to Logout.");
echo("</center>");

?>
