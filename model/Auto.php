<?php
//Авторизация и регистрация пользователя
class Auto
{
  public $arrayTableAdmin;
  public $arrayTableUser;

  public function __construct($arrayTableAdmin, $arrayTableUser)
  {
    $this->arrayTableAdmin = $arrayTableAdmin;
    $this->arrayTableUser = $arrayTableUser;
  }

  function selectTableAdminAuto()
  {
    $arrayTableAdmin = $this->arrayTableAdmin;

    $arrayTableAdmin->cells=['nameAdmin' => clear($_POST['nameAdmin'])];
    $arraySelectAdmin = $arrayTableAdmin->selectTableAdmin();
    return $arraySelectAdmin;
  }

  function selectTableUserAuto()
  {
    $arrayTableUser = $this->arrayTableUser;

    $arrayTableUser->cells=['nameUser' => clear($_POST['nameUser'])];
    $arraySelectUser = $arrayTableUser->selectTableUser();
    return $arraySelectUser;
  }

  function insertTableUserAuto()
  {
    $arrayTableUser = $this->arrayTableUser;

    $arrayTableUser->cells=['nameUser' => clear($_POST['nameUser']), 'mailUser' => clear($_POST['mailUser'])];
    $arrayTableUser->insertTableUser();
  }

  function insertTableAdminAuto()
  {
    $arrayTableAdmin = $this->arrayTableAdmin;

    $arrayTableAdmin->cells=['nameAdmin' => clear($_POST['nameAdmin']), 'passAdmin' => clear($_POST['passAdmin'])];
    $arrayTableAdmin->insertTableAdmin();
  }

  public function autoReg()
  {
    if (!empty($_POST['autoReg']) and clear($_POST['autoReg']) === 'regAdmin')//Регистрация Админа
    {
      if (!empty($_POST['nameAdmin']) and !empty($_POST['passAdmin']))
      {
        $arraySelectAdmin = $this->selectTableAdminAuto();

        if (!empty($arraySelectAdmin))
        {
          return 'Похоже, что такой администратор уже есть';
        }

        if (empty($arraySelectAdmin))
        {
          $this->insertTableAdminAuto();
          return 'Регистрация администратора (скорей всего) прошла успено, попробуйте пройдити авторизацию';
        }
      }
    }

    if (!empty($_POST['autoReg']) and clear($_POST['autoReg']) === 'autoAdmin')//Авторизация Админа
    {
      if (!empty($_POST['nameAdmin']) and !empty($_POST['passAdmin']))
      {
        $arraySelectAdmin = $this->selectTableAdminAuto();

        if (!empty($arraySelectAdmin))
        {
          $_SESSION['idAdmin'] = $arraySelectAdmin[0]['idAdmin'];
          $_SESSION['nameAdmin'] = $arraySelectAdmin[0]['nameAdmin'];
          $_SESSION['role'] = $arraySelectAdmin[0]['role'];
        } else {
          return 'Такого пользователя нет';
        }
      }
    }

    if (!empty($_POST['autoReg']) and clear($_POST['autoReg']) === 'regUser')//Регистрация Юзера
    {
      if (!empty($_POST['nameUser']) and !empty($_POST['mailUser']))
      {
        $arraySelectUser = $this->selectTableUserAuto();

        if (!empty($arraySelectUser))
        {
          return 'Похоже, что такой пользователь уже есть';
        }

        if (empty($arraySelectUser))
        {
          $this->insertTableUserAuto();
          return 'Регистрация пользователя (скорей всего) прошла успено, попробуйте пройдити авторизацию';
        }
      }
    }

    if (!empty($_POST['autoReg']) and clear($_POST['autoReg']) === 'autoUser')//Авторизация Юзера
    {
      if (!empty($_POST['nameUser']) and isset($_POST['mailUser']))
      {
        $arraySelectUser = $this->selectTableUserAuto();

        if (!empty($arraySelectUser))
        {
          $_SESSION['idUser'] = $arraySelectUser[0]['idUser'];
          $_SESSION['nameUser'] = $arraySelectUser[0]['nameUser'];
        } else {
          return 'Такого пользователя нет';
        }
      }
    }
  }
}
