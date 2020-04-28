<?php
//------------------------------------------------------------------------
// file: band_bios.php
// name: darren short
// 
// purpose:
//      This program lists a band's bio
//
// input:   $_GET['bandName']
// output:  band bios text and band image.
//------------------------------------------------------------------------

$title = $heading = "Band Biographies";
include('header.php');
require_once("dbconnect.php");
?>

<div class="container">
<div class="heading">
  <p><?php echo $heading ; ?></p>
</div>

<?php

if($_GET['bandName'] != "")
{
  $bandName = urldecode($_GET['bandName']);
}
else
{
  echo '<h3>* No band name provided for lookup.</h3>';
  echo '<a href="bands.php">Go back to Bands page</a>';
}

$sql = "SELECT `bandName`, `biography`, `image`, `thumbnail` 
        FROM bands
        WHERE bandName = :bandName";

$stmnt = $dbc->prepare($sql);
$stmnt->bindValue(":bandName", $bandName);
$stmnt->execute();

while($row = $stmnt->fetch())
{
  $bn = $row['bandName'];
  $bio = $row['biography'];
  $img = $row['image'];
  $tn = $row['thumbnail'];

  if(isset($_GET['search'])) { 
      $search = urldecode($_GET['search']);
      $regex = '/(' . $search . ')/i';
      $replacement = '<span class="searchspan">$1</span>';
      $bn   = preg_replace($regex, $replacement, $row['bandName']);
      $bio  = preg_replace($regex, $replacement, $row['biography']);
  }

  echo '<div class="bandheader">' . $bn . '</div>';

  // echo '<h2>' . $bn . '</h2>';
  // echo '<p><img class="resize bandimg" src="images/' . $img . '" /></p>';
  

  echo '<div class="bandarticlecontainer">';
  echo '<div class="band-article">';
  echo '<p><img class="resize bandimg" src="images/' . $img . '" /></p>';
  echo '<p>' . $bio . '</p>';
  echo '</div>';
}

?>
</div> <!-- class=container -->
<?php include("footer.php"); ?>