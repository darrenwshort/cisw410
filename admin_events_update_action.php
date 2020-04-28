<?php
$heading = $title = "Update record - 'events' table";
include("admin_header.php");
include('admin_gobacktomainmenulink.php');
require_once("dbconnect.php");


/***********************************************************/
/************************ FUNCTIONS ************************/
/***********************************************************/

/**********************  ************************/
function bandExistsInTable($bname)
{
  echo "<h2>I am in bandExistsInTable FN</h2><br>";
  global $dbc;
  $bandExists = 0;
  $bname = prepStrForDb($bname); // clean up band name
  echo "<h2>band name after massage: " . $bname . "</h2>";
  $stmnt = $dbc->prepare("SELECT `bandID`, `bandName` FROM bands WHERE bandName = :bandName");
  $stmnt->bindValue(":bandName", $bname);
  $stmnt->execute();

  echo "<h2>band name: " . $bname . "</h2>";

  if(isset($stmnt) && $row = $stmnt->fetch())
  {
    echo "<h1>****BAND: " . $row['bandID'] . "</h1>";
    return ["bandExists" => 1 , "bandID" => $row['bandID']];
  }
  else
  {
    return ["bandExists" => 0]; // does not exist yet.
  }
}

/************************  *************************/
function getBandIdByName($bname)
{
	global $dbc;
	$bid = null;
	$stmnt = $dbc->prepare("SELECT `bandID` FROM bands WHERE bandName = :bname");
	$stmnt->bindValue(":bname", $bname);
	$stmnt->execute();
	while($row = $stmnt->fetch())
	{
		$bid = $row['bandID'];
	}
	return $bid;
}

/********************  ************************/
function insertBandIntoTable($bname)
{
  global $dbc;
  $cname = prepStrForDb($bname);
  $bid = null;

  $sql = "INSERT INTO `bands` (bandName) VALUES (:bname)";
  $stmnt = $dbc->prepare($sql);
  
  $stmnt->bindValue(":bname", $bname);
  $stmnt->execute();

  $bid = getBandIdByName($bname);
  echo "<h1>" . $bid . "</h1>";
  return $bid;
}

/***********************  ***********************/
function prepStrForDb($str)
{
  $str = strtolower($str);
  $str = ucwords($str);
  return $str;
}

/*********************   *********************/
function squeezeStr($str)
{
  $str = strtolower($str);
  str_replace(" ", "", $str);
  return $str;
}
/***********************************************************/
/********************** END FUNCTIONS **********************/
/***********************************************************/



/***********************************************************/
/************************ MAIN *****************************/
/***********************************************************/

// grab parameters/values from post.
if(isset($_POST['eventName']))
{
    $err = array();
    $param = array();

    if($_POST['eventName'] != "")
    {
      $bn = $_POST['eventName'];
      $param['eventName'] = $bn;
    }
    else
    {
      $err[] = "You need to enter an event name.";
    }

    if($_POST['eventDate'] != "")
    {
      $ed = $_POST['eventDate'];
      $param['eventDate'] = $ed;
    }
    else
    {
      $err[] = "You need to enter a valid event date.";
    }

    // no else clause, as there will always be an event ID passed via post.
    if($_POST['eventID'] != "")
    {
      $eid = $_POST['eventID'];
      $param['eventID'] = $eid;
    }

    if($_POST['eventDesc'] != "")
    {
      $ed = $_POST['eventDesc'];
      $param['eventDesc'] = $ed;
    }
    else
    {
      $err[] = "You need to enter an event description.";
    }

    if($_POST['bandName'] != "")
    {
      $bn = $_POST['bandName'];
      $param['bandName'] = $bn;
    }
    else
    {
      $err[] = "You need to enter band name.";
    }

    if($_POST['ticketPrice'] != "")
    {
      $tp = $_POST['ticketPrice'];
      $param['ticketPrice'] = $tp;
    }
    else
    {
      $err[] = "You need to enter a ticket price.";
    }


} // end of if(isset())

  echo "<br><br>Param:<br>";
  print_r($param);
  echo "<br><br>POST:<br>";
  print_r($_POST);
  echo "<br><br>";

if(empty($err))
{
  $bandExistsAlready  = bandExistsInTable($param['bandName']); // returns array 
  echo "<h2>DID PRINT_R SHOW DATA DUMP???</h2>";
  print_r($bandExistsAlready);
  $new_update_data = [];

  foreach($param as $k => $v)
  {
    $new_update_data[$k]  = $v;
  }

  if($bandExistsAlready["bandExists"] == 0) // band DOES NOT exist in table yet
  {
    $bandName = prepStrForDb($param['bandName']);
    $new_update_data['bandName'] = $bandName;
    $new_update_data['bandID'] = insertBandIntoTable($bandName);
  }
  else // band already exists
  {
    $new_update_data['bandID'] = $bandExistsAlready['bandID'];
    

  }


  echo "<br><br>";
  print_r($new_update_data);
  echo "<br><br>";

  $sql= "UPDATE events
         SET    eventName=:eventName,
                eventDate=:eventDate,
                eventDesc=:eventDesc,
                bandID=:bandID,
                ticketPrice=:ticketPrice,
         WHERE  eventID=:eventID";
  
  $sql_update = $dbc->prepare($sql);
  $sql_update->bindValue(":eventName",    $new_update_data['eventName']);
  $sql_update->bindValue(":eventDate",    $new_update_data['eventDate']);
  $sql_update->bindValue(":eventDesc",    $new_update_data['eventDesc']);
  $sql_update->bindValue(":bandID",       $new_update_data['bandID']);
  $sql_update->bindValue(":ticketPrice",  $new_update_data['ticketPrice']);
  $sql_update->bindValue(":eventID",      $new_update_data['eventID']);
  $sql_update->execute();

}
else
{
  foreach($err as $err_msg)
  {
    echo "\n";
    echo '<div class="centeredcontainer">' . "\n";
    echo '<p id="err">* ' . $err_msg . '</p>' . "\n";
    echo '<button onClick="javascript:window.history.back();">Go Back</button>' . "\n";
    echo '</div>';
  }
}
include('admin_gobacktomainmenulink.php');
include("admin_footer.php");
?>