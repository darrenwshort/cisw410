<?php
$title = $heading = "Contact Us";
include('header.php');
?>

<div class="container">

<div class="heading">
    <p><?php echo $heading; ?></p>
</div>

<div class="contactformdiv">
<form method="post" action="contactaction.php" id="contactform">

    <label for="contactfname" id="contactfnamelabel">First Name:</label>
    <input type="text" id="contactfname" name="contactfname" class="contactInput" value="<?php echo (isset($_GET['contactfname'])) ? $_GET['contactfname'] : ''; ?>">

    <label for="contactlname" id="contactlnamelabel">Last Name:</label>
    <input type="text" id="contactlname" name="contactlname" class="contactInput" value="<?php echo (isset($_GET['contactlname'])) ? $_GET['contactlname'] : ''; ?>">

    <label for="contactemail" id="contactemail">Email:</label>
    <input type="text" id="contactemail" name="contactemail" class="contactInput" value="<?php echo (isset($_GET['contactemail'])) ? $_GET['contactemail'] : ''; ?>">

    <label for="contactphone" id="contactphonelabel">Contact #:</label>
    <input type="text" id="contactphone" name="contactphone" class="contactInput" value="<?php echo (isset($_GET['contactphone'])) ? $_GET['contactphone'] : ''; ?>">

    <label for="contactsubject" id="contactsubjectlabel">Subject:</label>
    <textarea id="contactsubject" name="contactsubject" class="contactInput"><?php echo (isset($_GET['contactsubject'])) ? $_GET['contactsubject'] : ''; ?></textarea>

    <input type="submit" id="contactInputSubmit" value="Submit">

</form>
<p>Concert @ The Creek</p>
<p>123 Main St., Vacaville, CA 95688</p>
<p>Tel #: (707) 707-7070</p>
<p>Fax #: (707) 707-7071</p>
</div> <!-- contactformdiv -->
</div> <!-- container -->
<?php
include('footer.php')
?>
