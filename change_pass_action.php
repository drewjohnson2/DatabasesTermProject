<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);  

// Get the values of the record to be inserted

$oldpass = $_POST["oldpass"];
$newpass = $_POST["newpass"];

$sql = "Select clientid from myclientsession
        where sessionid='$sessionid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor))
{
    oci_free_statement($cursor);
    $clientid = $values[0];
}

$sql = "select password from myclient
        where clientid = '$clientid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($values = oci_fetch_array ($cursor))
{
    if($values[0] == $oldpass)
    {
        $sql = "update myclient 
                set password = '$newpass'
		where clientid = '$clientid'";

	$result_array = execute_sql_in_oracle($sql);
	$result = $result_array["flag"];
	$cursor = $result_array["cursor"];

	if ($result == false){
  		display_oracle_error_message($cursor);
  		die("Client Query Failed.");
	}
	
	header("Location:success_page.php?sessionid=$sessionid");
    }
    else
    {
	echo("<br>");
	header("Location:fail_page.php?sessionid=$sessionid");
    }
//header("Location:studentpage.php?sessionid=$sessionid");

}
?>

