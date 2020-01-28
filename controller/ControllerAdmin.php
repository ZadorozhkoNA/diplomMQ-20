<?php
class ControllerAdmin
{
  public $connection;

  public function __construct($connection)
  {
    $this->connection = $connection;
  }

  //Автолоадер
  function autoLoad() {
    spl_autoload_register(function ($class) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($path)) {
            require_once $path;
        }
    });
  }

  function deleteAdmin($idAdmin) {
    $this->idAdmin = $idAdmin;
    $idAdmin = $this->idAdmin;

    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableAdmin = new TableAdmin($connection);
		$arrayTableAdmin->cells=['idAdmin' => $idAdmin];
		$arrayTableAdmin->delAdmin();
  }

  function updateAdmin($idAdmin, $newName, $newPass) {

    $this->idAdmin = $idAdmin;
    $this->newName = $newName;
    $this->newPass = $newPass;

    $idAdmin = $this->idAdmin;
    $newName = $this->newName;
    $newPass = $this->newPass;
    $connection = $this->connection;

    $autoLoad = $this->autoLoad();

    $arrayTableAdmin = new TableAdmin($connection);
		$arrayTableAdmin->cells=['nameAdmin' => $newName, 'passAdmin' => $newPass];
		$arrayTableAdmin->wheres=['idAdmin' => $idAdmin];
		$arrayTableAdmin->updateTableAdmin();

  }

}
