<?php
//------------------------------------------------------------------------
// file: events.php
// name: darren short
// 
// purpose:
//      This program lists all upcoming events in chronological order.
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
require_once("dbconnect.php");
?>

<div class="container">
<div class="heading">
  <p><?php echo $heading . '!' ; ?></p>
</div>

  
<?php

// display single event.
if(isset($_GET['eventName']) && $_GET['eventName'] != "" && 
   isset($_GET['search'])    && $_GET['search'] != "") 
{
  $eventName = urldecode($_GET['eventName']);
  $search    = urldecode($_GET['search']);

  $searchcriteria[] = $eventName;
  $searchcriteria[] = $search;

  // join needed to extract bandName based on bandID keys.
  $sql = "SELECT e.eventName, e.eventDesc, e.eventDate, b.bandName, e.ticketPrice
          FROM events e
          INNER JOIN bands b ON e.bandID = b.bandID
          WHERE e.eventName = " . "'" . addslashes($eventName) . "'";
          
          // echo "<h2>" . $sql . "</h2>\n";

  $query = $dbc->prepare($sql);
  $query->execute();
  // var_dump($query->fetchAll());

  // remove trailing ',' - strictly to tighten up look
  $searchcriteria = preg_replace('/^(.+),\s*/', '$1', $searchcriteria);

  echo "<div class=\"searchcriteria\">\n";

  // process unique values and wrap in span tags for underline decoration.
  foreach(array_unique($searchcriteria) as $i) {
      $results[] = "<span class=\"underline\">" . $i . "</span>";
  }

  echo "\t<p class=\"searchcriteriap\">Search Criteria: " . join(" , ", $results) . "</p>\n";
  echo "</div>\n";

  if(isset($query)) {
    echo "<h2 class=\"italicize\">-- " . $query->rowCount() . " result(s) found --</h2>\n";
  }

  echo "<div class=\"eventslist\">\n";
  echo "<div class=\"eventslistheader\">\n";
  echo "\t<div class=\"eventsheadercol\">Date</a></div>\n";
  echo "\t<div class=\"eventsheadercol\">Event</a></div>\n";
  echo "\t<div class=\"eventsheadercol\">Description</a></div>\n";
  echo "\t<div class=\"eventsheadercol\">Band</a></div>\n";
  echo "\t<div class=\"eventsheadercol\">Ticket Price($)</a></div>\n";
  echo "</div>\n";
  
}
// not specific to one event; specific to search term.
elseif(isset($_GET['orderBy']) && ($_GET['orderBy'] != "") &&
      (isset($_GET['order']))  && ($_GET['order']   != ""))
{
  $orderBy = urldecode($_GET['orderBy']);
  $order   = urldecode($_GET['order']);
  
  
  if(!isset($_GET['order']) || $_GET['order'] == "") {
    $order = 'ASC';
  }
  elseif($_GET['order'] == 'ASC') {
    $order = 'DESC';
  }
  else { $order = 'ASC'; }

  // determine table; band or events.
  $table = (preg_match('/band/', $orderBy)) ? 'b' : 'e';

  $sql = "SELECT e.eventName, e.eventDesc, e.eventDate, b.bandName, e.ticketPrice
          FROM events e
          INNER JOIN bands b ON e.bandID = b.bandID
          ORDER BY " . $table.'.'.$orderBy . " " . $order;

  $query = $dbc->prepare($sql);
  $query->execute();

  // var_dump($query->fetchAll());

  if(isset($query)) {
    echo "<h1 class=\"italicize\">(" . $query->rowCount() . " results found)</h1>\n";
  }

  echo "<div class=\"eventslist\">\n";
  echo "<div class=\"eventslistheader\">\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventDate&order=" . urlencode($order) .  "\">Date</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventName&order=" . urlencode($order) .  "\">Event</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventDesc&order=" . urlencode($order) .  "\">Description</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=bandName&order=" . urlencode($order) . "\">Band</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=ticketPrice&order=" . urlencode($order) .  "\">Ticket Price($)</a></div>\n";
  echo "</div>\n";

}
else // list ALL events
{
  if(!isset($_GET['order']) || $_GET['order'] == "" || $_GET['order'] == "DESC") {
      $order = 'ASC';
  }elseif($_GET['order'] == "ASC"){
      $order = 'DESC';
  }

  $orderBy = 'eventDate';

  $sql = "SELECT e.eventName, e.eventDesc, e.eventDate, b.bandName, e.ticketPrice
          FROM events e
          LEFT JOIN bands b ON e.bandID = b.bandID
          ORDER BY e.eventDate " . $order;

  $query = $dbc->prepare($sql);
  $query->execute();

  if(isset($query)) {
    echo "<h1 class=\"italicize\">(" . $query->rowCount() . " results found)</h1>\n";
  }

  echo "<div class=\"eventslist\">\n";
  echo "<div class=\"eventslistheader\">\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventDate&order=" . urlencode($order) .  "\">Date</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventName&order=" . urlencode($order) .  "\">Event</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=eventDesc&order=" . urlencode($order) .  "\">Description</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=bandName&order=" . urlencode($order) . "\">Band</a></div>\n";
  echo "\t<div class=\"eventsheadercol\"><a class=\"bandhref\" href=\"events.php?orderBy=ticketPrice&order=" . urlencode($order) .  "\">Ticket Price($)</a></div>\n";
  echo "</div>\n";

}
// var_dump($query->fetchAll());
?>


  
<?php
  $count=1;
  if(isset($search) && $search != "") {
    $regex = '/(' . $search . ')/i';
  } else {
    $regex = NULL;
  }

  while($row = $query->fetch())
  {
    // var_dump($row);
      $replacement = '<span class="eventsspan">$1</span>';

      echo ($count % 2 == 0) ? "<div class='eventsroweven'>\n" : "<div class='eventsrowodd'>\n";
      echo "\t<div class='eventscol'>";
      echo (isset($regex)) ? preg_replace($regex, $replacement, $row['eventDate']) : $row['eventDate'];
      echo "</div>\n";
      echo "\t<div class='eventscol'>";
      echo (isset($regex)) ? preg_replace($regex,$replacement,$row['eventName']) : $row['eventName'];
      echo "</div>\n";
      echo "\t<div class='eventscol'>";
      echo (isset($regex)) ? preg_replace($regex,$replacement,$row['eventDesc']) : $row['eventDesc'];
      echo "</div>\n";
      echo "\t<div class='eventscol'>";
      echo (isset($regex)) ? preg_replace($regex,$replacement,$row['bandName']) : $row['bandName'];
      echo "</div>\n";
      echo "\t<div class='eventscol'>";
      echo (isset($regex)) ? preg_replace($regex,$replacement,$row['ticketPrice']) : $row['ticketPrice'];
      echo "</div>\n";
      echo "</div>\n";
      $count++;
  }
?>
  </div> <!-- class=eventlist -->
</div> <!-- class="container" -->

<?php
include('footer.php')
//----------------------------- END OF PROGRAM -----------------------------/
?>