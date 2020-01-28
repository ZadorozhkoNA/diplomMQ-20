<?php
class TableTopic
{
  public $connection;
  public $cells;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  public function insertTableTopic()//Запись в таблицу
  {
    $cells = $this->cells;
    $connection = $this->connection;

    if (isset($cells) and !empty($cells))
    {
      $str='';
      foreach ($cells as $key => $cell)
      {
        $str=$str . '`' . $key . '` = :' . $key . ', ';
      }
      $str=rtrim($str, ', ');
      $str = $str . ', `dates` = :dates';

      $execute=[];

      $dates = date("Y-m-d");
      $execute = array_merge($cells, ['dates' => $dates]);

      $data = $connection->prepare("INSERT INTO `topics` SET $str");
      $data->execute($execute);
    } else {
      $auto = 'Ошибка! Параметр не задан.';
    }
  }

  public function selectAllTopic()//выбор из таблицы всех строк
  {
     $connection = $this->connection;

     $data = $connection->prepare("SELECT * FROM `topics` ORDER BY `dates` ASC");
     $data->execute();
     $array = $data->fetchAll();
     return $array;
  }

  public function delTopic()
  {
    $cells = $this->cells;
    $connection = $this->connection;

    $whereStr='';
    foreach ($cells as $key => $cell)
    {
      $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
    }
    $whereStr=rtrim($whereStr, 'AND ');

    $data = $connection->prepare("DELETE FROM `topics` WHERE $whereStr LIMIT 1");
    $data->execute($cells);
  }

  public function updateTableTopic()//Запись в таблицу с условием
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

    $data = $connection->prepare("UPDATE `topics` SET $str WHERE $strWhere  LIMIT 1");
    $data->execute($execute);
  }

  public function selectTableTopic()//выбор из таблицы
  {
     $cells = $this->cells;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT * FROM `topics` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }
}
