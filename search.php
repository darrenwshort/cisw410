<?php
$title = $heading = "Search Results";
include("header.php");
require_once("dbconnect.php");

echo "<div class=\"container\">\n";
echo "<div class=\"heading\">" . $heading . "</div>\n";

$searchcriteria = array();

// search string provided by user.
if(isset($_GET['searchstring']) && $_GET['searchstring'] != "")
{
    $search = $_GET['searchstring'];
    $searchcriteria[] = $_GET['searchstring'].', ';
    $error = array();
    $query = NULL;
    
    
    // table chosen AND search string supplied.
    if(!preg_match('/Search/', $_GET['searchin']) && 
        !preg_match('/Search/', $_GET['searchstring']))
    {                
        

        $table  = $_GET['searchin'];
        $search = $_GET['searchstring'];
        $searchcriteria[] = $table;


        // search on bands table.
        if($table == "bands")
        {
            $query = $dbc->prepare("SELECT `bandName`, `biography` 
                                    FROM bands
                                    WHERE `bandName`  LIKE :bandstr
                                    OR    `biography` LIKE :biostr");
            $query->bindValue(":bandstr", '%'.$search.'%');
            $query->bindValue(":biostr" , '%'.$search.'%');
            $query->execute();

            // get count of records retrieved.
            if(isset($query)) {
                echo "<h2 class=\"italicize\">-- " . $query->rowCount() . " result(s) found --</h2>\n";
            }
            
            // process dataset from bands table.
            while($row = $query->fetch()) {
                $bname = $row['bandName'];
                $bio = $row['biography'];

                $regex = '/(' . $search . ')/i';
                $replacement = '<span class="searchspan">$1</span>';
                $new_bname  = preg_replace($regex, $replacement, $bname);
                $new_bio = preg_replace($regex, $replacement, $bio);

                if($new_bname != "" || $new_bio != "") {
                    echo "<p><span class=\"search_italicize_white\"> band >> <a class=\"bandhref\" href=\"band_bios.php?bandName=" . urlencode($bname) .
                                         "&search=" . urlencode($search) . "\">" . $bname .
                                         "</a></p>\n";
                }
            }
        }    

        // search on events table.
        elseif($table == "events")
        {
            $query = $dbc->prepare("SELECT e.eventName, e.eventDesc, e.eventDate, b.bandName
                                    FROM  events e
                                    INNER JOIN bands b ON e.bandID = b.bandID
                                    INNER JOIN genre g ON g.genreID = b.genreID
                                    WHERE e.eventName LIKE :eventName
                                    OR    e.eventDesc LIKE :eventDesc
                                    OR    e.eventDate LIKE :eventDate
                                    OR    g.genreName LIKE :genreName");

            $query->bindValue(":eventName", '%'.$search.'%');
            $query->bindValue(":eventDesc", '%'.$search.'%');
            $query->bindValue(":eventDate", '%'.$search.'%');
            $query->bindValue(":genreName", '%'.$search.'%');
            $query->execute();
            
            // get count of records retrieved.
            if(isset($query)) {
                echo "<h2 class=\"italicize\">-- " . $query->rowCount() . " result(s) found --</h2>\n";
            }
            
            // process dataset from events table.
            while($row = $query->fetch()) {
                // var_dump($row);
                $ename = $row['eventName'];
                $edesc = $row['eventDesc'];
                $edate = $row['eventDate'];

                // search fields against regex.
                $regex = '/(' . $search . ')/i';
                $replacement = '<span class="searchspan">$1</span>';
                $new_ename  = preg_replace($regex, $replacement, $ename);
                $new_edesc  = preg_replace($regex, $replacement, $edesc);
                $new_edate  = preg_replace($regex, $replacement, $edate);


                if($new_ename != "" || $new_edesc != "" || $new_edate != "") {
                    echo "<p><span class=\"search_italicize_white\"> event >> <a class=\"bandhref\" href=\"events.php?eventName=" . urlencode($ename) .
                                         "&search=" . urlencode($search) . "\">" . $ename .
                                         "</a></p>\n";
                }
            }
        }

        // search on genre table.
        elseif($table == "genre")
        {

            //query for bands related to search
            $query = $dbc->prepare("SELECT b.bandName, g.genreName, e.eventName, e.eventDesc
                                    FROM genre g
                                    LEFT JOIN bands  b ON g.genreID = b.genreID
                                    LEFT  JOIN events e ON b.bandID  = e.bandID
                                    WHERE g.genreName LIKE :genreName
                                ");

            // $query = $dbc->prepare("SELECT g.genreID, g.genreName, b.bandName, b.bandID
            //                         FROM genre g
            //                         left JOIN bands b on g.genreID = b.genreID
            //                         where g.genreName like :genreName");
            $query->bindValue(":genreName", '%'.$search.'%');
            $query->execute();


            //echo "<h2 style=\"color: #FFF\">" . var_dump($query->fetchAll()) . "</h2>";

            $bandssearchlist = array();
            $eventssearchlist = array();
            $genresearchlist = array();
            $genreOnly = 0;

            while($row = $query->fetch()) {

                $bname = $row['bandName'];
                $gname = $row['genreName'];
                $ename = (isset($row['eventName'])) ? $row['eventName'] : NULL;

                // if genre provided, list bands and events of that specific genre.
                if($gname != "") {
                    if($bname != "" && $ename != "") {
                        $listitem = "<p><span class=\"search_italicize_white\">[" . $search . "] event >> <a class=\"bandhref\" href=\"events.php?eventName=" . urlencode($ename) .
                                    "&search=" . urlencode($search) . "\">" . $ename . "</a></p>\n";
                        $eventssearchlist[] = $listitem;
                    }
                    elseif($bname != "") {                        
                        $listitem = "<p><span class=\"search_italicize_white\">[" . $search . "] genre > " . $gname . " >> <a class=\"bandhref\" href=\"band_bios.php?bandName=" . urlencode($bname) .
                                    "&search=" . urlencode($search) . "\">" . $bname . "</a></p>\n";
                        $bandssearchlist[] = $listitem;
                    }
                    else {
                        $genreOnly = 1;
                    }
                }
            }

            // display count of search items to display
            $num_items = count($bandssearchlist) + count($eventssearchlist);
            if(isset($query)) {
                echo "<h2 class=\"italicize\">-- " . $num_items . " result(s) found --</h2>\n";
            }

            // display search results.
            foreach(array_unique($eventssearchlist) as $item) {
                echo $item;
            }
            foreach(array_unique($bandssearchlist) as $item) {
                echo $item;
            }

        }
    }

    // table chosen AND NO search term supplied.
    elseif (!preg_match('/Search/', $_GET['searchin']) &&
            preg_match('/Search/', $_GET['searchstring']))
    {
        $search = $_GET['searchstring'];
        $table = $_GET['searchin'];
        $searchcriteria[] = $table;

        // table chosen.   search string NOT supplied.
        echo "<h2>Table: " . $table . " / Please provide a search term.<h2>\n";
        $error[] = 'Search Table Chosen => ' . $_GET['searchin'] . ", but please enter a search term.";
    }

    // NO table chosen BUT search term supplied.  Search will be executed across all tables.
    elseif (preg_match('/Search/', $_GET['searchin']) &&
            !preg_match('/Search/', $_GET['searchstring']))
    {
        $search = $_GET['searchstring'];
        $searchcriteria[] = $_GET['searchstring'];
        $searchcriteria[] = 'bands';
        $searchcriteria[] = 'events';
        $searchcriteria[] = 'genre';


        // query for bands related to search
        $query = $dbc->prepare("SELECT b.bandName, b.biography, g.genreName, e.eventName, e.eventDesc
                                FROM bands b
                                LEFT JOIN genre g  ON g.genreID = b.genreID
                                LEFT JOIN  events e ON e.bandID  = b.bandID
                                WHERE b.bandName  LIKE :bandName
                                OR    b.biography LIKE :biography
                                OR    g.genreName LIKE :genreName
                                OR    e.eventName LIKE :eventName
                                OR    e.eventDesc LIKE :eventDesc");

        $query->bindValue(":bandName" , '%'.$search.'%');
        $query->bindValue(":biography", '%'.$search.'%');
        $query->bindValue(":genreName", '%'.$search.'%');
        $query->bindValue(":eventName", '%'.$search.'%');
        $query->bindValue(":eventDesc", '%'.$search.'%');
        $query->execute();

        $bandssearchlist      = array();
        $bandsbiosearchlist   = array();
        $genresearchlist      = array();
        $eventssearchlist     = array();
        $eventsdescsearchlist = array();

        while($row = $query->fetch()) {
        
            $bname = $row['bandName'];
            $bio   = $row['biography'];
            $gname = $row['genreName'];
            $ename = $row['eventName'];
            $edesc = $row['eventDesc'];
            $num_items = 0;

            $regex = '/(' . $search . ')/i';
            $replacement = '<span class="searchspan">$1</span>';

            $bfound   = preg_replace($regex, $replacement, $bname);
            $biofound = preg_replace($regex, $replacement, $bio);
            $gfound   = preg_replace($regex, $replacement, $gname);
            $efound   = preg_replace($regex, $replacement, $ename);
            $edfound  = preg_replace($regex, $replacement, $edesc);

            // search string found in band name?
            if($bfound != "" && preg_match('/span/',$bfound)) {

                $listitem = "<p><span class=\"search_italicize_white\">band > " . $bname . " >> </span><a class=\"bandhref\" href=\"band_bios.php?bandName=" . urlencode($bname) .
                    "&search=" . urlencode($search) . "\">" . $bname . "</a></p>\n";
                $bandssearchlist[] = $listitem;
            }

            // search string found in band bio?
            if($biofound != "" && preg_match('/span/',$biofound)) {

                $listitem = "<p><span class=\"search_italicize_white\">band bio > " . $bname . " >> </span><a class=\"bandhref\" href=\"band_bios.php?bandName=" . urlencode($bname) .
                    "&search=" . urlencode($search) . "\">" . substr($bio,0,50) . "...</a></p>\n";
                $bandsbiosearchlist[] = $listitem;
            }

            // search string found in event name?
            if(($efound != "" && $edfound != "") && preg_match('/span/', $efound) && preg_match('/span/', $edfound)) {
                $listitem = "<p><span class=\"search_italicize_white\">event >> </span><a class=\"bandhref\" href=\"events.php?eventName=" . urlencode($ename) .
                    "&search=" . urlencode($search) . "\">" . $ename . "</a></p>\n";
                $eventssearchlist[] = $listitem;
            }

            // search string found in event description?
            if($edfound != "" && preg_match('/span/',$edfound)) {
                $listitem = "<p><span class=\"search_italicize_white\">event description" . " >> </span><a class=\"bandhref\" href=\"events.php?eventName=" . urlencode($ename) .
                    "&search=" . urlencode($search) . "\">" . substr($edesc,0,50) . "...</a></p>\n";
                $eventsdescsearchlist[] = $listitem;
            }

            // search string found in genre name?
            if($gfound != "" && preg_match('/span/',$gfound)) {
                $listitem = "<p><span class=\"search_italicize_white\">genre > " . $gname . " >> </span><a class=\"bandhref\" href=\"band_bios.php?bandName=" . urlencode($bname) .
                    "&search=" . urlencode($search) . "\">" . $bname . "</a></p>\n";
                $genresearchlist[] = $listitem;
            }
        }

        $num_items = count($bandssearchlist) +
                     count($bandsbiosearchlist) +
                     count($eventssearchlist) +
                     count($eventsdescsearchlist) +
                     count($genresearchlist);
        
        // display result count.
        echo "<h2 class=\"italicize\">-- " . $num_items . " result(s) found --</h2>\n";
    
        // print out search results for bands, events and genre.
        foreach(array_unique($bandssearchlist) as $item) {
            echo $item;
        }
        foreach(array_unique($bandsbiosearchlist) as $item) {
            echo $item;
        }
        foreach(array_unique($eventssearchlist) as $item) {
            echo $item;
        }
        foreach(array_unique($eventsdescsearchlist) as $item) {
            echo $item;
        }
        foreach(array_unique($genresearchlist) as $item) {
            echo $item;
        }
    }
    // NO table ; NO search term supplied.
    else 
    {   // NOTHING CHOSEN/SUPPLIED.
        echo "<h2>No Search Term Supplied?</h2>\n";
    }
}
else 
{
    echo "<h2>Please type something in the search field.</h2>\n";
}

// remove trailing ',' - strictly to tighten up look
$searchcriteria = preg_replace('/^(.+),\s*/', '$1', $searchcriteria);

echo "<div class=\"searchcriteria\">\n";

// process unique values and wrap in span tags for underline decoration.
foreach(array_unique($searchcriteria) as $i) {
    $results[] = "<span class=\"underline\">" . $i . "</span>";
}

echo "\t<p class=\"searchcriteriap\">Search Criteria: ";
echo (count($results) > 1) ? join(" , ", $results):$results[0];
echo "</p>\n";
echo "</div>\n";

echo "</div>\n";  // class=container

include("footer.php");
?>

