<?php

$server = "localhost";
$serverName = "root";
$passwoed = "";
$dataBase = "news";

$conn = mysqli_connect($server, $serverName, $passwoed, $dataBase) or die("Connection Failed!");
