<?php
//------------------------------------------------------------------------
// file: admin_addeventform.php
// name: darren short
// 
// purpose:
//      This program displays the form to receive event data from the user
//      and add it to the events table in the concert db.
//      (NOTE: This page is only accessible to administrators of the db)
//
//      All fields in the form are required for successfull db insertion.
//
//      If any fields are missing, a message is displayed to the user, 
//      listing the missing, required fields.
//
//      If all fields are populated on submission, a message of successful
//      event addition is displayed.  Links are provided to either enter a
//      new event entry -or- go back to the main admin page.
//
// input:   event data from the user/admin.
// output:  error message on incomplete filling of data form fields OR
//          message of entry addition, upon success.
//------------------------------------------------------------------------
$title = $heading = "Add New Event";
$refill_fields = array();
$GLOBALS['javascript'] = '';

include('admin_header.php');

function populate_existing_fields()
{
  if(!empty($_GET))
  { 
    echo "<br><br>\n";
    echo '<!-- javascript -->'."\n";

    $GLOBALS['javascript'] = "<script type='text/javascript'>\n";  // begin javascript build

    foreach($_GET as $name => $val)
    {
      $decoded_val = urldecode($val); // decode values before re-filling fields.
      if($name == "focus")
      {

        $GLOBALS['javascript'] .= "document.getElementById('$val').focus();\n";
      }
      else
      {
        $GLOBALS['javascript'] .= "document.getElementById('$name').value = '$decoded_val';\n";
      }
    } 
    $GLOBALS['javascript'] .= '</script>';
    echo "\n";
  };
  echo $GLOBALS['javascript'];  // write javascript to event form page.
}
?>

<div id="grid-wrapper">
<form method="post" action="admin_addevent.php" id="addevent_form">

  <label for="eventname">Event Name:</label>
  <input type="text" name="eventname" id="eventname">

  <label for="eventdate">Event Date:
        <div class="formatlabeltext">(format: YYYY-MM-DD HH:MM:SS)</div>
  </label>
  <input type="text" name="eventdate" id="eventdate">

  <label for="eventdesc" id="eventdesclabel">Event Description:
        <div class="formatlabeltext">(max: 2500 characters)</div>
  </label>
  <textarea name="eventdesc" id="eventdesc" rows="10" maxlength="2500"></textarea>

  <label for="eventband" id="eventbandlabel">Band:</label>
  <input type="text" name="eventband" id="eventband">

  <label for="ticketprice">Ticket Price:</label>
  <input type="text" name="ticketprice" id="ticketprice">

  <p>&nbsp;</p>
  <p class="addevent_btn">
    <button type="submit">Insert Data</button>
  </p>

</form>
</div>

<?php 
  populate_existing_fields();  // when error on initial form submittal, re-populate fields with valid data
  include('admin_gobacktomainmenulink.php');
  include('admin_footer.php');
  //---------------------------- END OF PROGRAM -----------------------------
?>
