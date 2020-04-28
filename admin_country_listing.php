<?php
/*************************************************
 * List all entries from 'country' table, for:
 * 
 * - viewing country records
 * - editing country records
 * - deletion of country records
 * 
 ************************************************/

$title = "View/Update/Delete - country table";
$heading = "View/Update/Delete - <span class='italicize_color'>country</span> table";

require_once("dbconnect.php");
include("header.php");

$sql_country = "SELECT `countryID`, `countryName` FROM country ORDER BY countryName";
$query_country = $dbc->prepare($sql_country);
$query_country->execute();
while($row = $query_country->fetch())
{
    $country[$row['countryID']] = $row['countryName'];
}
?>

<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<?php include('admin_gobacktomainmenulink.php'); ?>
<form id="admin_list">
<table>
  <th>ID</th><th>country</th><th>Update</th>

<?php
$row_count = 0;
foreach($country as $cid => $cname)
{
  $get_string = '';
  $get_string .= 'countryID=' . $cid . '&countryName=' . $cname . '&';

  echo "<tr>\n";
  echo ($row_count % 2 == 0) ? "<tr class='even'>\n" : "<tr class='odd'>\n";
  echo "<td>".$cid."</td><td>".$cname."</td><td><a class='admintasks' href='admin_country_update.php?". $get_string . "'>Edit</a></td>";
  echo "</tr>\n";
  $row_count++;
}
?>

</table>
</form>

<?php
include('admin_gobacktomainmenulink.php');
include("footer.php")
?>