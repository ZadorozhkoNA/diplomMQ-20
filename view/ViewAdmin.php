<?php
class ViewAdmin
{
  public $arraySelectAdmin;

  public function __construct($arraySelectAdmin)
  {
    $this->arraySelectAdmin = $arraySelectAdmin;
  }

  function tableAdmin()
  {
    $arraySelectAdmin = $this->arraySelectAdmin;
    ?>
    <h2>Список администраторов</h2>
    <table border=1>
    <tr>
      <th>№</th>
      <th>Ник</th>
      <th>&nbsp</th>
      <th>&nbsp</th>
    </tr>

    <?php
    $i=0;
    foreach ($arraySelectAdmin as $admin)
    {
      ?>
        <tr>
          <td><?php echo $i=$i+1;?></td>
          <td><?php echo $admin['nameAdmin'];?></td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idAdmin" value="<?php echo $admin['idAdmin'];?>">
              <input type="hidden" name="switch" value="<?php echo $_POST['switch']  ?>">
              <input type="hidden" name="del" value="1">
              <input type="submit" value="Удалить?">
            </form>
          </td>
          <td>
            <form action= "index.php" method= "POST">
              <input type="hidden" name="idAdmin" value="<?php echo $admin['idAdmin'];?>">
              <input type="hidden" name="switch" value="<?php echo $_POST['switch']  ?>">
              <input type="hidden" name="edit" value="1">
              <input type="submit" value="Редактировать">
            </form>
          </td>
        </tr>
      <?php
    }
    ?>
    </table>
    <?php
  }
}
