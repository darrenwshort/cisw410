<?php
$heading = "Delete record - bands table";
include("admin_header.php");

if(isset($_GET))
{
  $param = [];
  foreach($_GET as $key => $val)
  {
    if($val != "")
    {
      $param[$key] = urldecode($val);
    }
    else
    { 
      $err[] = "no value set for " . $key;
    }
  }
}

if(empty($err))
{
  require_once("dbconnect.php");
  $sql = "DELETE FROM bands WHERE bandID = :bandID";
  $stmnt = $dbc->prepare($sql);
  $stmnt->bindValue(":bandID", $param['bandID']);
  
  if ($stmnt->execute()) {
    echo "<h2>Band *" . $param['bandName'] . "* successfully deleted from bands table.</h2>"; 
  }
  else {
    echo "<p>* There were errors attempting to delete the record *</p>";
  }
}
include('admin_gobacktomainmenulink.php');
include("admin_footer.php");

?>