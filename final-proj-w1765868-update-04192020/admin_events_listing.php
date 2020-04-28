<?php
/*************************************************
 * List all entries from 'events' table, for:
 * 
 * - viewing events records
 * - editing events records
 * - deletion of events records
 * 
 ************************************************/

$title = "View/Update/Delete - events table";
$heading = "View/Update/Delete - <span class='italicize_color'>events</span> table";

require_once("dbconnect.php");
include("header.php");


$sql_events = "SELECT `eventID`, `eventName`, `eventDate`, `eventDesc`, `bandID`, `ticketPrice` 
               FROM events
               ORDER BY `eventDate`";
$query_events = $dbc->prepare($sql_events);
$query_events->execute();
               
$sql_band    = "SELECT `genreID`, `bandName` FROM bands WHERE bandID=:bid";
$sql_genre   = "SELECT `genreName` FROM genre WHERE genreID=:gid";



while($row = $query_events->fetch())
{
    $events[] = [ 'bandID'      =>  $row['bandID'],
                  'eventID'     =>  $row['eventID'],
                  'eventName'   =>  $row['eventName'],
                  'eventDate'   =>  $row['eventDate'],
                  'eventDesc'   =>  $row['eventDesc'],
                  'ticketPrice' =>  $row['ticketPrice'] 
              ];
}
?>

<div class="container">
<div class="admin_header"><?php echo $heading; ?></div>
<div class="centeredcontainer">
<form class="admin_list">
<table>
  <th>Event Date</th><th>Event</th><th>Event Description</th><th>Band</th>
  <th>Genre</th><th>Ticket (US $)</th><th>Update</th>

<?php
$row_count = 0;
foreach($events as $event)
{
  $get_string ='';
  echo "<tr>\n";
  echo ($row_count % 2 == 0) ? "<tr class='even'>\n" : "<tr class='odd'>\n";
  echo "<td>".$event['eventDate']."</td><td>".$event['eventName']. "</td><td class='td-event-date'>".substr($event['eventDesc'], 0,45)."...</td>";

  // start to build GET string for action page.
  $get_string .= 'eventID='   . urlencode($event['eventID'])   . '&';
  $get_string .= 'eventDate=' . urlencode($event['eventDate']) . '&';
  $get_string .= 'eventName=' . urlencode($event['eventName']) . '&';
  $get_string .= 'eventDesc=' . urlencode($event['eventDesc']) . '&';

  $query_band = $dbc->prepare($sql_band);
  $query_band->bindValue(':bid', $event['bandID']);
  $query_band->execute();

  $gid = 0;
  while($row = $query_band->fetch())
  {
    $gid = $row['genreID'];
    echo "<td>".$row['bandName']."</td>";
    $get_string .= 'bandName=' . urlencode($row['bandName']) . '&';
  }

  // get genre name from genre ID.
  $query_genre = $dbc->prepare($sql_genre);
  $query_genre->bindValue(':gid', $gid);
  $query_genre->execute();

  while($row = $query_genre->fetch())
  {
    echo "<td>" . $row['genreName'] . "</td>";
    $get_string .= 'genreName=' . urlencode($row['genreName']) . '&';
  }

  $get_string .= 'ticketPrice=' . urlencode($event['ticketPrice']) . '&';
  echo "<td>".$event['ticketPrice']."</td><td><a class='admintasks' href='admin_events_update.php?".$get_string."'>View/Edit</a>" . "<span class='pipe'> | </span>";

  // temp disabled 'delete' operation until subsequent assignments.  only focusing on 'update' of events
  // echo "<a class='admintasks' href='admin_events_delete.php'>Delete</a>\n";
  echo "<a class='admintasks' href='#'>Delete</a>\n";
  echo "</tr>\n";
  
  $row_count++;
}
?>

</table>
</form>
</div>


<?php
include('admin_gobacktomainmenulink.php');
include("footer.php")
?>