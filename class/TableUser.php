<?php
class TableUser
{
  public $cells;
  public $connection;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  public function selectTableUser()//выбор из таблицы
  {
     $cells = $this->cells;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT * FROM `users` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function insertTableUser()//Запись в таблицу
  {
    $cells = $this->cells;
    $connection = $this->connection;

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

    $data = $connection->prepare("INSERT INTO `users` SET $str");
    $data->execute($execute);
  }
}
