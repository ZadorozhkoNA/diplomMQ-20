<?php
class TableQuestion
{
  public $cells;
  public $connection;
  public $wheres;
  public $count;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  public function insertTableQuestion()//Запись в таблицу
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

      if(isset($_SESSION['idAdmin']))
      {
        $str = $str . ', `dates` = :dates, `hidden` = :hidden, `idAdmin` = :idAdmin';
      }

      if(isset($_SESSION['idUser']))
      {
        $str = $str . ', `dates` = :dates, `hidden` = :hidden, `idUser` = :idUser';
      }

      $execute=[];

      $dates = date("Y-m-d");
      if(isset($_SESSION['idAdmin']))
      {
        $execute = array_merge($cells, ['dates' => $dates], ['hidden' => NULL], ['idAdmin' => $_SESSION['idAdmin']]);
      }

      if(isset($_SESSION['idUser']))
      {
        $execute = array_merge($cells, ['dates' => $dates], ['hidden' => NULL], ['idUser' => $_SESSION['idUser']]);
      }

      $data = $connection->prepare("INSERT INTO `questions` SET $str");
      $data->execute($execute);
    } else {
      $auto = 'Ошибка! Параметр не задан.';
    }
  }

  public function selectTableQuestion()//выбор из таблицы
  {
     $cells = $this->cells;
     $connection = $this->connection;

     $whereStr='';
     foreach ($cells as $key => $cell)
     {
         $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
     }
     $whereStr=rtrim($whereStr, 'AND ');

     $data = $connection->prepare("SELECT * FROM `questions` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function countTableQuestion()//выбор из таблицы
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

     $data = $connection->prepare("SELECT $count FROM `questions` WHERE $whereStr ORDER BY `dates` ASC");
     $data->execute($cells);
     $array = $data->fetchAll();
     return $array;
  }

  public function delQuestion()//Удалить
  {
    $cells = $this->cells;
    $connection = $this->connection;

    $whereStr='';
    foreach ($cells as $key => $cell)
    {
      $whereStr=$whereStr . '`' . $key . '` = :' . $key . ' AND ';
    }
    $whereStr=rtrim($whereStr, 'AND ');

    $data = $connection->prepare("DELETE FROM `questions` WHERE $whereStr");
    $data->execute($cells);
  }

  public function updateTableQuestion()//Запись в таблицу с условием
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

    $data = $connection->prepare("UPDATE `questions` SET $str WHERE $strWhere  LIMIT 1");
    $data->execute($execute);
  }

  public function selectAllQuestion()//выбор из таблицы всех строк
  {
     $connection = $this->connection;

     $data = $connection->prepare("SELECT * FROM `questions` ORDER BY `dates` ASC");
     $data->execute();
     $array = $data->fetchAll();
     return $array;
  }
}
