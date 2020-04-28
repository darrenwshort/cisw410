<?php
$title = "Bands";
$heading = "Band Biographies";

include('header.php');
?>


<div class="container">
<!-- <div class="centeredcontainer"> -->

<h1><?php echo $heading; ?></h1>
    

<?php
require_once("dbconnect.php");


$sql = "SELECT `bandName`
        FROM bands
        ORDER BY `bandName` ASC";
$stmnt = $dbc->prepare($sql);
$stmnt->execute();


# build links for band info listing by looping through array of bands.
echo '<div class="banddiv">' . "\n";
echo '<ul class="bandlist">' . "\n";
    
// build array of band names.
while ($row = $stmnt->fetch())
{
  $bandName = $row['bandName'];
  echo '<li class="bandlistitem"><a class="bandhref" href="band_bios.php?bandName=' . urlencode($bandName) . '">' . $bandName . '</a></li>' . "\n";
}
echo '</ul>' . "\n";  
echo '</div>' . "\n\n";
?>

</div> <!-- container -->
</div> <!-- wrapper -->



<?php
include('footer.php')
?>