<?php
$host = 'localhost';
$db   = 'diplom';
// $db   = 'global';
$user = 'root';
// $user = 'nzadorozhko';
$pass = 'Mandragora123';
// $pass = 'neto1906';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 $opt = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
 ];
$connection = new PDO($dsn, $user, $pass, $opt);
