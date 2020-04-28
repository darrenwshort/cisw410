<?php
$title = "Bands";
$heading = "Band Biographies";
$bandsPerPage = 6;

include('header.php');
?>

<div class="container">
<div class="heading">
    <p><?php echo $heading; ?></p>
</div>

<?php
require_once("dbconnect.php");


if(isset($_GET['start'])) {
    $start = $_GET['start'];
} else {
    $start = 0;
}

$sql = "SELECT `bandName`, `thumbnail`
        FROM bands
        ORDER BY `bandName` ASC
        LIMIT $start, $bandsPerPage";

$query = $dbc->prepare($sql);
$query->execute();

if(isset($_GET['numPages']))
{
    $numPages = $_GET['numPages'];
}
else
{
    // get only count of records, in order to set # of pages needed
    $countquery = $dbc->prepare("SELECT COUNT(bandName) as num
                                FROM bands");
    $countquery->execute();
    $records = $countquery->fetchAll();
    $numRecords = $records[0][0];

    // calculate # of pages needed to display data set
    if($numRecords < $bandsPerPage) {
        $numPages = 1;
    } else {
        $numPages = ceil($numRecords/$bandsPerPage);
    }

}

// echo "<h1>NUM RECORDS: " . $numRecords . " / BANDS PER PAGE: " . $bandsPerPage . " / NUM PAGES: " . $numPages . "</h1>\n";



# build links for band info listing by looping through array of bands.
// echo '<div class="banddiv">' . "\n";
    
// build array of band names.
$colscount = 1;
while($band = $query->fetch())
{
    $maxcolsperrow = 3;
    if($colscount == 1) { echo "<div class='bandsrow'>\n"; }
    
    $bandName = $band['bandName'];
    $tn       = $band['thumbnail'];

    echo "\t<div class='bandscolumn'>\n";
    echo "\t\t" . '<a href="band_bios.php?bandName=' . urlencode($bandName) . '">' . '<img alt="' . $tn . '" class="bandimg band-img" src="images/' . $tn . '" /></a><br><br>';
    echo "\t\t" . '<a class="bandhref" href="band_bios.php?bandName=' . urlencode($bandName) . '">' . $bandName . '</a>' . "\n";
    echo "\t</div>\n";

    if($colscount == $maxcolsperrow)
    { 
        echo "</div>\n";
        $colscount = 0;
    }
    $colscount++;
}
echo "</div>\n";
?>

</div> <!-- container -->

<?php
echo "<div class=\"centeredcontainer\">";
echo "<section class=\"pagelinks\">\n";
if($numPages > 1) {

    // echo "<h1>INSIDE LINK BUILDER</h1>\n";
    // echo "<h1>START = " . $start . "</h1>\n";
    $currentPage = ($start/$bandsPerPage)+1;

    if($currentPage != 1) {
        echo "<a href=\"bands.php?start=" . ($start-$bandsPerPage) . "&numPages=$numPages\">Previous</a> ";
    }

    for($i = 1; $i <= $numPages; $i++)
    {
        if($i != $currentPage)
        {
            echo " <a href=\"bands.php?start=" . ($bandsPerPage*($i-1)) . "&numPages=$numPages\">$i</a> ";
        }
        else
        {
            echo $i;
        }
    }

    if($currentPage != $numPages) {
        echo " <a href=\"bands.php?start=" . ($start+$bandsPerPage) . "&numPages=$numPages\">Next</a>";
    }
}

echo "</section>\n";
echo "</div>\n";
include('footer.php')
?>