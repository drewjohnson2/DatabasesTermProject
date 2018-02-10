<?
include "utility_functions.php";

$sessionid = $_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warning.
ini_set("display_errors", 0);

// Obtain information for the record to be updated.
$clientid = $_POST["clientid"];
$password = $_POST["password"];
$clienttype = $_POST["clienttype"];

if($password == "") die("Field 'Password' cannot be left blank");
if($clienttype == "") die("Field 'client type' cannot be left blank");

$sql = "update myclient set password = '$password', clienttype = '$clienttype' where clientid = '$clientid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
	
	die("An error occurred");

}

// Record updated.  Go back.
Header("Location:admin.php?sessionid=$sessionid");
?>
