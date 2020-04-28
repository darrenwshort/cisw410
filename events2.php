<?php
//------------------------------------------------------------------------
// file: events.php
// name: darren short
// 
// purpose:
//      This program lists all upcoming events in chronological order.
//      (NOTE: This page is only accessible to administrators of the db)
//
//      The event name listed for each event is "clickable" which will
//      provide even more info about the artist/band/event by calling 
//      the event_band_info.php page passing data via GET string.
//
// input:   event data from concerts db.
// output:  listing of event data in chronological order
//------------------------------------------------------------------------

$title = "Events";
$heading = "Upcoming Events";

include('header.php');
?>

<div class="container">
<div class="heading">
  <h1><?php echo $heading . '!' ; ?></h1>
</div>

<section id="events">
<?php
require_once("dbconnect.php");

// join needed to extract bandName based on bandID keys.
$sql = "SELECT e.eventName, e.eventDesc, e.eventDate, e.ticketPrice, b.bandName
        FROM events e
        INNER JOIN bands b ON e.bandID=b.bandID
        ORDER BY e.eventDate ASC
        ";

$stmnt = $dbc->prepare($sql);
$stmnt->execute();
$results = $stmnt->fetchAll();

$get_string = "";
echo str_repeat("\t", 1) . '<section id="eventListSection">' . "\n";
foreach($results as $event)
{
  echo str_repeat("\t", 2) . '<div class="eventList">' . "\n";
  echo str_repeat("\t", 2) . '<p class="eventItemLabel">Date</p>: <p class="eventItem">' . $event['eventDate'] . "</p>\n";
  $get_string .= "eventDate=" . urlencode($event['eventDate']) . '&';
  $get_string .= "eventName=" . urlencode($event['eventName']) . '&';
  $get_string .= "eventDesc=" . urlencode($event['eventDesc']) . '&';
  $get_string .= "ticketPrice=" . urlencode($event['ticketPrice']) . '&';
  $get_string .= "bandName="  . urlencode($event['bandName']) .  '&';
  echo str_repeat("\t", 2) . '<p class="eventItemLabel">Event</p>: <p class="eventItem"><a class="events" href="event_band_info.php?' . $get_string . '">' . $event['eventName'] . "</a>" . " (<--- click for more info)</p>\n";
  echo str_repeat("\t", 2) . '<p class="eventItemLabel">Event Description</p>: <p class="eventItem">' . $event['eventDesc'] . "</p>\n";
  echo str_repeat("\t", 2) . '<p class="eventItemLabel">Ticket Price</p>: <p class="eventItem">$' . $event['ticketPrice'] . "</p>\n";
  echo str_repeat("\t", 2) . '</div>' . "\n\n";
}
echo str_repeat("\t", 1) . "</section>\n";
?>
</section>
</div>

<?php
include('footer.php')
//----------------------------- END OF PROGRAM -----------------------------/
?>