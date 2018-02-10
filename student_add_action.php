<?
//don't let your dreams be dreams
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);  

// Get the values of the record to be inserted.
$clientid = $_POST["clientid"];
if($clientid == "") die("Field 'Client ID' cannot be blank");
$pass = $_POST["pass"];
if($pass == "") die("Field 'Password' cannot be blank");
$clienttype = $_POST["clienttype"];
if($clienttype == "") die("Field 'Client Type' cannot be blank");
$fname = $_POST["fname"];
if($fname == "") die("Field 'First Name' is required");
$lname = $_POST["lname"];
if($lname == "") die("Field 'Last Name' is required");
$age = $_POST["age"];
if($age == "") die("Field 'age' is required");
$address = $_POST["address"];
if($address == "") die("Field 'Address' is required");
$stype = $_POST["stype"];
if($stype == "") die("Field 'Student Type' is required");


// Form the insertion sql string and run it.
$sql = "insert into myclient values ('$clientid', '$pass', '$clienttype')";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
  
  die("<i> 

  <form method=\"post\" action=\"student_add?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"$eid\" name=\"eid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$start_date\" name=\"start_date\">
  <input type=\"hidden\" value = \"$dnumber\" name=\"dnumber\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

$convert = (int)$age;

$sql = "insert into studentinfo 
        (first_name, last_name, age, address, student_type, sstatus, clientid)
        values('$fname', '$lname', $convert, '$address', '$stype', 'Good Standing', '$clientid')";

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);
  
  die("<i> 

  <form method=\"post\" action=\"student_add?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"$eid\" name=\"eid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$start_date\" name=\"start_date\">
  <input type=\"hidden\" value = \"$dnumber\" name=\"dnumber\">
  
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}


// Record inserted.  Go back.
Header("Location:admin.php?sessionid=$sessionid");
?>
