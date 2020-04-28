<?php

$title = "Update record - 'events' table";
$heading = "Update record - <span class='italicize_color'>events</span> table";

include("admin_header.php");
require_once("dbconnect.php");

/***********************************************************/
/************************ FUNCTIONS ************************/
/***********************************************************/

/************************  bandExistsInTable() *************************/
function bandExistsInTable($bname)
{
  global $dbc;
  $bandExists = 0;
  $bname = prepStrForDb($bname); // clean up band name
  $stmnt = $dbc->prepare("SELECT `bandID`, `bandName` FROM bands WHERE bandName = :bandName");
  $stmnt->bindValue(":bandName", $bname);
  $stmnt->execute();

  if(isset($stmnt) && $row = $stmnt->fetch())
  {
    return ["bandExists" => 1 , "bandID" => $row['bandID']];
  }
  else
  {
    return ["bandExists" => 0]; // does not exist yet.
  }
}

/********************** getBandIdByName() **********************/
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

/******************** insertBandIntoTable() ************************/
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
  return $bid;
}

/*********************** prepStrForDb() ***********************/
function prepStrForDb($str)
{
  $str = strtolower($str);
  $str = ucwords($str);
  return $str;
}

/********************* squeezeStr()  *********************/
function squeezeStr($str)
{
  $str = strtolower($str);
  str_replace(" ", "", $str);
  return $str;
}
/***********************************************************/
/********************** END FUNCTIONS **********************/
/***********************************************************/



/**************************************************************/
/*************************** MAIN *****************************/
/**************************************************************/

// $_GET - handles initial view/edit data
if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET))
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
      $err[] = "you must have a value set for " . $key;
    }
  }
  // unset($_GET);

  if(empty($err))
  {
?>

    <div class="admin_header"><?php echo $heading; ?></div>
    <div id="grid-wrapper">
    <form method="post" action="admin_events_update.php" id="admin_update">

      <label for="eventID">Event ID:</label>
      <input type="text" name="eventIDdisabled" id="eventIDdisabled" value=<?php echo "'" . $param['eventID'] . "'"; ?> disabled >
      <input type="hidden" name="eventID" id="eventID" value=<?php echo "'" . $param['eventID'] . "'"; ?>>
      <label for="eventName">Event Name:</label>
      <input type="text" name="eventName" id="eventName" value=<?php echo "\"" . urldecode($param['eventName']) . "\""; ?>>

      <label for="eventDate">Event Date:
            <div class="formatlabeltext">(format: YYYY-MM-DD HH:MM:SS)</div>
      </label>
      <input type="text" name="eventDate" id="eventDate" value=<?php echo "'" . urldecode($param['eventDate']) . "'"; ?>>

      <label for="eventDesc" id="eventDesclabel">Event Description:
            <div class="formatlabeltext">(max: 2500 characters)</div>
      </label>
      <textarea name="eventDesc" id="eventDesc" rows="10" maxlength="2500"><?php echo urldecode($param['eventDesc']); ?></textarea>

      <label for="bandName" id="eventbandlabel">Band:</label>
      <input type="text" name="bandName" id="bandName" value=<?php echo "'" . urldecode($param['bandName']) . "'"; ?>>

      <label for="ticketPrice">Ticket Price:</label>
      <input type="text" name="ticketPrice" id="ticketPrice" value=<?php echo "'" . $param['ticketPrice'] . "'"; ?>>

      <p>&nbsp;</p>
      <p class="admin_form_btn">
        <button type="submit">Update</button> <button onClick="javascript:event.preventDefault();window.history.back();">Cancel / Go Back</button>
      </p>

    </form>
    </div>

  <?php
  }
  else
  {
    foreach($err as $err_msg)
    {
      echo '<div class="container">';
      echo '<p class="err">* ' . $err_msg . "</p>\n";
    }
  }
}

// $_POST - handles any subsequent updates of form data submission
elseif ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST)) 
{
  foreach ($_POST as $key => $val)
  {
    if($val != "")
    {
      $new_update_data[$key] = $val;
    }
    else
    {
      $err[] = "You must have a value set for " . $key;
    }
  }

  // normal processing, if no errors
  if(empty($err))
  {
    $bandExistsAlready  = bandExistsInTable($new_update_data['bandName']); // returns array 

    if($bandExistsAlready["bandExists"] == 0) // band DOES NOT exist in table yet
    {
      $bandName = prepStrForDb($new_update_data['bandName']);
      $new_update_data['bandName'] = $bandName;
      $new_update_data['bandID'] = insertBandIntoTable($bandName);
    }
    else // band already exists
    {
      $new_update_data['bandID'] = $bandExistsAlready['bandID'];
    }

    $sql_update_events = "UPDATE events
                          SET    eventName = :eventName,
                                 eventDate = :eventDate,
                                 eventDesc = :eventDesc,
                                 bandID = :bandID,
                                 ticketPrice = :ticketPrice
                          WHERE  eventID = :eventID";
    
    
    $sql_update = $dbc->prepare($sql_update_events);
    
    $sql_update->bindValue(":eventName",    $new_update_data['eventName']);
    $sql_update->bindValue(":eventDate",    $new_update_data['eventDate']);
    $sql_update->bindValue(":eventDesc",    $new_update_data['eventDesc']);
    $sql_update->bindValue(":bandID",       $new_update_data['bandID']);
    $sql_update->bindValue(":ticketPrice",  $new_update_data['ticketPrice']);
    $sql_update->bindValue(":eventID",      $new_update_data['eventID']);
    $sql_update->execute();

    // after successful update, let user know.
    echo "\n";
    echo '<div class="container">';
    echo '<div class="centeredcontainer">';
    echo '<div class="updateSuccess">';
    echo '<p class="success">Update Successful!</p>';
    echo '</div>';
    echo '</div>';
    echo "\n";

  }
  else
  {
    foreach($err as $err_msg)
    {
      echo "\n";
      echo '<div class="container">';
      echo '<div class="centeredcontainer">' . "\n";
      echo '<p id="err">* ' . $err_msg . '</p>' . "\n";
      echo '<button onClick="javascript:event.preventDefault();window.history.back();">Go Back</button>' . "\n";
      echo '</div>';
    }
  }
} // elseif $_POST...

include('admin_gobacktomainmenulink.php');
include("admin_footer.php");
?>