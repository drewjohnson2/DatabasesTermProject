<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
$sid = $_GET["sid"];
$studentid = $_GET["studentid"];


verify_session($sessionid);
echo("<center><h3>Add Grade<h3></center><br>");
echo("<center>
  <form method=\"post\" action=\"grade_add_action.php?sessionid=$sessionid&sid=$sid&studentid=$studentid\">
  Grade (Required):
  <select name=\"grade\">
  <option value=\"\">Choose One:</option>
  ");
echo("<option value=\"4\">A</option>");
echo("<option value=\"3\">B</option>");
echo("<option value=\"2\">C</option>");
echo("<option value=\"1\">D</option>");
echo("<option value=\"0\">F</option>");

echo("</select>
  <input type=\"submit\" value=\"Add\">
  </form></center>");
?>
