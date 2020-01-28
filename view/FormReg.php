<?php
class FormReg //Класс для создания формы записи
{

  public function formAutoAdmin()
  {
    ?>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="autoReg" placeholder="Имя" value="autoAdmin">
      <input type="text" name="nameAdmin" placeholder="Имя" value="">
      <input type="password" name="passAdmin" placeholder="Пароль" value="">
      <button>Авторизация администратора</button>
    </form>
    <?php
  }

  public function formRegAdmin()
  {
    ?>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="autoReg" placeholder="Имя" value="regAdmin">
      <input type="hidden" name="switch" value="<?php echo $_POST['switch']  ?>">
      <input type="text" name="nameAdmin" placeholder="Имя" value="">
      <input type="password" name="passAdmin" placeholder="Пароль" value="">
      <button>Регистрация администратора</button>
    </form>
    <?php
  }

  public function formRegUser()
  {
    ?>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="autoReg" placeholder="Имя" value="regUser">
      <input type="text" name="nameUser" placeholder="Имя" value="">
      <input type="text" name="mailUser" placeholder="Почта" value="">
      <button>Регистрация пользователя</button>
    </form>
    <?php
  }

  public function formAutoUser()
  {
    ?>
    <form action= "index.php" method= "POST" >
      <input type="hidden" name="autoReg" placeholder="Имя" value="autoUser">
      <input type="text" name="nameUser" placeholder="Имя" value="">
      <input type="text" name="mailUser" placeholder="Почта" value="">
      <button>Авторизация пользователя</button>
    </form>
    <?php
  }
}
