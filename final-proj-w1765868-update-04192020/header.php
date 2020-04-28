<!doctype html>
<html>
<head>
    <title><?php echo $title ?></title>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="admin_form_styles.css">
</head>

<body>
<div class="wrapper">
<header>
    <div class="mainnav"> <!-- left side nav -->
        
        <a class="navbarleft" href="index.php">Home</a><
        <a class="navbarleft" href="events.php">Events</a>
        <a class="navbarleft" href="bands.php">Bands</a>
        <a class="navbarleft" href="about.php">About</a>
        <a class="navbarleft" href="contact.php">Contact</a>
    
        <form class="navbarright" method="get" action="search.php">

            <select id="searchin" name="searchin">
                <option selected> - Search Category - </option>
                <option value="bands">Bands</option>
                <option value="events">Events</option>
                <option value="genre">Genre</option>
            </select>
            <input type="text" id="searchstring" name="searchstring" value="Search for..." onfocus="this.value=''">
            <button type="submit" id="searchbtn" class="searchbtn" name="searchbtn" value="search">Search</button>

        </form>
    </div>
</header>