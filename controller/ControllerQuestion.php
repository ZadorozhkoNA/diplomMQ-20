<?php
class ControllerQuestion
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

  function deleteQuestion($idQuestion) {
    $this->idQuestion = $idQuestion;
    $idQuestion = $this->idQuestion;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableQuestion = new TableQuestion($connection);//Удалить вопрос
    $arrayTableQuestion->cells=['idQuestion' => $idQuestion];
    $arrayTableQuestion->delQuestion();

    $arrayTableAnswer = new TableAnswer($connection);//Удалить ответы в вопросе
    $arrayTableAnswer->cells=['idQuestion' => $idQuestion];
    $arrayTableAnswer->delAnswer();
  }

  function hiddenQuestion($idQuestion, $hidden) {
    $this->idQuestion = $idQuestion;
    $this->hidden = $hidden;
    $idQuestion = $this->idQuestion;
    $hidden = $this->hidden;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableQuestion = new TableQuestion($connection);
    $arrayTableQuestion->cells=['hidden' => $hidden];
    $arrayTableQuestion->wheres=['idQuestion' => $idQuestion];
    $arrayTableQuestion->updateTableQuestion();
  }

  function updateQuestion($idQuestion, $newQuestion) {
    $this->idQuestion = $idQuestion;
    $this->newQuestion = $newQuestion;
    $idQuestion = $this->idQuestion;
    $newQuestion = $this->newQuestion;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableQuestion = new TableQuestion($connection);
    $arrayTableQuestion->cells=['question' => $newQuestion];
    $arrayTableQuestion->wheres=['idQuestion' => $idQuestion];
    $arrayTableQuestion->updateTableQuestion();
  }

  function swapQuestion($idQuestion, $idTopic) {
    $this->idQuestion = $idQuestion;
    $this->idTopic = $idTopic;
    $idQuestion = $this->idQuestion;
    $idTopic = $this->idTopic;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    //переписать вопрос
    $arrayTableQuestion = new TableQuestion($connection);
    $arrayTableQuestion->cells=['idTopic' => $idTopic];
    $arrayTableQuestion->wheres=['idQuestion' => $idQuestion];
    $arrayTableQuestion->updateTableQuestion();

    //переписать все ответы этого вопроса под другую тему
    $arrayTableAnswer = new TableAnswer($connection);
    $arrayTableAnswer->cells=['idTopic' => $idTopic];
    $arrayTableAnswer->wheres=['idQuestion' => $idQuestion];
    $arrayTableAnswer->updateTableAnswer();
  }

  function createQuestion($newQuestion, $idTopic) {
    $this->idTopic = $idTopic;
    $this->newQuestion = $newQuestion;
    $idTopic = $this->idTopic;
    $newQuestion = $this->newQuestion;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableQuestion = new TableQuestion($connection);
    $arrayTableQuestion->cells = ['question' => $newQuestion, 'idTopic' => $idTopic];
    $arrayTableQuestion->insertTableQuestion();
  }
}
