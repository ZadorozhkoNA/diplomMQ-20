<?php
class ViewAnswer
{
  public $arraySelectAnswer;

  public function __construct($arraySelectAnswer)
  {
    $this->arraySelectAnswer = $arraySelectAnswer;
  }

  public function tableAnswer()
  {
    global $connection;
    $arraySelectAnswer = $this->arraySelectAnswer;

    //Автолоадер
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });


    ?>
    <h3>Список ответов</h3>
    <table border=1>
    <tr>
      <th>№</th>
      <th>Ответ</th>
      <th>Автор</th>
      <?php
      if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор
        {
          ?>
          <th>Удалить</th>
          <th>Редактировать</th>
        <?php
        }
        ?>
    </tr>
    <?php
    $i=0;
    foreach ($arraySelectAnswer as $answer)
    {
      ?>
        <tr>
          <td><?php echo $i=$i+1;?></td>
          <td><?php echo $answer['answer'];?></td>
          <td>
            <?php
              if (isset($answer['idAdmin']))
              {
                $autor = new TableAdmin($connection);
                $autor->cells=['idAdmin' => $answer['idAdmin']];
                $autor = $autor -> selectTableAdmin();
                echo $autor[0]['nameAdmin'];
              }

              if (isset($answer['idUser']))
              {
                $autor = new TableAdmin($connection);
                $autor->cells=['idAUser' => $answer['idUser']];
                $autor = $autor -> selectTableAdmin();
                echo $autor[0]['nameUser'];
              }
            ?>
          </td>
          <?php
          if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор
            {
              ?>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idTopic" value="<?php echo $answer['idTopic'];?>">
              <input type="hidden" name="idQuestion" value="<?php echo $answer['idQuestion'];?>">
              <input type="hidden" name="idAnswer" value="<?php echo $answer['idAnswer'];?>">
              <input type="hidden" name="switch" value="<?php echo $_POST['switch'];  ?>">
              <input type="hidden" name="del" value="1">
              <input type="submit" value="Удалить?">
            </form>
          </td>

          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idAnswer" value="<?php echo $answer['idAnswer'];?>">
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
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="4">
      <input type="hidden" name="idTopic" value="<?php echo $_POST['idTopic']; ?>">
      <input type="hidden" name="idQuestion" value="<?php echo $answer['idQuestion'];?>">
      <input type="submit" value="<- Назад к вопросам">
    </form>
    <?php
  }
}
