<?php
class TableAnswer
{
  public $cells;
  public $connection;
  public $wheres;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  public function selectTableAnswer()//выбор из таблицы
  {
     $cells = $this->cells;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT * FROM `answers` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function insertTableAnswer()//Запись в таблицу
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
      $str = $str . ', `dates` = :dates, `idAdmin` = :idAdmin';

      $execute=[];

      $dates = date("Y-m-d");
      $execute = array_merge($cells, ['dates' => $dates], ['idAdmin' => $_SESSION['idAdmin']]);

      $data = $connection->prepare("INSERT INTO `answers` SET $str");
      $data->execute($execute);
    } else {
      $auto = 'Ошибка! Параметр не задан.';
    }
  }

  public function countTableAnswer()//выбор из таблицы
  {
     $cells = $this->cells;
     $count = $this->count;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT $count FROM `answers` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function delAnswer()
  {
    $cells = $this->cells;
    $connection = $this->connection;

    $whereStr='';
    foreach ($cells as $key => $cell)
    {
      $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
    }
    $whereStr=rtrim($whereStr, 'AND ');

    $data = $connection->prepare("DELETE FROM `answers` WHERE $whereStr");
    $data->execute($cells);
  }

  public function updateTableAnswer()//Запись в таблицу с условием
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

    $data = $connection->prepare("UPDATE `answers` SET $str WHERE $strWhere  LIMIT 1");
    $data->execute($execute);
  }
}
