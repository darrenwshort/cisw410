<?php

$title = "Update record - 'country' table";
$heading = "Update record - <span class='italicize_color'>country</span> table";

include('header.php');

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
<form method="post" action="admin_country_update_action.php" id="admin_country_update">
  <label for="countryID">country ID:</label>
  <input type="text" name="countryID" id="countryID" value=<?php echo "'" . $param['countryID'] . "'"; ?> disabled >

  <label for="countryName">country Name:</label>
  <input type="text" width="20" name="countryName" id="countryName" value=<?php echo "'" . urldecode($param['countryName']) . "'"; ?>>

  <p>&nbsp;</p>
  <p class="admin_form_btn">
    <button type="submit">Update</button> <button onClick="javascript:event.preventDefault();window.history.back();">Cancel / Go Back</button>
  </p>
</form>

</div> <!-- grid-wrapper -->
<?php include('admin_gobacktomainmenulink.php'); ?>

</div> <!-- container -->

<?php
}
else
{
  foreach($err as $err_msg)
  {
    echo '<p>* ' . $err_msg . "</p>\n";
  }
}
?>

<?php 
include('footer.php');
?>