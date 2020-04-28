<?php

$title = "Add Band - bands table";
$heading = "Add New Band - <span class='italicize_color'>bands</span> table";

include('header.php');
?>

<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<div id="grid-wrapper">
<form method="post" action="admin_bands_update_action.php" id="admin_update">
  <input type="hidden" name="bandID" id="bandID" value="">
  <label for="bandName">Band Name:</label>
  <input type="text" name="bandName" id="bandName" value=<?php echo "'" . urldecode($param['bandName']) . "'"; ?>>

  <label for="noMembers"># of Members:</label>
  <input type="text" name="noMembers" id="noMembers" value=<?php echo "'" . $param['noMembers'] . "'"; ?>>

  <label for="countryName">Country of Origin:</label>
  <input type="text" name="countryName" id="countryName" value=<?php echo "'" . urldecode($param['countryName']) . "'" ?>>

  <label for="genreName">Genre</label>
  <input type="text" name="genreName" id="genreName" value=<?php echo "'" . urldecode($param['genreName']) . "'" ?>>

  <label for="biography">Bio:</label>
  <textarea name="biography" id="biography" rows="10" maxlength="2500"><?php echo urldecode($param['biography']); ?></textarea>

  <p>&nbsp;</p>
  <p class="admin_form_btn">
    <button type="submit">Update</button> <button onClick="javascript:window.history.back()">Go Back</button>
  </p>

</form>
</div>
</div>

<?php 
  include('footer.php');
?>