<?php
$title = $heading = "View/Update/Insert bands table";
require_once("dbconnect.php");
include("admin_header.php");
include('admin_gobacktomainmenulink.php');

$sql_band = "SELECT `bandName`, `noMembers`, `biography`, `countryID`, `genreID` FROM bands";
$query_band = $dbc->prepare($sql_band);
$query_band->execute();
while($row = $query_band->fetch())
{
  $bands[$row['bandName']] = [
      'noMembers' => $row['noMembers'],
      'biography'   => $row['biography'],
      'countryID' => $row['countryID'],
      'genreID'   => $row['genreID'],
  ];
}

$sql_country = "SELECT `countryID`, `countryName` FROM country";
$query_country = $dbc->prepare($sql_country);
$query_country->execute();
// $country[0] = "NADA_COUNTRY";
while($row = $query_country->fetch())
{
  $country[$row['countryID']] = $row['countryName'];
}


$sql_genre = "SELECT `genreID`, `genreName` FROM genre";
$query_genre = $dbc->prepare($sql_genre);
$query_genre->execute();
// $genre[0] = "NADA_GENRE";
while($row = $query_genre->fetch())
{
  $genre[$row['genreID']] = $row['genreName'];
}
?>

<main>
<!-- <section class="bandinfo"> -->
<section>
<form action="#" method="post">

<?php
foreach($bands as $bname => $bname_info_arr)
{
?>



<label for="bandName">Band Name</label>
<input type="text" name="bandName" id="bandName" value=" <?php echo $bname ?>"><br>
<label for="noMembers">No. of Members</label>
<input type="text" name="noMembers" id="noMembers" value=" <?php echo $bname_info_arr['noMembers']; ?>"><br>


<label for="genre">Genre:</label>
<?php
  foreach($genre as $gid => $gname)
  {
    if($bname_info_arr['genreID'] == $gid) { $gval = $gname; }
  }
?>

<input type="text" name="genre" id="genre" value="<?php echo $gval; ?>"><br>

<?php
  foreach($country as $cid => $cname)
  {
    if($bname_info_arr['countryID'] == $cid) { $cval = $cname; }
  }
?>
<label for="country">Country of Origin:</label>
<input type="text" name="country" id="country" value="<?php echo $cval; ?>"><br>
<label for="biography">Band Biography:</label>
<textarea name="biography" id="biography" rows="10" maxlength="2500"><?php echo $bname_info_arr['biography']; ?>"></textarea><br><br>




<?php
}
?>
</form>
</section>
</main>

<?php
include("admin_footer.php")
?>