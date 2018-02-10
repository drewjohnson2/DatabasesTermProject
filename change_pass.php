<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$oldpass = $_POST["oldpass"];
$newpass = $_POST["newpass"];

echo("<center>");
echo("<form method=\"post\" action=\"change_pass_action.php?sessionid=$sessionid\">
  Current Password: <input type=\"password\" value = \"$oldpass\" size=\"11\" maxlength=\"11\" name=\"oldpass\"> <br /> 
  New Password: <input type=\"password\" value = \"$newpass\" size=\"20\" maxlength=\"30\" name=\"newpass\">  <br />");
  echo("<br><br>");
  echo("<form><input type=\"submit\" value=\"Change\">
  </form>
    <form method=\"post\" action=\"studentpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
?>
