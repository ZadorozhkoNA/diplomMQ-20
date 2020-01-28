<?php
class ViewTopic
{
  public $arraySelectTopic;

  public function __construct($arraySelectTopic)
  {
    $this->arraySelectTopic = $arraySelectTopic;
  }

  public function tableTopicForAdmin()
  {
    global $connection;
    $arraySelectTopic = $this->arraySelectTopic;

    //Автолоадер
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });

    ?>
    <h3>Список тем</h3>
    <table border=1>
    <tr>
      <th>№</th>
      <th>Тема</th>
      <th>Задать вопрос</th>
      <th>Воросы</th>
      <?php
      if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор
        {
          ?>
          <th>Видно</th>
          <th>Скрыто</th>
          <th>Удалить</th>
          <th>Редактировать</th>
          <?php
        }
      ?>
    </tr>
    <?php
    $i=0;
    foreach ($arraySelectTopic as $topic)
    {
      ?>
        <tr>
          <td><?php echo $i=$i+1;?></td>
          <td><?php echo $topic['topic'];?></td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idTopic" value="<?php echo $topic['idTopic'];?>">
              <input type="hidden" name="switch" value="4">
                <input type="submit" value="Посмотреть вопросы">
            </form>
          </td>
          <?php
          if (isset($_SESSION['idUser']))//Показывать только если Юзер подсчет только видимых вопросов
            {
              ?>
            <td>
              <?php
              $countQuestions = new  TableQuestion($connection);
              $countQuestions->cells = ['idTopic' => $topic['idTopic'], 'hidden' => 1];
              $countQuestions->count = 'count(*)';
              $countQuestions=$countQuestions->countTableQuestion();
              $all = $countQuestions[0]['count(*)'];
              echo $all;
              ?>
            </td>
            <?php
            }
          if (isset($_SESSION['idAdmin']) and isset($_SESSION['role']) and $_SESSION['role'] === 97)//Показывать только если Администратор, интерфейс администратора
            {
              ?>
              <td>
                <?php
                $countQuestions = new  TableQuestion($connection);
                $countQuestions->cells = ['idTopic' => $topic['idTopic']];
                $countQuestions->count = 'count(*)';
                $countQuestions=$countQuestions->countTableQuestion();
                $all = $countQuestions[0]['count(*)'];
                echo $all;
                ?>
              </td>
              <td>
                <?php
                $countQuestions = new  TableQuestion($connection);
                $countQuestions->cells = ['idTopic' => $topic['idTopic'], 'hidden' => 1];
                $countQuestions->count = 'count(*)';
                $countQuestions=$countQuestions->countTableQuestion();
                $view = $countQuestions[0]['count(*)'];
                echo '<strong><span class="green">' . $view . '</span></strong>';
                ?>
              </td>
              <td> <?php echo '<strong><span class="red">' . ($all - $view) . '</span></strong>'; ?> </td>
              <td>
                <form action= "index.php" method= "POST">
                  <input type="hidden" name="idTopic" value="<?php echo $topic['idTopic'];?>">
                  <input type="hidden" name="switch" value="<?php echo $_POST['switch']  ?>">
                  <input type="hidden" name="del" value="1">
                  <input type="submit" value="Удалить?">
                </form>
              </td>
              <td>
                <form action= "index.php" method= "POST">
                  <input type="hidden" name="idTopic" value="<?php echo $topic['idTopic'];?>">
                  <input type="hidden" name="switch" value="<?php echo $_POST['switch']  ?>">
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
    <?php
  }
}
