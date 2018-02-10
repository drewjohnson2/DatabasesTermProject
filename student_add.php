<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Get values for the record to be added if from emp_add_action.php
$clientid = $_POST["clientid"];
$pass = $_POST["pass"];
$clienttype = $_POST["clienttype"];

echo("<center>
  <form method=\"post\" action=\"student_add_action.php?sessionid=$sessionid\">
  Client ID (Required): <input type=\"text\" value = \"$clientid\" size=\"10\" 
  maxlength=\"10\" name=\"clientid\"> <br /> 
  Password (Required): <input type=\"text\" value = \"$pass\" size=\"20\" 
  maxlength=\"30\" name=\"pass\">  <br />
  First Name (Required): <input type=\"text\" value = \"$fname\" size=\"20\"
  maxlength=\"30\" name=\"fname\"> <br>
  Last Name (Required): <input type=\"text\" value = \"$lname\" size=\"20\"
  maxlength=\"30\" name=\"lname\"> <br> 
  Age (Required): <input type=\"text\" value = \"$age\" size=\"20\"
  maxlength=\"30\" name=\"age\"> <br> 
  Address (Required): <input type=\"text\" value = \"$address\" size=\"30\"
  maxlength=\"50\" name=\"address\"> <br>
  ");

$sql = "select distinct clienttype from myclient order by clienttype";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Query Failed.");
}

echo("
  Account Type (Required):
  <select name=\"clienttype\">
  <option value=\"\">Choose One:</option>
  ");

echo("<option value=\"admin\">Admin</option>");
echo("<option value=\"sadmin\">Student Admin</option>");
echo("<option value=\"student\">Student</option></select>");
echo("<br>");

echo("
  Student Type (Required):
  <select name=\"stype\">
  <option value=\"\">Choose One:</option>
  ");

echo("<option value=\"Undergraduate\">Undergraduate</option>");
echo("<option value=\"Graduate\">Graduate</option>");

echo("</select>
  <input type=\"submit\" value=\"Add\">
  </form></center>");
?>
