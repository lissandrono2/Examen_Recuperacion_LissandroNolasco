<?php
namespace Controllers\Users;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Users\Users as UsersDao;
use Utilities\Site;
use Utilities\Validators;

class UserForm extends PublicController
{
  private $viewData = [];
  private $mode = "DSP";
  private $modeDescriptions = [
    "DSP" => "Detalle de %s %s",
    "INS" => "Nuevo Usuario",
    "UPD" => "Editar %s %s",
    "DEL" => "Eliminar %s %s"
  ];
  private $readonly = "";
  private $showCommitBtn = true;
  private $user = [
    "usercod" => 0,
    "useremail" => "",
    "username" => "",
    "userpswd" => "",
    "userest" => "ACT",
    "usertipo" => "PBL"
  ];
  private $user_xss_token = "";

  public function run(): void
  {
    try {
      $this->getData();
      if ($this->isPostBack()) {
        if ($this->validateData()) {
          $this->handlePostAction();
        }
      }
      $this->setViewData();
      Renderer::render("users/user", $this->viewData);
    } catch (\Exception $ex) {
      Site::redirectToWithMsg(
        "index.php?page=Users_UserList",
        $ex->getMessage()
      );
    }
  }

  private function getData()
  {
    $this->mode = $_GET["mode"] ?? "NOF";
    if (isset($this->modeDescriptions[$this->mode])) {
      $this->readonly = $this->mode === "DEL" ? "readonly" : "";
      $this->showCommitBtn = $this->mode !== "DSP";
      if ($this->mode !== "INS") {
        if (isset($_GET["usercod"]) && is_numeric($_GET["usercod"])) {
            $usercod = intval($_GET["usercod"]);
            $this->user = UsersDao::getUserById($usercod);
        } else {
            // Manejo del caso en el que $_GET["usercod"] no está definido o no es un número válido
        }
        if (!$this->user) {
          throw new \Exception("No se encontró el Usuario", 1);
        }
      }
    } else {
      throw new \Exception("Formulario cargado en modalidad invalida", 1);
    }
  }

  private function validateData()
  {
    $errors = [];
    $this->user_xss_token = $_POST["user_xss_token"] ?? "";
    $this->user["usercod"] = intval($_POST["usercod"] ?? "");
    $this->user["useremail"] = strval($_POST["useremail"] ?? "");
    $this->user["username"] = strval($_POST["username"] ?? "");
    $this->user["userpswd"] = strval($_POST["userpswd"] ?? "");
    $this->user["userest"] = strval($_POST["userest"] ?? "");
    $this->user["usertipo"] = strval($_POST["usertipo"] ?? "");

    if (Validators::IsEmpty($this->user["useremail"])) {
      $errors["useremail_error"] = "El email del usuario es requerido";
    }

    if (Validators::IsEmpty($this->user["username"])) {
      $errors["username_error"] = "El nombre del usuario es requerido";
    }

    if (!in_array($this->user["userest"], ["ACT", "INA"])) {
      $errors["userest_error"] = "El estado del usuario es invalido";
    }

    if (count($errors) > 0) {
      foreach ($errors as $key => $value) {
        $this->user[$key] = $value;
      }
      return false;
    }
    return true;
  }

  private function handlePostAction()
  {
    switch ($this->mode) {
      case "INS":
        $this->handleInsert();
        break;
      case "UPD":
        $this->handleUpdate();
        break;
      case "DEL":
        $this->handleDelete();
        break;
      default:
        throw new \Exception("Modo invalido", 1);
        break;
    }
  }

  private function handleInsert()
  {
    $result = UsersDao::insertUser(
        $this->user["usercod"],
      $this->user["useremail"],
      $this->user["username"],
      $this->user["userpswd"],
      $this->user["userest"],
      $this->user["usertipo"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Users_UserList",
        "Usuario creado exitosamente"
      );
    }
  }

  private function handleUpdate()
  {
    $result = UsersDao::updateUser(
      $this->user["usercod"],
      $this->user["useremail"],
      $this->user["username"],
      $this->user["userpswd"],
      $this->user["userest"],
      $this->user["usertipo"]
    );
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Users_UserList",
        "Usuario actualizado exitosamente"
      );
    }
  }

  private function handleDelete()
  {
    $result = UsersDao::deleteUser($this->user["usercod"]);
    if ($result > 0) {
      Site::redirectToWithMsg(
        "index.php?page=Users_UserList",
        "Usuario Eliminado exitosamente"
      );
    }
  }
  private function setViewData(): void
  {
      $this->viewData["mode"] = $this->mode;
      $this->viewData["user_xss_token"] = $this->user_xss_token;
      $this->viewData["FormTitle"] = sprintf(
          $this->modeDescriptions[$this->mode],
         $this->user["usercod"],
          $this->user["useremail"]
      );
      $this->viewData["showCommitBtn"] = $this->showCommitBtn;
      $this->viewData["readonly"] = $this->readonly;
  
      $userStatusKey = "userest_" . strtolower($this->user["userest"]);
      $this->user[$userStatusKey] = "selected";
  
      $this->viewData["user"] = $this->user;
  }
}
?>