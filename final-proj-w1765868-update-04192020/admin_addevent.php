<?php
//------------------------------------------------------------------------
// file: admin_addevent.php
// name: darren short
// 
// purpose:
//      This program adds event data to the concerts db.
//      (NOTE: This page is only accessible to administrators of the db)
//
//      If a band already exists for the event being added, the
//      band's ID is queried for and only a new event record is
//      added to the events table.
//
//      If the band does not exist, a new record is inserted into
//      the bands table, as well as, a new record inserted into
//      the events table.
//
// input:   data from form fields.
// output:  error message on incomplete filling of data form fields OR
//          message of entry addition, upon success.
//------------------------------------------------------------------------


// insert db connection code
require_once("dbconnect.php");

//------------------ PROCESS FORM SUBMISSION --------------------//
if(isset($_POST['eventname']))
{
    $error = array();
    $data = array();
    if($_POST['eventname'] != "")
    {
        $eventname = $_POST['eventname'];
        $data['eventname'] = $eventname;
    }
    else
    {
        $error[] = "You need to enter an event name.";
    }

    if($_POST['eventdate'] != "")
    {
        $eventdate = $_POST['eventdate'];
        $data['eventdate'] = $eventdate;
    }
    else
    {
        $error[] = "You need to enter an event date.";
    }

    if($_POST['eventdesc'] != "")
    {
        $eventdesc = $_POST['eventdesc'];
        $data['eventdesc'] = $eventdesc;
    }
    else
    {
        $error[] = "You need to enter an event description";
    }

    if($_POST['eventband'] != "")
    {
        $eventband = $_POST['eventband'];
        $data['eventband'] = $eventband;
    }
    else
    {
        $error[] = "You need to enter what band will be performing.";
    }

    if($_POST['ticketprice'] != "")
    {
        $ticketprice = $_POST['ticketprice'];
        $data['ticketprice'] = $ticketprice;
    }
    else
    {
        $error[] = "You need to enter a ticket price for the event.";
    }
}
//------------------ END PROCESS FORM SUBMISSION ---------------------


//-------------------- BEGIN TO DISPLAY PAGE -------------------------
$title = "Add Event";
$heading = "";
include("admin_header.php");
$fields = array("eventname"     => "Event Name",
                "eventdate"     => "Event Date",
                "eventdesc"     => "Event Description",
                "eventband"     => "Band",
                "ticketprice"   => "Ticket Price"
            );



//---------------------------- FUNCTION(S) -----------------------------
function doesBandExistInDb()
{
    global $data, $dbc;
    $band = $data['eventband'];
    $sql = "SELECT bandID, bandName FROM bands WHERE UPPER(bandName) = UPPER(:band)";
    $stmnt = $dbc->prepare($sql);
    $stmnt->bindParam(':band', $band);
    $stmnt->execute();
    $result = $stmnt->fetchAll();

    $row = [];
    if(!empty($result))
    {
        // results should only have 1 row.
        foreach($result as $row)
        {
            $bandID = $row['bandID'];
        }
        return ['exists' => 1, 'bandID' => $bandID]; // band DOES already exist in db.
    }
    else
    {
        return ['exists' => 0, 'bandName' => $band]; // band DOES NOT exist in db, currently.
    }
} // END doesBandExistInDb()

//-------------------------- END FUNCTIONS --------------------------


