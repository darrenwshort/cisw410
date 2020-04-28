<?php
$user = 'root';
$pass = '';

try
{
  $dbc = new PDO('mysql:host=localhost;dbname=concerts', $user, $pass);
}
catch(PDOException $e)
{
  echo $e->getMessage();
}