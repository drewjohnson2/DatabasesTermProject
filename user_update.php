<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

if(!isset($_POST["update_fail"]))
{
	$clientid = $_GET["clientid"];
	
	$sql = "select * from myclient where clientid = '$clientid'";

	$result_array = execute_sql_in_oracle($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if($result == false)
	{
		display_oracle_error_message($cursor);
		die("query failed");
	}
	
	$values = oci_fetch_array($cursor);

	$clientid = $values[0];
	$password = $values[1];
	$clienttype = $values[2];	
}

else
{
	$clientid = $_POST["clientid"];
	$password = $_POST["password"];
	$clienttype = $_POST["clienttype"];
}

echo("<center>
  <form method=\"post\" action=\"user_update_action.php?sessionid=$sessionid\">
  Client ID (Read-only): <input type=\"text\" readonly value = \"$clientid\" size=\"10\" maxlength=\"10\" name=\"clientid\"> <br /> 
  Password: <input type=\"text\" value = \"$password\" size=\"20\" maxlength=\"30\" name=\"password\">  <br />
  ");

echo("
  Account Type (Required):
  <select name=\"clienttype\">
  <option value=\"\">Choose One:</option>
  ");

echo("<option value=\"admin\">Admin</option>");
echo("<option value=\"sadmin\">Student Admin</option>");
echo("<option value=\"student\">Student</option>");


echo("</select>
  <input type=\"submit\" value=\"Update\">
  </form></center>");


?>
