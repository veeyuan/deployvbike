<?php
$servername = "mysql3000.mochahost.com";
$name = 'jomletsh_bikerentalsystem';
$username = "jomletsh_user1";
$password = "user1abc";
$connect = mysqli_connect($servername, $username, $password, $name);


if (!$connect) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}
