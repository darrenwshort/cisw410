<?php
//------------------------------------------------------------------------
// file: admin_addevent.php
// name: darren short
// 
// purpose:
//      This program adds event data to the concerts db.
//      (NOTE: This page is only accessible to administrators of the db)
//
//      If a band already exists for the event being added, the
//      band's ID is queried for and only a new event record is
//      added to the events table.
//
//      If the band does not exist, a new record is inserted into
//      the bands table, as well as, a new record inserted into
//      the events table.
//
// input:   data from form fields.
// output:  error message on incomplete filling of data form fields OR
//          message of entry addition, upon success.
//------------------------------------------------------------------------

include('header.php');

if(!empty($_GET))
{
  // 'squeeze' out space character.
  $bandname_massaged = str_replace(' ', '', $_GET['bandName']);

  // convert string to all lowercase.
  $bandname_massaged = strtolower($bandname_massaged);
  
  // store data in user-friendly vars, for subsequent use.
  $evenName = $_GET['eventName'];
  $eventDesc = $_GET['eventDesc'];
}
?>


<main>
<section class="bandinfo">
<h1><?php echo $_GET['bandName']; ?></h1>
<a target="_blank" href="#">
 <?php echo '<img class="band-img" src="images/' . $bandname_massaged . '-img.jpg" alt="' . $bandname_massaged . '-band-img" align="right">'; ?>
</a>

<article class="band-article">
<p>
<?php echo $eventDesc; ?>
</p>

</article>
</section>
</main>

<?php
include('footer.php')
//----------------------- END OF PROGRAM ------------------------
?>