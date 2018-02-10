<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$clientid = $_GET["clientid"];

$sql = "select * from myclient where clientid = '$clientid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:admin.php?sessionid=$sessionid");
}
oci_free_statement($cursor);

$cid = $values[0];
$pass = $values[1];
$clienttype = $values[2];

echo("
  <form method=\"post\" action=\"user_delete_action.php?sessionid=$sessionid\">
  User ID (Read-only): <input type=\"text\" readonly value = \"$cid\" size=\"10\" maxlength=\"10\" name=\"clientid\"> <br /> 
  Password: <input type=\"text\" disabled value = \"$pass\" size=\"20\" maxlength=\"30\" name=\"pass\">  <br />
  Client type: <input type=\"text\" disabled value = \"$clienttype\" size=\"20\" maxlength=\"30\" name=\"clienttype\">  <br />
  ");

echo("
  <input type=\"submit\" value=\"Delete\">
  </form>

  <form method=\"post\" action=\"admin.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");

?>
