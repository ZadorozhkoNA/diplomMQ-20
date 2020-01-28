<?php
class FormEdit
{
  public function formEditAdmin()
  {
    ?><h3>Редактировать администратора <?php echo clear($_POST['nameAdmin']); ?> </h3>
      <form action= "index.php" method= "POST" >
        <input type="hidden" name="editInsert" value="1">
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <input type="hidden" name="idAdmin" value="<?php echo clear($_POST['idAdmin']); ?>">
        <input type="hidden" name="nameAdmin" value="<?php echo clear($_POST['nameAdmin']); ?>">
        <input type="hidden" name="passdmin" value="<?php echo clear($_POST['passAdmin']); ?>">
        <label><h4>Логин:</h4>
        <textarea name="newNameAdmin" cols="40" rows="3"><?php echo clear($_POST['nameAdmin']); ?></textarea>
        </label>
        <label><h4>Пароль:</h4>
        <textarea name="newPassAdmin" cols="40" rows="3"><?php echo clear($_POST['passAdmin']); ?></textarea>
        </label>
        <br/>
        <input type="submit" value="Редактировать">
      </form>

      <form action= "index.php" method= "POST" >
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <br/>
        <input type="submit" value="Отмена">
      </form>
    <?php
  }

  public function formEditTopic()
  {
    ?><h3>Редактировать тему:</h3>
      <p><?php echo clear($_POST['topic']); ?></p>
      <form action= "index.php" method= "POST" >
        <input type="hidden" name="editInsert" value="1">
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <input type="hidden" name="idTopic" value="<?php echo clear($_POST['idTopic']); ?>">
        <textarea name="newTopic" cols="40" rows="5"><?php echo clear($_POST['topic']); ?></textarea>
        <br/>
        <input type="submit" value="Редактировать">
      </form>

      <form action= "index.php" method= "POST" >
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <br/>
        <input type="submit" value="Отмена">
      </form>
    <?php
  }

  public function formEditQuestion()
  {
    global $connection;

    //Автолоадер
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });

    ?><h3>Редактировать вопрос:</h3>
      <p><?php echo clear($_POST['question']); ?></p>
      <form action= "index.php" method= "POST" >
        <input type="hidden" name="editInsert" value="1">
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <input type="hidden" name="idTopic" value="<?php echo clear($_POST['idTopic']); ?>">
        <input type="hidden" name="idQuestion" value="<?php echo clear($_POST['idQuestion']); ?>">
        <textarea name="newQuestion" cols="40" rows="5"><?php echo clear($_POST['question']); ?></textarea>
        <br/>
        <input type="submit" value="Редактировать">
      </form>

      <form action= "index.php" method= "POST" >
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <br/>
        <input type="submit" value="Отмена">
      </form>
    <?php

    $arrayTableTopic = new tableTopic($connection);
    $arrayTableTopic=$arrayTableTopic->selectAllTopic();

    ?>

    <h3>Поместить вопрос в другую тему?</h3>
    <table border=1>
    <tr>
      <th>№</th>
      <th>Тема</th>
      <th>Переписать в эту тему</th>
    </tr>
    <?php
    $i=0;

    foreach ($arrayTableTopic as $topic)
    {
      if ($topic['idTopic'] != $_POST['idTopic'])
      {
        $i++;
        ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td><?php echo $topic['topic']; ?></td>
          <td>
            <form action= "index.php" method= "POST" >
              <input type="hidden" name="swapTopic" value="1">
              <input type="hidden" name="switch" value="4">
              <input type="hidden" name="idTopic" value="<?php echo $topic['idTopic']; ?>">
              <input type="hidden" name="idQuestion" value="<?php echo clear($_POST['idQuestion']); ?>">
              <input type="submit" value="Переписать">
            </form>
          </td>
        </tr>
        <?php
      }
    }
    ?>
  </table>
    <?php
  }

  public function formEditAnswer()
  {
    ?><h3>Редактировать ответ:</h3>
      <p><?php echo clear($_POST['answer']); ?></p>
      <form action= "index.php" method= "POST" >
        <input type="hidden" name="editInsert" value="1">
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <input type="hidden" name="idTopic" value="<?php echo clear($_POST['idTopic']); ?>">
        <input type="hidden" name="idQuestion" value="<?php echo clear($_POST['idQuestion']); ?>">
        <input type="hidden" name="idAnswer" value="<?php echo clear($_POST['idAnswer']); ?>">
        <textarea name="newAnswer" cols="40" rows="5"><?php echo clear($_POST['answer']); ?></textarea>
        <br/>
        <input type="submit" value="Редактировать">
      </form>

      <form action= "index.php" method= "POST" >
        <input type="hidden" name="switch" value="<?php echo clear($_POST['switch']); ?>">
        <br/>
        <input type="submit" value="Отмена">
      </form>
    <?php
  }
}
