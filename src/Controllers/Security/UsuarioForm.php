<?php

namespace Controllers\Security;

use Dao\Security\Usuario as UsuarioDao;
use Controllers\PublicController;
use Views\Renderer;

class UsuarioForm extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDsc = [
        "DSP" => "View Usuario",
        "INS" => "Add Usuario",
        "UPD" => "Update Usuario",
        "DEL" => "Delete Usuario"
    ];

    private $isReadOnly = "readonly";
    private $hasErrors = false;
    private $errors = [];
    private $crf_token = "";

    private $usercod = 0;
    private $useremail = "";
    private $username = "";
    private $userpswd = "";
    private $userfching = null;
    private $userpswdest = "";
    private $userpswdexp = null;
    private $userest = "";
    private $useractcod = "";
    private $userpswdchg = "";
    private $usertipo = "";

    private function throwError($message, $scope = "global")
    {
        $this->hasErrors = true;
        error_log($message);
        if (!isset($this->errors[$scope])) {
            $this->errors[$scope] = [];
        }
        $this->errors[$scope][] = $message;
    }

    private function cargarDatos()
    {
        $this->usercod = isset($_GET["usercod"]) ? intval($_GET["usercod"]) : 0;
        $this->mode = isset($_GET["mode"]) ? $_GET["mode"] : "DSP";

        if (
            $this->usercod > 0
        ) {
            $usuario = UsuarioDao::getByPrimaryKey($this->usercod);
            if ($usuario) {
                $this->usercod = $usuario["usercod"];
                $this->useremail = $usuario["useremail"];
                $this->username = $usuario["username"];
                $this->userpswd = $usuario["userpswd"];
                $this->userfching = $usuario["userfching"];
                $this->userpswdest = $usuario["userpswdest"];
                $this->userpswdexp = $usuario["userpswdexp"];
                $this->userest = $usuario["userest"];
                $this->useractcod = $usuario["useractcod"];
                $this->userpswdchg = $usuario["userpswdchg"];
                $this->usertipo = $usuario["usertipo"];
            }
        }
    }

    private function getPostData()
    {
        $tmp_useremail = isset($_POST["useremail"]) ? strval($_POST["useremail"]) : "";
        $tmp_username = isset($_POST["username"]) ? strval($_POST["username"]) : "";
        $tmp_userpswd = isset($_POST["userpswd"]) ? strval($_POST["userpswd"]) : "";
        $tmp_userfching = isset($_POST["userfching"]) ? strval($_POST["userfching"]) : null;
        $tmp_userpswdest = isset($_POST["userpswdest"]) ? strval($_POST["userpswdest"]) : "";
        $tmp_userpswdexp = isset($_POST["userpswdexp"]) ? strval($_POST["userpswdexp"]) : null;
        $tmp_userest = isset($_POST["userest"]) ? strval($_POST["userest"]) : "";
        $tmp_useractcod = isset($_POST["useractcod"]) ? strval($_POST["useractcod"]) : "";
        $tmp_userpswdchg = isset($_POST["userpswdchg"]) ? strval($_POST["userpswdchg"]) : "";
        $tmp_usertipo = isset($_POST["usertipo"]) ? strval($_POST["usertipo"]) : "";
        $tmp_mode = isset($_POST["mode"]) ? $_POST["mode"] : "DSP";
        $tmp_crf_token = isset($_POST["crf_token"]) ? $_POST["crf_token"] : "";
        // Do Fields Validation

        if ($this->mode !== $tmp_mode) {
            $this->throwError("Modo de formulario inválido");
        }
        if (!$this->validateCsfrToken()) {
            $this->throwError("Error de aplicación, Token CSRF Inválido");
        }
        $this->useremail = $tmp_useremail;
        $this->username = $tmp_username;
        $this->userpswd = $tmp_userpswd;
        $this->userfching = $tmp_userfching;
        $this->userpswdest = $tmp_userpswdest;
        $this->userpswdexp = $tmp_userpswdexp;
        $this->userest = $tmp_userest;
        $this->useractcod = $tmp_useractcod;
        $this->userpswdchg = $tmp_userpswdchg;
        $this->usertipo = $tmp_usertipo;
        $this->crf_token = $tmp_crf_token;
        $this->mode = $tmp_mode;
    }

    private function validateCsfrToken()
    {
        if ($this->crf_token !== $_SESSION["crf_token"]) {
            $this->throwError("Error de aplicación, Token CSRF Inválido");
            return false;
        }
        return true;
    }

    private function crf_token()
    {
        $this->crf_token = md5(uniqid(rand(), true));
        $_SESSION["crf_token"] = $this->crf_token;
    }

    private function processAction()
    {
        switch ($this->mode) {
            case "INS":
                $inserted = UsuarioDao::add(
                    $this->usercod,
                    $this->useremail,
                    $this->username,
                    $this->userpswd,
                    $this->userfching,
                    $this->userpswdest,
                    $this->userpswdexp,
                    $this->userest,
                    $this->useractcod,
                    $this->userpswdchg,
                    $this->usertipo
                );
                if ($inserted) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=Security_UsuarioList",
                        "Registro Agregado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al agregar el registro");
                }
                break;
            case "UPD":
                $updated = UsuarioDao::update(
                    $this->usercod,
                    $this->useremail,
                    $this->username,
                    $this->userpswd,
                    $this->userfching,
                    $this->userpswdest,
                    $this->userpswdexp,
                    $this->userest,
                    $this->useractcod,
                    $this->userpswdchg,
                    $this->usertipo
                );
                if ($updated) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=Security_UsuarioList",
                        "Registro Actualizado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al actualizar el registro");
                }
                break;
            case "DEL":
                $deleted = UsuarioDao::delete($this->usercod);
                if ($deleted) {
                    \Utilities\Site::redirectToWithMsg(
                        "index.php?page=Security_UsuarioList",
                        "Registro Eliminado Exitosamente"
                    );
                } else {
                    $this->throwError("Error al eliminar el registro");
                }
                break;
        }
    }

    private function prepareViewData()
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["modeDesc"] = sprintf($this->modeDsc[$this->mode], $this->usercod);
        $this->viewData["usercod"] = $this->usercod;
        $this->viewData["useremail"] = $this->useremail;
        $this->viewData["username"] = $this->username;
        $this->viewData["userpswd"] = $this->userpswd;
        $this->viewData["userfching"] = $this->userfching;
        $this->viewData["userpswdest"] = $this->userpswdest;
        $this->viewData["userpswdexp"] = $this->userpswdexp;
        $this->viewData["userest"] = $this->userest;
        $this->viewData["useractcod"] = $this->useractcod;
        $this->viewData["userpswdchg"] = $this->userpswdchg;
        $this->viewData["usertipo"] = $this->usertipo;
        if ($this->mode === "INS" || $this->mode === "UPD") {
            $this->isReadOnly = "";
        }
        $this->viewData["isReadOnly"] = $this->isReadOnly;
        $this->viewData["showAction"] = $this->mode !== "DSP";
        $this->crf_token();
        $this->viewData["crf_token"] = $this->crf_token;
        $this->viewData["hasErrors"] = $this->hasErrors;
        $this->viewData["errors"] = $this->errors;
    }

    public function run(): void
    {
        $this->cargarDatos();
        if ($this->isPostBack()) {
            $this->getPostData();
            if (!$this->hasErrors) {
                $this->processAction();
            }
        }
        $this->prepareViewData();
        Renderer::render("security/usuario_form", $this->viewData);
    }
}
