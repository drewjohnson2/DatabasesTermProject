<?
include "utility_functions.php";
$sessionid =$_GET["sessionid"];
verify_session($sessionid);

echo("<center>
  <h3>Search</h3>
  <form method=\"post\" action=\"student_grades.php?sessionid=$sessionid\">
  First Name: <input type=\"text\" size=\"10\" maxlength=\"30\" name=\"q_fname\">
  ");
echo("
  Last Name: <input type=\"text\" size=\"10\" maxlength=\"30\" name=\"q_lname\">
  ");
echo("
     Student ID: <input type=\"text\" size=\"10\" maxlength=\"30\" name=\"q_sid\">
");
echo("
  <input type=\"submit\" value=\"Search\">
  </form><br><br>

  ");


$q_fname = $_POST["q_fname"];
$q_lname = $_POST["q_lname"];
$q_sid = $_POST["q_sid"];
$convert = (int)$q_sid;

if($sid == "" and $fname == "" and $lname == "")
{
    $sql = "select * from studentinfo";
}

if($q_sid != "" and $q_fname == "" and $q_lname == "")
{
    $sql = "select * from studentinfo where studentid = $convert";
}

if($q_sid == "" and $q_fname != "" and $q_lname == "")
{
    $sql = "select * from studentinfo where first_name like '%$q_fname%'";
}

if($q_sid == "" and $q_fname == "" and $q_lname != "")
{
    $sql = "select * from studentinfo where last_name like '%$q_lname%'";
}

if($q_sid != "" and $q_fname != "" and $q_lname == "")
{
    $sql = "select * from studentinfo where studentid = $convert and 
    	    first_name like '%$q_fname%'";
}

if($q_sid != "" and $q_fname == "" and $q_lname != "")
{
    $sql = "select * from studentinfo where studentid = $convert and
	    last_name like '%$q_lname%'";
}

if($q_sid == "" and $q_fname != "" and $q_lname != "")
{
    $sql = "select * from studentinfo where first_name like '%$q_fname%' and 
            last_name like '%$q_lname%'";
}

if($q_sid != "" and $q_fname != "" and $q_lname != "")
{
    $sql = "select * from studentinfo where first_name like '%$q_fname%' and 
            last_name like '%$q_lname%' and studentid = $convert";
}

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

echo "<center><table border=1>";
echo("<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Age</th><th>Address</th>
          <th>Student Type</th><th>Status</th><th>Client ID</th></tr>");

while ($values = oci_fetch_array ($cursor)){
    $sid = $values[0];
    $fname = $values[1];
    $lname = $values[2];
    $age = $values[3];
    $address = $values[4];
    $stype = $values[5];
    $status = $values[6];
    $clientid = $values[7];

    echo("<tr><td>$sid</td><td>$fname</td><td>$lname</td><td>$age</td><td>$address</td>
              <td>$stype</td><td>$status</td><td>$clientid</td>
              <td><a href=\"add_grades.php?sessionid=$sessionid&sid=$sid\">Edit Grades</a></td></tr>");

}

echo("</table>");

echo("<center>");
echo("<br /> <br />");
echo("<form method=\"post\" action=\"adminpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  </center>");
?>
