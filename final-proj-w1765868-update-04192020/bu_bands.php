<?php
$title = "Bands";
include('header.php');
?>

<main>
<section class="bandinfo">
<h1>Band Biographies</h1>
    

<?php
#
# Building links for each band's info page.
# Read files from directory - for only band info pages.
# Parse filename for band name.
# To add new band link, create only band info page
# with content, following filename format.
# List to links is dynamically updated.
#
# Band file name format:  'BANDNAME-band-info.php'
#
    
$dir = '.';   // current directory
$bandnames = array();
    
# regex to grab only band info files for processing
# bandname file format:   'BANDNAME-band-info.php'
$regex = '/-band-info.php$/';  
    
# test directory exists
if(is_dir($dir))
{
    # test we're able to open directory for reading
    if($dh = opendir($dir))
    {
        # read filenames from current directory until all files exhausted
        while(($file = readdir($dh)) != false)
        {
            $i=0;
            if(preg_match($regex, $file))
            {
               // explode and capture band name for key in assoc. array
               // assign filename as value to band name "key".
               $temp_arr = explode('-', $file);
               $bandnames[$temp_arr[$i]] = $file;
               $i++;
            }
            
        }
    }
}

# build links for band info listing by looping through array of bands.
echo '<div class="bandlist">' . "\n";
echo '<ul>' . "\n";
    
// sort assoc. array, alphabetically, for display.
ksort($bandnames); 
    
foreach($bandnames as $band => $bandfile)
{
    echo '<li><a href="' . $bandfile . '">' . $band . '</a></li>' . "\n";
}
echo '</ul>' . "\n";  
echo '</div>' . "\n";
?>

</section>
</main>


<?php
include('footer.php')
?>