<?php
//var_dump($_POST);
// echo '<br/>';
// var_dump($_SESSION);
require_once __DIR__ . DIRECTORY_SEPARATOR . 'adminconnect.php';

function clear($a) //Функция очистки данных POST и GET
{
  if (!empty($a))
    {
      $rezult=htmlspecialchars(trim($a));
      return $rezult;
    }
  return null;
}

if (isset($_POST['switch']))
{
	$switch = (int)clear($_POST['switch']);
}

if (isset($_POST['edit']))
{
	$edit = (int)clear($_POST['edit']);
	unset($switch);
}

if (isset($_POST['editInsert']))
{
	$editInsert = (int)clear($_POST['editInsert']);
}

if (isset($_POST['del']))
{
	$del = (int)clear($_POST['del']);
	unset($switch);
}

if (isset($_POST['del2']))
{
	$del2 = (int)clear($_POST['del2']);
}

if (isset($_POST['create']))
{
	$create = (int)clear($_POST['create']);
}

if (isset($_POST['swapTopic']))
{
  $swap = (int)clear($_POST['swapTopic']);
}


if(session_id() === '')//Если сессии нет, то создать
{
    session_start();
}


//Автолоадер
spl_autoload_register(function ($class) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'model' . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }

    $path = __DIR__ . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }

    $path = __DIR__ . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR . $class . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

//Условия регистрации и авторизации
$arrayTableAdmin = new TableAdmin($connection);
$arrayTableUser = new TableUser($connection);
$autoriz = new Auto($arrayTableAdmin, $arrayTableUser);
$auto = $autoriz->autoReg();

//Создание объектов-контроллеров
$controllerAdmin = new ControllerAdmin($connection);
$controllerTopic = new ControllerTopic($connection);
$controllerQuestion = new ControllerQuestion($connection);
$controllerAnswer = new ControllerAnswer($connection);

//Блок удаления
if (isset($del2) and $del2===1)//Удаление
{
	if (isset($_POST['idAdmin']))//Удалить администратора
	{
    $idAdmin = (int)clear($_POST['idAdmin']);
    $controllerAdmin->deleteAdmin($idAdmin);
	}

  if (isset($_POST['idTopic']) and !isset($_POST['idQuestion']) and !isset($_POST['idAnswer']))//Удалить тему
  {
    $idTopic = (int)clear($_POST['idTopic']);
    $controllerTopic->deleteTopic($idTopic);
  }

  if (isset($_POST['idQuestion']) and !isset($_POST['idAnswer']))//Удалить вопрос
  {
    $idQuestion = (int)clear($_POST['idQuestion']);
    $controllerQuestion->deleteQuestion($idQuestion);
  }

  if (isset($_POST['idAnswer']))//Удалить ответ
  {
    $idAnswer = (int)clear($_POST['idAnswer']);
    $controllerAnswer->deleteAnswer($idAnswer);
  }
}

//Блок редактирования
if (isset($editInsert) and $editInsert===1)//Редактирование
{
    //Редактировать Администратора
	if (isset($_POST['idAdmin']) and !empty($_POST['idAdmin']) and isset($_POST['newNameAdmin']) and isset($_POST['newPassAdmin']))
	{
    $idAdmin = (int)clear($_POST['idAdmin']);
    $newNameAdmin = clear($_POST['newNameAdmin']);
    $newPassAdmin =  clear($_POST['newPassAdmin']);
    $controllerAdmin->updateAdmin($idAdmin, $newNameAdmin, $newPassAdmin);
	}

    //Редактировать Тему
  if (isset($_POST['idTopic']) and !empty($_POST['idTopic']) and isset($_POST['newTopic']) and !empty($_POST['newTopic']))
  {
    $idTopic = (int)clear($_POST['idTopic']);
    $newTopic = clear($_POST['newTopic']);
    $controllerTopic->updateTopic($idTopic, $newTopic);
  }

  //Редактировать Вопрос скрыть/показать
  if (isset($_POST['idQuestion']) and !empty($_POST['idQuestion']) and isset($_POST['hidden']))
  {
    $idQuestion = (int)clear($_POST['idQuestion']);
    $hidden = clear($_POST['hidden']);
    $controllerQuestion->hiddenQuestion($idQuestion, $hidden);
  }

  //Редактировать Вопрос
  if (isset($_POST['idQuestion']) and !empty($_POST['idQuestion']) and isset($_POST['newQuestion']) and !empty($_POST['newQuestion']))
  {
    $idQuestion = (int)clear($_POST['idQuestion']);
    $newQuestion = clear($_POST['newQuestion']);
    $controllerQuestion->updateQuestion($idQuestion, $newQuestion);
  }

  //Редактировать Ответ
  if (isset($_POST['idAnswer']) and !empty($_POST['idAnswer']) and isset($_POST['newAnswer']) and !empty($_POST['newAnswer']))
  {
    $idAnswer = (int)clear($_POST['idAnswer']);
    $newAnswer = clear($_POST['newAnswer']);
    $controllerAnswer->updateAnswer($idAnswer, $newAnswer);
  }
}

  //Блок переноса вопроса в другую тему
  if (isset($swap) and $swap === 1)
  {
    $idQuestion = (int)clear($_POST['idQuestion']);
    $idTopic = (int)clear($_POST['idTopic']);
    $controllerQuestion->swapQuestion($idQuestion, $idTopic);
  }

//Блок создания темб вопросов и ответов
if (isset($create) and $create===1)//Создание
{
  //Создать новую тему
  if(isset($_POST['topic']) and !empty($_POST['topic']))
  {
    $newTopic = clear($_POST['topic']);
    $controllerTopic->createTopic($newTopic);
  }
  //Создать новый вопрос
  if(isset($_POST['question']) and !empty($_POST['question']))
  {
    $newQuestion = clear($_POST['question']);
    $idTopic = (int)clear($_POST['idTopic']);
    $controllerQuestion->createQuestion($newQuestion, $idTopic);

    $auto = 'Ваш вопрос отправлен на модерацию';
  }
  //Создать новый ответ
  if(isset($_POST['answer']) and !empty($_POST['answer']))
  {
    $idTopic = (int)clear($_POST['idTopic']);
    $idQuestion = (int)clear($_POST['idQuestion']);
    $newAnswer = clear($_POST['answer']);
    $controllerAnswer->createAnswer($newAnswer, $idQuestion, $idTopic);
  }
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'view' . DIRECTORY_SEPARATOR . 'template.php';
