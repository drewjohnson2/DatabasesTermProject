<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

echo("<center>Password changed successfully!<br>");
echo("</br>");
 echo("
    <form method=\"post\" action=\"studentpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
?>

