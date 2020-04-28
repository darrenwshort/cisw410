<?php

$title = "Update record - 'bands' table";
$heading = "Update record - <span class='italicize_color'>bands</span> table";

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
<div class="admin_header"><?php echo $heading; ?></div>

<form method="post" action="admin_bands_update_action.php" id="admin_update">

  <label for="bandID" class="adminformlabel">Band ID:</label>
  <input type="text" name="bandIDdisabled" id="bandIDdisabled" value=<?php echo "'" . $param['bandID'] . "'"; ?> disabled >
  <input type="hidden" name="bandID" id="bandID" value=<?php echo "'" . $param['bandID'] . "'"; ?>>
  <label for="bandName" class="adminformlabel">Band Name:</label>
  <input type="text" name="bandName" id="bandName" value=<?php echo "'" . urldecode($param['bandName']) . "'"; ?>>

  <label for="noMembers" class="adminformlabel"># of Members:</label>
  <input type="text" name="noMembers" id="noMembers" value=<?php echo "'" . $param['noMembers'] . "'"; ?>>

  <label for="countryName" class="adminformlabel">Country of Origin:</label>
  <input type="text" name="countryName" id="countryName" value=<?php echo "'" . urldecode($param['countryName']) . "'" ?>>

  <label for="genreName" class="adminformlabel">Genre</label>
  <input type="text" name="genreName" id="genreName" value=<?php echo "'" . urldecode($param['genreName']) . "'" ?>>

  <label for="biography" class="adminformlabel">Bio:</label>
  <textarea name="biography" id="biography" rows="10" maxlength="2500"><?php echo urldecode($param['biography']); ?></textarea>

  <p>&nbsp;</p>
  <p class="admin_form_btn">
    <button type="submit">Update</button> <button onClick="javascript:event.preventDefault();window.history.back();">Cancel / Go Back</button>
  </p>

</form>
</div>
</div>
<?php include('admin_gobacktomainmenulink.php'); ?>

<?php
}
else
{
  foreach($err as $err_msg)
  {
    echo '<div class="container">';
    echo '<div class="admin_header">' . "</div>\n"; 
    echo '<p class="err">* ' . $err_msg . "</p>\n";
  }
}
?>

<?php
include("admin_footer.php");
?>