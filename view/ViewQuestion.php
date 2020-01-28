<?php
class ViewQuestion
{
  public $arraySelectQuestion;

  public function __construct($arraySelectQuestion)
  {
    $this->arraySelectQuestion = $arraySelectQuestion;
  }
  public function tableQuestion()
  {
    global $connection;
    $arraySelectQuestion = $this->arraySelectQuestion;

    //Автолоадер
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });

    ?>
    <h3>Список вопросов</h3>
    <table border=1>
    <tr>
      <th>№</th>
      <th>Вопрос</th>
      <th>Автор</th>
      <th>Ответов</th>
      <th>Ответы</th>
      <?php
      if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор
        {
        ?>
          <th>Скрытность</th>
          <th>Удалить</th>
          <th>Редактировать</th>
        <?php
        }
        ?>
    </tr>
    <?php
    $i=0;
    foreach ($arraySelectQuestion as $question)
    {
      ?>
        <tr>
          <td><?php echo $i=$i+1;?></td>
          <td><?php echo $question['question'];?></td>
          <td>
            <?php
              if (isset($question['idAdmin']))
              {
                $autor = new TableAdmin($connection);
                $autor->cells=['idAdmin' => $question['idAdmin']];
                $autor = $autor -> selectTableAdmin();
                echo $autor[0]['nameAdmin'];
              }

              if (isset($question['idUser']))
              {
                $autor = new TableUser($connection);
                $autor->cells=['idUser' => $question['idUser']];
                $autor = $autor -> selectTableUser();
                echo $autor[0]['nameUser'];
              }
            ?>
          </td>
          <td>
            <?php
            $countAnswer = new  TableAnswer($connection);
            $countAnswer->cells = ['idQuestion' => $question['idQuestion']];
            $countAnswer->count = 'count(*)';
            $countAnswer=$countAnswer->countTableAnswer();
            $all = $countAnswer[0]['count(*)'];
            echo $all;
            ?>
          </td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idTopic" value="<?php echo $question['idTopic'];?>">
              <input type="hidden" name="idQuestion" value="<?php echo $question['idQuestion'];?>">
              <input type="hidden" name="switch" value="5">
                <input type="submit" value="Смотреть ответы">
            </form>
          </td>
          <?php
          if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор
            {
            ?>
          <td>
              <?php
                if ($question['hidden']===1)
                {
                  $hidden=0;
                  $button='<span class="red">Скрыть?</span>';
                } else {
                  $hidden=1;
                  $button='<span class="green">Показать?</span>';
                }
              ?>
              <form action= "index.php" method= "POST">
                <input type="hidden" name="idQuestion" value="<?php echo $question['idQuestion'];?>">
                <input type="hidden" name="idTopic" value="<?php echo $question['idTopic'];?>">
                <input type="hidden" name="hidden" value="<?php echo $hidden;?>">
                <input type="hidden" name="switch" value="<?php echo $_POST['switch'];  ?>">
                <input type="hidden" name="editInsert" value="1">
                <button><?php echo $button;  ?></button>
              </form>

          </td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idQuestion" value="<?php echo $question['idQuestion'];?>">
              <input type="hidden" name="idTopic" value="<?php echo $question['idTopic'];?>">
              <input type="hidden" name="switch" value="<?php echo $_POST['switch'];  ?>">
              <input type="hidden" name="del" value="1">
              <input type="submit" value="Удалить?">
            </form>
          </td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idQuestion" value="<?php echo $question['idQuestion'];?>">
              <input type="hidden" name="switch" value="<?php echo $_POST['switch'];  ?>">
              <input type="hidden" name="edit" value="1">
              <input type="submit" value="Редактировать">
            </form>
          </td>
        </tr>
      <?php
      }
    }
    ?>
    </table>
    <?php if ((int)$_POST['switch'] != 6)
    {
      ?>
      <form action= "index.php" method= "POST" >
        <input type="hidden" name="switch" value="3">
        <input type="hidden" name="idTopic" value="<?php echo $_POST['idTopic']; ?>">
        <input type="submit" value="<- Назад к темам">
      </form>
      <?php
    }
  }
}
