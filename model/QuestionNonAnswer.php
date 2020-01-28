<?php
class QuestionNonAnswer
{
  public $connection;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  function NonAnswer()
  {
    $connection = $this->connection;
    //Автолоадер
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });

    $array = [];

    $arrayAllQuestion = new TableQuestion($connection);
    $arrayAllQuestion = $arrayAllQuestion->selectAllQuestion();

    foreach ($arrayAllQuestion  as $question)
    {
      $questionNonAnswe = [];

      $questionNonAnswer = new TableAnswer($connection);
      $questionNonAnswer->cells = ['idQuestion' => $question['idQuestion']];
      $questionNonAnswe = $questionNonAnswer->selectTableAnswer();

      if(empty($questionNonAnswe))
      {
        array_push($array, $question);
      }
    }
  return $array;
  }
}
