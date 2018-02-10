<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

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

$sql = "select studentid, first_name, last_name, age, address, student_type, sstatus from studentinfo
        where clientid='$clientid'";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if($value = oci_fetch_array ($cursor))
{
        oci_free_statement($cursor);
        $sid = $value[0];
        $fname = $value[1];
        $lname = $value[2];
	$age = $value[3];
	$address = $value[4];
	$studenttype = $value[5];
	$status = $value[6];

        echo("<table border=1 align=center>");
        echo("<tr> <th>ID</th> <th>First</th><th>Last</th>
	      <th>Age</th><th>Address</th><th>Student Type</th> <th>Status</th></tr>");
	echo("<tr> <td>$sid</td> <td>$fname</td><td>$lname</td>
              <td>$age</td><td>$address</td><td>$studenttype</td> <td>$status</td></tr>");
        echo("</table>");
}
  echo("<center>");
  echo("<br><br>");
  echo("<form method=\"post\" action=\"studentpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
  echo("</center>");

?>

