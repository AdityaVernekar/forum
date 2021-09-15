<?php
$server = "localhost";
$username = "root";
$password = "";
$db = "idiscuss";

$conn = mysqli_connect($server,$username,$password,$db);
if(!$conn){
    die("could not connect-->".mysqli_connect_error());
}
?>