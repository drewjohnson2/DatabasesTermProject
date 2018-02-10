<?
include "utility_functions.php";

$sessionid = $_GET["sessionid"];
verify_session($sessionid);

echo("<center>You've already passed in this class!</center>");

echo("<center>");
echo("<br><br>");
echo("<form method=\"post\" action=\"enroll.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
echo("<br><br>");
?>

