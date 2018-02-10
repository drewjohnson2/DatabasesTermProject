<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

echo("<center>Old password incorrect!<br>");
echo("</br>");
 echo("
    <form method=\"post\" action=\"change_pass.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
?>

