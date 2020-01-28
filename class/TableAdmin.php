<?php
class TableAdmin
{
  public $cells;
  public $connection;
  public $wheres;

  public function __construct($connection)
  {
    //$this->cells = $cells;
    $this->connection = $connection;
  }

  public function selectTableAdmin()//выбор из таблицы
  {
     $cells = $this->cells;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT * FROM `admins` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function selectAllAdmin()//выбор из таблицы всех строк
  {
     $connection = $this->connection;

     $data = $connection->prepare("SELECT * FROM `admins` ORDER BY `dates` ASC");
     $data->execute();
     $array = $data->fetchAll();
     return $array;
  }

  public function insertTableAdmin()//Запись в таблицу
  {
    $cells = $this->cells;
    $connection = $this->connection;

    $str='';
    foreach ($cells as $key => $cell)
    {
      $str=$str . '`' . $key . '` = :' . $key . ', ';
    }
    $str=rtrim($str, ', ');
    $str = $str . ', `role` = :role, `dates` = :dates';

    $execute=[];

    $dates = date("Y-m-d");
    $execute = array_merge($cells, ['role' => 97], ['dates' => $dates]);

    $data = $connection->prepare("INSERT INTO `admins` SET $str");
    $data->execute($execute);
  }

  public function updateTableAdmin()//Запись в таблицу с условием
  {
    $cells = $this->cells;
    $wheres = $this->wheres;
    $connection = $this->connection;

    $str='';
    foreach ($cells as $key => $cell)
    {
      $str=$str . '`' . $key . '` = :' . $key . ', ';
    }
    $str=rtrim($str, ', ');

    $strWhere='';
    foreach ($wheres as $key => $cell)
    {
      $strWhere=$strWhere . '`' . $key . '` = :' . $key . ', ';
    }
    $strWhere=rtrim($strWhere, ', ');

    $execute = [];
    $execute = array_merge($cells, $wheres);

    $data = $connection->prepare("UPDATE `admins` SET $str WHERE $strWhere  LIMIT 1");
    $data->execute($execute);
  }

  public function delAdmin()
  {
    $cells = $this->cells;
    $connection = $this->connection;

    $whereStr='';
    foreach ($cells as $key => $cell)
    {
      $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
    }
    $whereStr=rtrim($whereStr, 'AND ');

    $data = $connection->prepare("DELETE FROM `admins` WHERE $whereStr LIMIT 1");
    $data->execute($cells);
  }
}
