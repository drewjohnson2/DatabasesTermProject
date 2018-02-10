<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

$sql = "select clientid from myclientsession where sessionid = '$sessionid'";

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

$sql = "select studentid from studentinfo where clientid = '$clientid'";

$result_array = execute_sql_in_oracle($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if($result == false)
{
    display_oracle_error_message($cursor);
    die("query failed");
}

$values = oci_fetch_array($cursor);

$studentid = $values[0];

/*
// Get the values of the record to be inserted.
$clientid = $_POST["clientid"];
if($clientid == "") die("Field 'Client ID' cannot be blank");
$pass = $_POST["pass"];
if($pass == "") die("Field 'Password' cannot be blank");
$clienttype = $_POST["clienttype"];
if($clienttype == "") die("Field 'Client Type' cannot be blank");
*/
echo("<center>
  <h3>Search</h3>
  <form method=\"post\" action=\"enroll.php?sessionid=$sessionid\">
  Course Name: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_coursename\">
  ");
echo("
  Course Number: <input type=\"text\" size=\"10\" maxlength=\"10\" name=\"q_coursenum\">
  ");

echo("
  <input type=\"submit\" value=\"Search\">
  </form><br><br>

  ");

$q_coursename = $_POST["q_coursename"];
$q_coursenum = $_POST["q_coursenum"];
$convert = (int)$q_coursenum;

if($title == "" and $cnum == "")
{
    $query = "select * from offered_courses";
}

if($q_coursename != "" and $q_coursenum == "")
{
    $query = "select * from course where title like '%$q_coursename%'";
}

if($q_coursename == "" and $q_coursenum != "")
{
    $query = "select * from course where coursenum = $convert";
}

if($q_coursename != "" and $q_coursenum != "")
{
    $query = "select * from course where coursenum like %$q_coursenum% and 
            title like '%$q_coursename%'";
}

$result_array = execute_sql_in_oracle($query);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

echo "<center><table border=1>";
echo "<tr><th>Course Number</th> <th>Title</th> <th>Credits</th><th>Sections</th> </tr>";
  // Fetch the result from the cursor one by one
  while ($values2 = oci_fetch_array ($cursor)){
    $cnum = $values2[0];
    $title = $values2[1];
    $credits = $values2[2];
    
    echo("<tr>". 
         "<td>$cnum</td> <td>$title</td> <td>$credits</td>".
         "<td> <a href=\"section_enroll.php?sessionid=$sessionid&studentid=$studentid&cnum=$cnum\">View</a></td>".
         "</tr>");
}
echo("</center></table>");
echo("<center>");
echo("<br><br>");
echo("<form method=\"post\" action=\"studentpage.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>");
echo("</center>");
echo("<br><br>");

oci_free_statement($cursor);
?> 
