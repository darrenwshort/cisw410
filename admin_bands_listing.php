<?php
/*************************************************
 * List all entries from bands table, for:
 * 
 * - viewing band records
 * - editing band records
 * - deletion of band records
 * 
 ************************************************/

$title = "View/Update/Delete - bands table";
$heading = 'View/Update/Delete - <span class="italicize_color">bands</span> table';

require_once("dbconnect.php");
include("header.php");

$sql_band = "SELECT `bandID`, `bandName`, `noMembers`, `biography`, `genreID`, `countryID`
             FROM bands";
             
$sql_events = "SELECT e.eventID, e.eventName, e.eventDate, e.eventDesc, b.bandID, b.bandName
               FROM events e 
               INNER JOIN bands b
               ON e.bandID = b.bandID";




// get and process bands
$query_band = $dbc->prepare($sql_band);
$query_band->execute();
while($row = $query_band->fetch())
{
  $bands[$row['bandID']] = [
      'bandName'    => $row['bandName'],
      'noMembers'   => $row['noMembers'],
      'biography'   => $row['biography'],
      'countryID'   => $row['countryID'],
      'genreID'     => $row['genreID'],
  ];
}

// get and process events
$query_events = $dbc->prepare($sql_events);
$query_events->execute();
$events = [];
while($row = $query_events->fetch())
{
  $events[$row['bandID']] = [
      'bandName'    =>  $row['bandName'],
      'eventID'     =>  $row['eventID'],
      'eventName'   =>  $row['eventName'],
      'eventDate'   =>  $row['eventDate'],
      'eventDesc'   =>  $row['eventDesc']
  ];
}

// get and process countries
$sql_country = "SELECT `countryID`, `countryName` FROM country";
$query_country = $dbc->prepare($sql_country);
$query_country->execute();

while($row = $query_country->fetch())
{
  $country[$row['countryID']] = $row['countryName'];
}

// get and process genres
$sql_genre = "SELECT `genreID`, `genreName` FROM genre";
$query_genre = $dbc->prepare($sql_genre);
$query_genre->execute();
while($row = $query_genre->fetch())
{
  $genre[$row['genreID']] = $row['genreName'];
}
?>

<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<?php include('admin_gobacktomainmenulink.php'); ?>
<form action="admin_bands_add.php">
  <button type="submit" class="admin_button">Add New Band</button>
</form>
<form id="admin_list">
<table>
  <th>Band</th><th># of members</th><th>Country of Origin</th><th>Genre</th><th>Update</th>

<?php
$row_count = 0;
foreach($bands as $bid => $bname_info_arr)
{
  $get_string ='';
  echo ($row_count % 2 == 0) ? "<tr class='even'>\n" : "<tr class='odd'>\n";
  echo "<td>".$bname_info_arr['bandName']."</td><td>".$bname_info_arr['noMembers']."</td>";

  $get_string .= "bandID="      . $bid . '&' . 
                 "bandName="    . urlencode($bname_info_arr['bandName']) . '&' .
                 "noMembers="   . $bname_info_arr['noMembers'] . '&' .
                 "biography="   . urlencode($bname_info_arr['biography']). '&' .
                 "countryID="   . $bname_info_arr['countryID'] . '&' . 
                 "genreID="     . $bname_info_arr['genreID'] . '&';

  foreach($genre as $gid => $gname)
  {
    if($bname_info_arr['genreID'] == $gid) { $gval = $gname; $get_string .= "genreName=" . $gname . '&'; }
  }

  foreach($country as $cid => $cname)
  {
    if($bname_info_arr['countryID'] == $cid) { $cval = $cname; $get_string .= "countryName=" . $cname . '&'; }
  }


  // $bn = $bname_info_arr['bandName'];
  
  // event & band exist here - build js confirmation message
  if ( isset($bands[$bid]) && isset($events[$bid]) ) 
  {
    $bn = $events[$bid]['bandName'];
    $confirm_msg = "";
    $confirm_msg = 'Are you certain you want to delete the band, ' . $bn . '?' . "\\n\\n";
    $confirm_msg .= "\\tIf so:\\n\\n\\t" . 'event # ' . $events[$bid]['eventID'] . "\\n\\ton " . $events[$bid]['eventDate'] . "\\n\\twill also be deleted.";

    echo "<td>".$cval."</td><td>".$gval."</td><td>\n";
    echo "<a class='admintasks' href='admin_bands_update.php?".$get_string."'>Edit</a>" . "<span class='admintasks'> | </span>\n";
    echo "<a class='admintasks' href=\"admin_bands_delete.php?bandID=" . $bid . '&bandName=' . urlencode($bname_info_arr['bandName']) . '" ';
    echo "\n onclick='javascript:return confirm(\"" . $confirm_msg . "\");'";
    echo ">Delete</a></td>";
    echo "</tr>\n";

    unset($confirm_msg);
  }
  else
  {
    echo "<td>".$cval."</td><td>".$gval."</td><td><a class='admintasks' href='admin_bands_update.php?".$get_string."'>Edit</a>". "<span class='admintasks'> | </span>";
    echo "<a class='admintasks' ";
    echo " onclick=\"javascript:return confirm('Are you certain you want to delete band, " . $bands[$bid]['bandName'] . "?');\"";
    echo " href='admin_bands_delete.php?bandID=" . $bid . '&bandName=' . urlencode($bname_info_arr['bandName']);
    echo "'>Delete</a></td>\n";
    echo "</tr>\n";
  }
  $row_count++;
}
?>
</table>
</form>

<?php include('admin_gobacktomainmenulink.php'); ?>
</div> <!-- container -->


<?php
include("footer.php")
?>