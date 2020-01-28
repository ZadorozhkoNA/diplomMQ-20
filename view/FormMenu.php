<?php
class FormMenu //Класс создания кнопок меню
{
  public function formMenuExit()
  {
    ?>
    <form action= "index.php" method= "POST" ><!--Форма выхода -->
      <input type="hidden" name="switch" value="1">
      <button class="button">Выход</button>
    </form>
    <?php
  }

  public function formMenuAdmin()
  {
    ?>
    <form action= "index.php" method= "POST" ><!--Форма Администраторов -->
      <input type="hidden" name="switch" value="2">
      <button class="button">Администраторы</button>
    </form>
    <?php
  }

  public function formMenuTopic()
  {
    ?>
    <form action= "index.php" method= "POST" ><!--Форма Тем -->
      <input type="hidden" name="switch" value="3">
      <button class="button">Темы, вопросы, ответы</button>
    </form>
    <?php
  }

  public function formMenuQuestion()
  {
    ?>
    <form action= "index.php" method= "POST" ><!--Форма Тем -->
      <input type="hidden" name="switch" value="6">
      <button class="button">Вопросы без ответа</button>
    </form>
    <?php
  }
}
