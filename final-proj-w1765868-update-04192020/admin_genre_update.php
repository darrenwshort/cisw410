<?php

$title = "Update record - 'genre' table";
$heading = "Update record - <span class='italicize_color'>genre</span> table";

include("header.php");

if(isset($_GET))
{
  $param = [];
  foreach($_GET as $key => $val)
  {
    if($val != "")
    {
      $param[$key] = urldecode($val);
    }
    else
    { 
      $err[] = "no value set for " . $key;
    }
  }
}

if(empty($err))
{
?>
<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<?php include('admin_gobacktomainmenulink.php'); ?>

<div id="grid-wrapper">
<form method="post" action="admin_genre_update.php" id="admin_genre_update">

  <label for="genreID" class="genre_form_label">Genre ID:</label>
  <input type="text" name="genreID" id="genreID" value=<?php echo "'" . $param['genreID'] . "'"; ?> disabled>

  <label for="genreName" class="genre_form_label">Genre Name:</label>
  <input type="text" name="genreName" id="genreName" value=<?php echo "'" . urldecode($param['genreName']) . "'"; ?>>

  <label>&nbsp;</label>  
  <p class="admin_form_btn">
    <button type="submit">Update</button> <button onClick="javascript:event.preventDefault();window.history.back();">Cancel</button>
  </p>
</form>
<!-- </div>  -->
<?php include('admin_gobacktomainmenulink.php'); ?>
</div> <!-- container -->  


<?php
}
else
{
  foreach($err as $err_msg)
  {
    echo '<div class="container">';
    echo '<div class="admin_header">' . $heading . '</div>';
    echo '<p>* ' . $err_msg . "</p>\n";
  }
}
?>

<?php
include("admin_footer.php");
?>