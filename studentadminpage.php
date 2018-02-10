<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Here we can generate the content of the welcome page
echo("<center>Student Admin: <br />");
echo("<UL>
  <LI><A HREF=\"studentpage.php?sessionid=$sessionid\">Your student page</A></LI>
  <LI><A HREF=\"adminpage.php?sessionid=$sessionid\">Your admin page</A></LI>
  </UL>");

echo("<br />");
echo("<br />");
echo("Click <A HREF = \"logout_action.php?sessionid=$sessionid\">here</A> to Logout.</center>");
?>
