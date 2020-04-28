<?php

$title = "Update record - 'bands' table";
$heading = "Update record - <span class='italicize_color'>bands</span> table";

include("header.php");
require_once("dbconnect.php");

//*************************** FUNCTIONS ****************************/

/******************** getCountryIdByName() ***********************/
function getCountryIdByName($cname)
{
  global $dbc;
  $stmnt = $dbc->prepare("SELECT `countryID` FROM country WHERE countryName = :cname");
  $stmnt->bindValue(":cname", $cname);
  $stmnt->execute();
  while($row = $stmnt->fetch())
  {
    $cid = $row['countryID'];
  }
  echo '<h3>In getCountryIdByName' . "-------- " . $cid . "<h3><br><br>";
  return $cid;
}

/******************** getGenreIdByName() ***********************/
function getGenreIdByName($gname)
{
  global $dbc;
  $stmnt = $dbc->prepare("SELECT `genreID` FROM genre WHERE genreName = :gname");
  $stmnt->bindValue(":gname", $gname);
  $stmnt->execute();
  while($row = $stmnt->fetch())
  {
    $gid = $row['genreID'];
  }
  return $gid;
}

/******************** squeezeStr() ***********************/
function squeezeStr($str)
{
  $str = strtolower($str);
  str_replace(" ", "", $str);
  return $str;
}

/******************** countryExistsInTable() ***********************/
function countryExistsInTable($cname)
{

  global $dbc;

  $stmnt = $dbc->prepare("SELECT `countryID`, `countryName` FROM country WHERE countryName = :cname");
  $stmnt->bindValue(":cname", $cname);
  $stmnt->execute();

  
  while($row = $stmnt->fetch())
  {
    if(squeezeStr($row['countryName']) == squeezeStr($cname))
    {
      $arr['set'] = 1;
      $arr['countryID'] = $row['countryID'];
    }
    else 
    {
      $arr['set'] = 0;
    }
  }
  return $arr;
}

/******************** genreExistsInTable() ***********************/
function genreExistsInTable($gname)
{
  global $dbc;
  $stmnt = $dbc->prepare("SELECT `genreID`, `genreName` FROM genre WHERE UPPER(genreName) = UPPER(:genreName)");
  $stmnt->bindValue(":genreName", $gname);
  $stmnt->execute();
  

  while($row = $stmnt->fetch())
  {
    if(squeezeStr($row['genreName']) == squeezeStr($gname)) 
    {
      $arr['set'] = 1;
      $arr['genreID'] = $row['genreID'];
    }
    else
    {
      $arr['set'] = 0;
    }
  }
  return $arr;
}

/******************** insertCountryIntoTable() ***********************/
function insertCountryIntoTable($cname)
{
  global $dbc;
  $cname = strtolower($cname);
  $cname = ucwords($cname);
  
  $sql = "INSERT INTO `country` (`countryName`) VALUES (:cname)";
  $stmnt = $dbc->prepare($sql);
  
  $stmnt->bindValue(":cname", $cname);
  $stmnt->execute();

  return $cid;
}

/******************** insertGenreIntoTable() ***********************/
function insertGenreIntoTable($gname)
{
  global $dbc;
  $stmnt = $dbc->prepare("INSERT INTO `genre` (`genreName`) VALUES (:gname)");
  $gname = strtolower($gname);
  $gname = ucwords($gname);
  $stmnt->bindValue(":gname", $gname);
  $stmnt->execute();

  $gid = getGenreIdByName($gname);
  return $gid;
}

/******************** prepStrForDB() ***********************/
function prepStrForDb($str)
{
  $str = strtolower($str);
  $str = ucwords($str);
  return $str;
}

/************* END FUNCTIONS *************/

// grab parameters/values from post.
if(isset($_POST['bandName']))
{
    $err = array();
    $param = array();
    if($_POST['bandName'] != "")
    {
      $bn = $_POST['bandName'];
      $param['bandName'] = $bn;
    }
    else
    {
      $err[] = "You need to enter a band name.";
    }

    if($_POST['noMembers'] != "")
    {
      $nm = $_POST['noMembers'];
      $param['noMembers'] = $nm;
    }
    else
    {
      $err[] = "You need the number of band members in group.";
    }

    if($_POST['biography'] != "")
    {
      $bio = $_POST['biography'];
      $param['biography'] = $bio;
    }
    else
    {
      $err[] = "You need to enter a biography for the band.";
    }

    if($_POST['genreName'] != "")
    {
      $gn = $_POST['genreName'];
      $param['genreName'] = $gn;
    }
    else
    {
      $err[] = "You need to enter a genre name.";
    }

    if($_POST['countryName'] != "")
    {
      $cn = $_POST['countryName'];
      $param['countryName'] = $cn;
    }
    else
    {
      $err[] = "You need to enter a country of origin for the band.";
    }
    if($_POST['bandID'] != "")
    {
      $bid = $_POST['bandID'];
      $param['bandID'] = $bid;
    }
    else
    {
      $err[] = "There is no band ID, please contact administrator.";
    }
} // end of if(isset())

if(empty($err))
{
  $countryExistsAlready  = countryExistsInTable($param['countryName']); // returns array 
  $genreExistsAlready    = genreExistsInTable($param['genreName']); // returns array
  $new_record = [];

  foreach($param as $k => $v)
  {
    $new_update_record[$k]  = $v;
  }

  if($countryExistsAlready['set'] == 1)
  {
    $new_update_record['countryID'] = prepStrForDb($countryExistsAlready['countryID']);
  }
  else
  {
    $new_update_record['countryID'] = insertCountryIntoTable($param['countryName']);
  }

  if($genreExistsAlready['set'] == 1)
  {
    $new_update_record['genreID'] = prepStrForDb($genreExistsAlready['genreID']);
  }
  else
  {
    $new_update_record['genreID'] = insertGenreIntoTable($new_update_record['genreName']);
  }

  $sql= "UPDATE bands
         SET    bandName=:bandName,
                noMembers=:noMembers,
                biography=:biography,
                countryID=:countryID,
                genreID=:genreID
         WHERE  bandID=:bandID";
  
  $sql_update = $dbc->prepare($sql);
  $sql_update->bindValue(":bandName", $new_update_record['bandName']);
  $sql_update->bindValue(":noMembers", $new_update_record['noMembers']);
  $sql_update->bindValue(":biography", $new_update_record['biography']);
  $sql_update->bindValue(":countryID", $new_update_record['countryID']);
  $sql_update->bindValue(":genreID", $new_update_record['genreID']);
  $sql_update->bindValue(":bandID", $param['bandID']);
  $sql_update->execute();

  // after successful update, let user know.
  echo "\n<div class=\"container\">";
  echo "\t<div class=\"updateSuccess\">";
  echo "\t\t<p class=\"success\">Update Successful!</p>\n";
  include("admin_gobacktomainmenulink.php");
  echo "\t</div>\n";
  echo "</div>\n";
}
else
{
  foreach($err as $err_msg)
  {
    echo "<div class=\"container\">\n";
    echo "<p id=\"err\">* " . $err_msg . "</p>\n";
    echo "<button onClick=\"javascript:window.history.back();\">Go Back</button>\n";
    echo "</div>";
  }
}

include("footer.php");
?>