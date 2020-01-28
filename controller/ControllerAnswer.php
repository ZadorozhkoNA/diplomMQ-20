<?php
class ControllerAnswer
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

  function deleteAnswer($idAnswer) {
    $this->idAnswer = $idAnswer;
    $idAnswer = $this->idAnswer;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableAnswer = new TableAnswer($connection);//Удалить ответы в вопросе
    $arrayTableAnswer->cells=['idAnswer' => $idAnswer];
    $arrayTableAnswer->delAnswer();
  }

  function updateAnswer($idAnswer, $newAnswer) {
    $this->idAnswer = $idAnswer;
    $this->newAnswer = $newAnswer;
    $idAnswer = $this->idAnswer;
    $newAnswer = $this->newAnswer;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableAnswer = new TableAnswer($connection);
    $arrayTableAnswer->cells=['answer' => $newAnswer];
    $arrayTableAnswer->wheres=['idAnswer' => $idAnswer];
    $arrayTableAnswer->updateTableAnswer();
  }

  function createAnswer($newAnswer, $idQuestion, $idTopic) {
    $this->newAnswer = $newAnswer;
    $this->idQuestion = $idQuestion;
    $this->idTopic = $idTopic;
    $newAnswer = $this->newAnswer;
    $idQuestion = $this->idQuestion;
    $idTopic = $this->idTopic;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableAnswer = new TableAnswer($connection);
    $arrayTableAnswer->cells = ['answer' => $newAnswer, 'idQuestion' => $idQuestion, 'idTopic' => $idTopic];
    $arrayTableAnswer->insertTableAnswer();
  }
}