//----------------------- CONTINUE TO BUILD PAGE --------------------
if(empty($error))   // no errors on form submission; continue with processing of data.
{
    $band_exists_arr = doesBandExistInDb(); // check if band already exists in db.

    // if band already exists in db table.
    if($band_exists_arr['exists']) 
    {
        $sql_insert_event = "INSERT INTO events(eventName, eventDesc, eventDate, ticketPrice, bandID)
                                VALUES(:eventName, :eventDesc, :eventDate, :ticketPrice, :bandID)";
        $stmnt = $dbc->prepare($sql_insert_event);
        $data['bandID'] = $band_exists_arr['bandID'];  // append band_id to $data assoc. array before executing INSERT.

        $stmnt->bindParam(':eventName', $data['eventname']);
        $stmnt->bindParam(':eventDesc', $data['eventdesc']);
        $stmnt->bindParam(':eventDate', $data['eventdate']);
        $stmnt->bindParam(':ticketPrice', $data['ticketprice']);
        $stmnt->bindParam(':bandID', $data['bandID']);
        $stmnt->execute();
    }
    // band does not exist, so INSERT into band table.  Then INSERT event into events table.
    else 
    {   
        // INSERT band name into bands table, in order to create band_id (auto-increment in db).
        $sql_insert_band = "INSERT INTO bands(bandName) VALUES(:bandName)";
        $stmnt = $dbc->prepare($sql_insert_band);
        $stmnt->bindParam(':bandName', $band_exists_arr['bandName']);
        $stmnt->execute();
        
        
        // query for band_id, in order to INSERT into events table.
        $sql_get_band_id = "SELECT `bandID`, `bandName` FROM bands WHERE UPPER(bandName) = :bandName";
        $stmnt = $dbc->prepare($sql_get_band_id);
        $new_band = $band_exists_arr['bandName'];
        $upper_case_band = strtoupper($new_band);
        $stmnt->bindParam(':bandName', $upper_case_band);
        $stmnt->execute();
        $result = $stmnt->fetchAll();

        foreach($result as $row)
        {
            if($row['bandID'] != "")
            {
                $data['bandID'] = $row['bandID']; // append bandID to $data[] for INSERT into events.
            }
        }
        
        $sql_insert_event = "INSERT INTO events(eventName, eventDesc, eventDate, ticketPrice, bandID)
                                VALUES(:eventName, :eventDesc, :eventDate, :ticketPrice, :bandID)";
        $stmnt = $dbc->prepare($sql_insert_event);

        $data_date_prep = $data['eventdate'];
        $stmnt->bindParam(':eventName', $data['eventname']);
        $stmnt->bindParam(':eventDate', $data_date_prep);
        $stmnt->bindParam(':eventDesc', $data['eventdesc']);
        $stmnt->bindParam(':ticketPrice', $data['ticketprice']);
        $stmnt->bindParam(':bandID', $data['bandID']);
        $stmnt->execute();
    }
    
    echo "<div class='centeredcontainer'>";
    echo "<h1>Event entry added!</h1>";
    echo "<a href='admin_addeventform.php'>Add another entry</a>";
    echo "<p>-- or --</p>";
    echo "  <a href='admin_addnewdataform.php'>Go Back To Main Admin Menu</a>";
    echo "</div>";
}
// error[] not empty = there are form errors of some sort
else 
{
    echo "<h1>Oopsie!</h1>";
    echo "<h3>There were errors in your submission.</h3>";

    $message = "";
    foreach($error as $value)
    {
        $message .= "<div class='error_msg'> * $value</div>";
    }
    echo '<h2>' . $message . '</h2><br><br>';


    // begin build of GET string, for redirect.
    $get_string = "";
    foreach($data as $key => $val)
    {
        $get_string .= $key . '=' . urlencode($val) . '&';
    }

    $error_diff = array_diff_key($fields, $data);
    print_r($error_diff);  // $error_diff = data NOT entered
    
    // get first key of assoc. array for input focus on redirect.
    $firstkey = array_key_first($error_diff);
    echo '<h1>KEY DIFF: ' . $firstkey . '</h1>';
    $get_string .= 'focus=' . $firstkey . '&';

    // generate link to return to form, with re-population of fields that had valid values.
    echo '<div>';
    echo '<a href="admin_addeventform.php?' . $get_string . '">Go Back</a>';
    echo '</div>';
}

include("admin_footer.php");

//------------------------ END OF PROGRAM --------------------------
?>
