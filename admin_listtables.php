<?php
/****************************************************
 * List all tables from 'concerts' db, for selection.
 * 
 * Selecting table, will provide listing of all
 * records in that specific table, in which you can
 * 'Edit' or 'Delete' individual records
 * 
 ***************************************************/

$title = "Concerts DB - Admin Table Listing";
$heading = "Select Table to View/Update:";
include('header.php');
require_once("dbconnect.php");

// get table names from db.
$sql = "SHOW TABLES";
$stmnt = $dbc->prepare($sql);
$stmnt->execute();
?>
<div class="container">
<div class="heading"><?php echo $heading; ?></div>
<div class="centeredcontainer">
<select name="db_table" id="db_table" onchange="javascript:window.location.href=this.value;">
    <option disabled selected> -- Select Table -- </option>

<?php
while($row = $stmnt->fetch())
{
    $table_in_concerts = $row['Tables_in_concerts'];
    echo "\t".'<option value="admin_' . strtolower($table_in_concerts) . '_listing.php">' . ucfirst($table_in_concerts) . '</option>';
}
?>

</select>
<!-- </form> -->
</div>  

<?php include('admin_footer.php');