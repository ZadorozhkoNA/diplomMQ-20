<?php
$host = 'localhost';
// $db   = 'diplom';
$db   = 'global';
// $user = 'root';
$user = 'nzadorozhko';
// $pass = 'Mandragora123';
$pass = 'neto1906';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 $opt = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
 ];
$connection = new PDO($dsn, $user, $pass, $opt);

//Таблица Админ
$write = $connection->prepare("CREATE TABLE `admins`
  (`idAdmin` int NOT NULL AUTO_INCREMENT,
`nameAdmin` varchar(20) NULL,
`passAdmin` varchar(20) NULL,
`role` int,
`dates` timestamp NULL DEFAULT NULL,
PRIMARY KEY (`idAdmin`))
ENGINE=InnoDB DEFAULT CHARSET =utf8;");

$write->execute();

//Таблица Юзер
$write = $connection->prepare("CREATE TABLE `users`
  (`idUser` int NOT NULL AUTO_INCREMENT,
`nameUser` varchar(20) NULL,
`mailUser` varchar(30) NULL,
`dates` timestamp NULL DEFAULT NULL,
PRIMARY KEY (`idUser`))
ENGINE=InnoDB DEFAULT CHARSET =utf8;");

$write->execute();

 //Таблица Темы
$write = $connection->prepare("CREATE TABLE `topics`
  (`idTopic` int NOT NULL AUTO_INCREMENT,
`topic` varchar(300) NULL,
`dates` timestamp NULL DEFAULT NULL,
PRIMARY KEY (`idTopic`))
ENGINE=InnoDB DEFAULT CHARSET =utf8;");

$write->execute();

 //Таблица Вопросы
$write = $connection->prepare("CREATE TABLE `questions`
  (`idQuestion` int NOT NULL AUTO_INCREMENT,
`idTopic` int NULL,
`idUser` int NULL,
`idAdmin` int NULL,
`hidden` int NULL DEFAULT 0,
`dates` timestamp NULL DEFAULT NULL,
`question` varchar(1000) NULL,
PRIMARY KEY (`idQuestion`))
ENGINE=InnoDB DEFAULT CHARSET =utf8;");

$write->execute();

 //Таблица Ответы
$write = $connection->prepare("CREATE TABLE `answers`
  (`idAnswer` int NOT NULL AUTO_INCREMENT,
`idAdmin` int NULL,
`idQuestion` int NULL,
`idTopic` int NULL,
`dates` timestamp NULL DEFAULT NULL,
`answer` varchar(1000) NULL,
PRIMARY KEY (`idAnswer`))
ENGINE=InnoDB DEFAULT CHARSET =utf8;");

$write->execute();

$name='admin';
$password='admin';
$role='97';
$date = date("Y-m-d");
$dataUser = $connection->prepare("INSERT INTO `admins` SET
`nameAdmin` = ?, `passAdmin` = ?, `role` = ?, `dates` = ?");
$dataUser->execute(array($name, $password, $role, $date));
