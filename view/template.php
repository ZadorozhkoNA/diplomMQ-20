<!DOCTYPE html>
<html lang="ru">
	<head>
		<meta charset="UTF-8">
		<title>PHP-27: Дипломная работа</title>
    <link rel="stylesheet" href="diplom.css">
	</head>
	<body>
		<div class="background">
			<div class="center">
		    <header>
		      <h1>Дипломная работа по курсу PHP</h1>
		    </header>
		    <nav>
					<?php
						$menuButton = new FormMenu;
						if (isset($_SESSION['idAdmin']))
						{
							$menuButton->formMenuAdmin();
							$menuButton->formMenuTopic();
							$menuButton->formMenuQuestion();
						}

						if (isset($_SESSION['idUser']))
						{
							$menuButton->formMenuTopic();
						}

							$menuButton->formMenuExit();
					?>
		    </nav>
		    <main>

          <?php
					if (isset($_SESSION['idAdmin']))
					{
						echo 'Вы вошли как ' . $_SESSION['nameAdmin'] . ' с правами администратора';
					}

					if (isset($_SESSION['idUser']))
					{
						echo 'Вы вошли как ' . $_SESSION['nameUser'];
					}

					if (empty($_SESSION['idAdmin']) and empty($_SESSION['idUser']))//если нет Юзера или Админа, грузим авторизацию
					{
						$autoForm = new FormReg();
						$autoForm->formAutoAdmin();
						$autoForm->formAutoUser();
						$autoForm->formRegUser();
					}

					//$del === 1 - Подтвердить удаление
					//$edit === 1 - Форма редактирования
					//$swap === 1 - Переписать вопрос в другую тему
					//$switch === 1 - Выход
					//$switch === 2 - Администраторы
					//$switch === 3 - Темы
					//$switch === 4 - Вопросы
					//$switch === 5 - Ответы
					//$switch === 6 - Вопросы без ответов

					if (isset($del) and $del===1)//Вывод формы перед удалением
					{
						$formDel = new FormDel;
						if (isset($_POST['idAdmin']))//Подтвердить удаление администратора
						{
							$formDel->formDelAdmin();
						}
						if (isset($_POST['idTopic']) and !isset($_POST['idQuestion']) and !isset($_POST['idAnswer']))//Подтвердить удаление темы
						{
							$formDel->formDelTopic();
						}
						if (isset($_POST['idQuestion']) and !isset($_POST['idAnswer']))//Подтвердить удаление вопроса
						{
							$formDel->formDelQuestion();
						}
						if (isset($_POST['idAnswer']))//Подтвердить удаление ответа
						{
							$formDel->formDelAnswer();
						}
					}

					if (isset($edit) and $edit===1)//Вывод формы для редактирования
					{
						//Редактировать администратора
						if (isset($_POST['idAdmin']))
						{
							$arrayTableAdmin = new TableAdmin($connection);
							$arrayTableAdmin->cells=['idAdmin' => (int)clear($_POST['idAdmin'])];
							$arrayTableAdmin=$arrayTableAdmin->selectTableAdmin();
							$_POST['nameAdmin'] = $arrayTableAdmin[0]['nameAdmin'];
							$_POST['passAdmin'] = $arrayTableAdmin[0]['passAdmin'];

							$formEdit = new FormEdit;
							$formEdit->formEditAdmin();
						}

						//Редактировать тему
						if (isset($_POST['idTopic']))
						{
							$arrayTableTopic = new TableTopic($connection);
							$arrayTableTopic->cells=['idTopic' => (int)clear($_POST['idTopic'])];
							$arrayTableTopic=$arrayTableTopic->selectTableTopic();
							$_POST['topic'] = $arrayTableTopic[0]['topic'];

							$formEdit = new FormEdit;
							$formEdit->formEditTopic();
						}

						//Редактировать вопрос
						if (isset($_POST['idQuestion']))
						{
							$arrayTableQuestion = new TableQuestion($connection);
							$arrayTableQuestion->cells=['idQuestion' => (int)clear($_POST['idQuestion'])];
							$arrayTableQuestion=$arrayTableQuestion->selectTableQuestion();
							$_POST['question'] = $arrayTableQuestion[0]['question'];
							$_POST['idTopic'] = $arrayTableQuestion[0]['idTopic'];

							$formEdit = new FormEdit;
							$formEdit->formEditQuestion();
						}

						//Редактировать ответ
						if (isset($_POST['idAnswer']))
						{
							$arrayTableAnswer = new TableAnswer($connection);
							$arrayTableAnswer->cells=['idAnswer' => (int)clear($_POST['idAnswer'])];
							$arrayTableAnswer=$arrayTableAnswer->selectTableAnswer();
							$_POST['answer'] = $arrayTableAnswer[0]['answer'];
							$_POST['idTopic'] = $arrayTableAnswer[0]['idTopic'];
							$_POST['idQuestion'] = $arrayTableAnswer[0]['idQuestion'];

							$formEdit = new FormEdit;
							$formEdit->formEditAnswer();
						}

					}

					if (isset($switch) and $switch === 1)//выход
					{
						session_destroy();
						header('Location: index.php');
					}

					if (isset($switch) and $switch === 2)//Администраторы
					{
						$arrayTableAdmin = new TableAdmin($connection);//Вывод всех администраноров
					  $arrayTableAdmin = $arrayTableAdmin -> selectAllAdmin();

					  $tableAllAdmin = new ViewAdmin($arrayTableAdmin);
					  $tableAllAdmin->tableAdmin();//Формирование таблицы всех админов с кнопкой создания нового

						$autoForm = new FormReg();//Вызов кнопки для регистрации нового админа
						$autoForm->formRegAdmin();
					}

					if (isset($switch) and $switch === 3)//Темы
					{
						$arrayTableTopic = new TableTopic($connection);//Вывод всех тем
					  $arrayTableTopic = $arrayTableTopic -> selectAllTopic();

						$tableAllTopic = new ViewTopic($arrayTableTopic);
						$allQuestion = new TableQuestion($connection);
						$tableAllTopic->tableTopicForAdmin();

						if (isset($_SESSION['idAdmin']))//Показывать только если Администратор
	            {
								$formCreate = new FormCreate;
								$formCreate->formCreateTopic();
							}
					}

					if (isset($switch) and $switch === 4)//Вопросы
					{
						$arrayTableTopic = new TableTopic($connection);//Вывод темы
						$arrayTableTopic->cells = ['idTopic' => clear($_POST['idTopic'])];
					  $arrayTableTopic = $arrayTableTopic -> selectTableTopic();
						?>
						<h2>Тема: <?php echo $arrayTableTopic[0]['topic'] ?></h2>
						<?php
						//Выборка всех вопросов для администратора
						if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)
						{
							$arraySelectQuestion = new TableQuestion($connection);//Выбор вопросов в одной теме
							$arraySelectQuestion->cells = ['idTopic' => clear($_POST['idTopic'])];
							$arraySelectQuestion = $arraySelectQuestion -> selectTableQuestion();
						}

						//Выборка только открытых вопросов для юзера
						if (isset($_SESSION['idUser']))
						{
							$arraySelectQuestion = new TableQuestion($connection);//Выбор вопросов в одной теме
							$arraySelectQuestion->cells = ['idTopic' => clear($_POST['idTopic']), 'hidden' => 1];
							$arraySelectQuestion = $arraySelectQuestion -> selectTableQuestion();
						}

						$arrayTableQuestion = new ViewQuestion($arraySelectQuestion);
						$arrayTableQuestion->tableQuestion();

						$formCreate = new FormCreate;
						$formCreate->formCreateQuestion();
					}

					if (isset($switch) and $switch === 5)//Ответы
					{
						$arrayTableTopic = new TableTopic($connection);//Вывод темы
						$arrayTableTopic->cells = ['idTopic' => clear($_POST['idTopic'])];
					  $arrayTableTopic = $arrayTableTopic -> selectTableTopic();
						?>
						<h2>Тема: <?php echo $arrayTableTopic[0]['topic'] ?></h2>
						<?php
						$arraySelectQuestion = new TableQuestion($connection);//Выбор вопроса
						$arraySelectQuestion->cells = ['idQuestion' => clear($_POST['idQuestion'])];
						$arraySelectQuestion = $arraySelectQuestion -> selectTableQuestion();
						?>
						<h2>Вопрос: <?php echo $arraySelectQuestion[0]['question'] ?></h2>
						<?php

						$arraySelectAnswer = new TableAnswer($connection);//Выбор ответов к одному вопросу
						$arraySelectAnswer->cells = ['idQuestion' => clear($_POST['idQuestion'])];
						$arraySelectAnswer = $arraySelectAnswer -> selectTableAnswer();

						$arrayTableAnswer = new ViewAnswer($arraySelectAnswer);
						$arrayTableAnswer->tableAnswer();

						//Дать ответ может только администратор
						if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)
						{
							$formCreate = new FormCreate;
							$formCreate->formCreateAnswer();
						}
					}

					if (isset($switch) and $switch === 6)//Вопросы без ответов
					{
						$questionNonAnswer = new QuestionNonAnswer($connection);
						$questionNonAnswer = $questionNonAnswer->NonAnswer();

						$arrayTableQuestion = new ViewQuestion($questionNonAnswer);
						$arrayTableQuestion->tableQuestion();
					}

					if (isset($auto))//Сообщения о регистрации/авторизации
					{
						echo '<strong>' . $auto . '</strong>';
					}

          ?>


		    </main>
		    <footer>

		    </footer>
			</div>
		</div>

  </body>
</html>
