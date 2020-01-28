<?php
class FormCreate
{
  public function formCreateTopic()//Создание новой темы
  {
    ?>
    <h3>Создание новой темы</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo $_POST['switch']; ?>">
      <input type="hidden" name="create" value="1">
      <textarea name="topic" cols="40" rows="5"></textarea>
      <button>Новая тема</button>
    </form>
    <?php
  }

  public function formCreateQuestion()//Создание нового вопроса
  {
    ?>
    <h3>Задать новый вопрос</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo $_POST['switch']; ?>">
      <input type="hidden" name="idTopic" value="<?php echo $_POST['idTopic']; ?>">
      <input type="hidden" name="create" value="1">
      <textarea name="question" cols="40" rows="5"></textarea>
      <button>Новый вопрос</button>
    </form>
    <?php
  }

  public function formCreateAnswer()//Создание нового ответа
  {
    ?>
    <h3>Дать ответ</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo $_POST['switch']; ?>">
      <input type="hidden" name="idTopic" value="<?php echo $_POST['idTopic']; ?>">
      <input type="hidden" name="idQuestion" value="<?php echo $_POST['idQuestion']; ?>">
      <input type="hidden" name="create" value="1">
      <textarea name="answer" cols="40" rows="5"></textarea>
      <button>Новый ответ</button>
    </form>
    <?php
  }
}
