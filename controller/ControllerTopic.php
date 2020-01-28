<?php
class ControllerTopic
{
  public $connection;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  //Автолоадер
  function autoLoad() {
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });
  }

  function deleteTopic($idTopic) {
    $this->idTopic = $idTopic;
    $idTopic = $this->idTopic;
    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableTopic = new TableTopic($connection);//Удалить тему
    $arrayTableTopic->cells=['idTopic' => $idTopic];
    $arrayTableTopic->delTopic();

    $arrayTableTopic = new TableQuestion($connection);//Удалить вопросы в теме
    $arrayTableTopic->cells=['idTopic' => $idTopic];
    $arrayTableTopic->delQuestion();

    $arrayTableAnswer = new TableAnswer($connection);//Удалить ответы в теме
    $arrayTableAnswer->cells=['idTopic' => $idTopic];
    $arrayTableAnswer->delAnswer();
  }

  function updateTopic($idTopic, $newTopic) {

    $this->idTopic = $idTopic;
    $this->newTopic = $newTopic;

    $idTopic = $this->idTopic;
    $newTopic = $this->newTopic;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableTopic = new TableTopic($connection);
    $arrayTableTopic->cells=['topic' => $newTopic];
    $arrayTableTopic->wheres=['idTopic' => $idTopic];
    $arrayTableTopic->updateTableTopic();
  }

  function createTopic($newTopic) {

    $this->newTopic = $newTopic;
    $newTopic = $this->newTopic;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableTopic = new TableTopic($connection);
    $arrayTableTopic->cells = ['topic' => $newTopic];
    $arrayTableTopic->insertTableTopic();
  }

}
