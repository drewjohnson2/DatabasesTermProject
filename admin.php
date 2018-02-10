<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

/*$sql = "SELECT * FROM myclient order by clientid";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}*/

echo("<center>
  <h3>Search</h3>
  <form method=\"post\" action=\"admin.php?sessionid=$sessionid\">
  Client ID: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_clientid\">
  ");
echo("
  Account Type (Required):
  <select name=\"q_clienttype\">
  <option value=\"\">Choose One:</option>
  ");

echo("<option value=\"admin\">Admin</option>");
echo("<option value=\"sadmin\">Student Admin</option>");
echo("<option value=\"student\">Student</option>");

echo("
  </select>
  <input type=\"submit\" value=\"Search\">
  </form><br><br>

  ");

//echo "<center><table border=1>";
//echo "<tr> <th>Client Id</th> <th>Password</th> <th>Client Type</th></tr>";

$q_clienttype = $_POST["q_clienttype"];
$q_clientid = $_POST["q_clientid"];

if($clientid == "" and $clienttype == "")
{
  $sql = "SELECT * FROM myclient order by clientid";
}

if($q_clientid != "" and $q_clienttype == "")
{
  $sql = "SELECT * FROM myclient where clientid like '%$q_clientid%'";
}

if($q_clienttype != "" and $q_clientid == "")
{
  $sql = "select * from myclient where clienttype = '$q_clienttype'";
}

if($q_clienttype != ""  and $q_clientid != "")
{
  $sql = "select * from myclient where clienttype = '$q_clienttype' and clientid like '%$q_clientid%'";
}

  $result_array = execute_sql_in_oracle($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Client Query Failed.");
  }

  echo "<center><table border=1>";
  echo "<tr> <th>Client Id</th> <th>Password</th> <th>Client Type</th></tr>";
  // Fetch the result from the cursor one by one
  while ($values = oci_fetch_array ($cursor)){
    $clientid = $values[0];
    $pass = $values[1];
    $clienttype = $values[2];
    
    echo("<tr>" . 
         "<td>$clientid</td> <td>$pass</td> <td>$clienttype</td>".
         "<td> <a href=\"user_update.php?sessionid=$sessionid&clientid=$clientid\">Update</a></td>".
         "<td> <A HREF=\"user_delete.php?sessionid=$sessionid&clientid=$clientid\">Delete</A></td>".
         "</tr>");
  
}
oci_free_statement($cursor);

echo("</table>");

echo("<br /> <br />");
echo("<form method=\"post\" action=\"student_add.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>
<form method=\"post\" action=\"adminpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>

</center>");

?>
