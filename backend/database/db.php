<?php


$env = parse_ini_file($_SERVER['DOCUMENT_ROOT'] .'/backend/.env');
$servername = $env['SERVER_NAME'];
$username = $env["USERNAME"];
$password = $env["PASSWORD"];
$dbname = $env["DBNAME"];


$servername = "localhost";
$username = "u219536372_PocketGarageDB";
$password = "PocketGarageDB1";
$dbname = "u219536372_PocketGarageDB";

//Create New Database Connection
$conn = new mysqli($servername, $username, $password, $dbname);

//Check Connection
if($conn->connect_error) {
	die("Connection Failed: ". $conn->connect_error);
}