<?php

$servername = "localhost";
$username = "digitale_velanne";
$password = "t1QhPooYf";
$dbname = "digitale_velanne";

try {
  $bdd = new PDO ("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password,array (PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
  // set the pdo mode to exception
} catch (PDOException $e) {
  echo "Error: " . $e -> getMessage ();
}

