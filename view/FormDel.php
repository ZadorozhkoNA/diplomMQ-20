<?php
class FormDel
{
  public function formDelAdmin()
  {
    ?>
    <h3>Точно удалить администратора?</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="idAdmin" value="<?php echo (int)clear($_POST['idAdmin']); ?>">
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="hidden" name="del2" value="1">

      <input type="submit" value="ДА">
    </form>
    <br/>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="submit" value="НЕТ">
    </form>
    <?php
  }

  public function formDelTopic()
  {
    ?>
    <h3>Точно удалить тему?</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="idTopic" value="<?php echo (int)clear($_POST['idTopic']); ?>">
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="hidden" name="del2" value="1">

      <input type="submit" value="ДА">
    </form>
    <br/>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="submit" value="НЕТ">
    </form>
    <?php
  }

  public function formDelQuestion()
  {
    ?>
    <h3>Точно удалить вопрос?</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="idQuestion" value="<?php echo (int)clear($_POST['idQuestion']); ?>">
      <input type="hidden" name="idTopic" value="<?php echo (int)clear($_POST['idTopic']); ?>">
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="hidden" name="del2" value="1">

      <input type="submit" value="ДА">
    </form>
    <br/>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="submit" value="НЕТ">
    </form>
    <?php
  }

  public function formDelAnswer()
  {
    ?>
    <h3>Точно удалить ответ?</h3>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="idAnswer" value="<?php echo (int)clear($_POST['idAnswer']); ?>">
      <input type="hidden" name="idQuestion" value="<?php echo (int)clear($_POST['idQuestion']); ?>">
      <input type="hidden" name="idTopic" value="<?php echo (int)clear($_POST['idTopic']); ?>">
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="hidden" name="del2" value="1">

      <input type="submit" value="ДА">
    </form>
    <br/>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="switch" value="<?php echo (int)clear($_POST['switch']);  ?>">
      <input type="submit" value="НЕТ">
    </form>
    <?php
  }
}
