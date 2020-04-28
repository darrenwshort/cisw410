<?php
/*************************************************
 * List all entries from 'genre' table, for:
 * 
 * - viewing genre records
 * - editing genre records
 * - deletion of genre records
 * 
 ************************************************/

$title = "View/Update - genre table";
$heading= "View/Update - <span class='italicize_color'>genre</span> table";

require_once("dbconnect.php");
include("header.php");

$sql_genre = "SELECT `genreID`, `genreName` FROM genre ORDER BY genreName";
$query_genre = $dbc->prepare($sql_genre);
$query_genre->execute();
$get_string = '';

while($row = $query_genre->fetch())
{
    $genre[$row['genreID']] = $row['genreName'];
}
?>
<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<?php include('admin_gobacktomainmenulink.php'); ?>

<table>
  <th>ID</th><th>Genre</th><th>Update</th>

<?php
$row_count = 0;
foreach($genre as $gid => $gname)
{
  $get_string = ''; // reset string for each genre
  $get_string .= "genreID=" . $gid . '&genreName=' . $gname . '&';
  echo "<tr>\n";
  echo ($row_count % 2 == 0) ? "<tr class='even'>\n" : "<tr class='odd'>\n";
  echo "<td>".$gid."</td><td>".$gname."</td><td><a class='admintasks' href='admin_genre_update.php?".$get_string."'>Edit</a></td>\n";
  echo "</tr>\n";
  $row_count++;
}
?>

</table>
<?php include('admin_gobacktomainmenulink.php'); ?>

</div> <!-- container --> 

<?php
include("footer.php")
?>