<?php

namespace Controllers\Libros;

use Controllers\PublicController;
use Dao\Libros\Libros as LibrosDao;
use Utilities\Site;
use Utilities\Validators;
use Utilities\ArrUtils;
use Views\Renderer;

class LibrosForm extends PublicController
{
    private $viewData = [];
    private $libros_dsc = "";
    private $libros_isbn = "";
    private $libros_autor = "";
    private $libros_categoria = "NDF";
    private $libros_estado = "ACT";
    private $libros_id = 0;

    private $mode = "DSP";
    private $modeDscArr = [
        "DSP" => "Mostrar %s",
        "INS" => "Crear Nuevo",
        "UPD" => "Actualizar %s",
        "DEL" => "Eliminar %s"
    ];

    private $errors = [];
    private $has_errors = false;
    private $isReadOnly = "readonly";
    private $showActions = true;
    private $cxfToken = "";

    private $categoriesOptions = [
        "NDF" => "No Definido",
        "CLS" => "Clasicos",
        "FIC" => "Ficcion",
        "HIS" => "Historia",
        "ROM" => "Romance",
        "TCT" => "Tecnologia",
        "MNG" => "Manga",
    ];

    private $estadosOptions = [
        "ACT" => "Activo",
        "INA" => "Inactivo",
        "RTR" => "Retirado",
    ];

    private function addError($errorMsg, $origin = "global")
    {
        if (!isset($this->errors[$origin])) {
            $this->errors[$origin] = [];
        }
        $this->errors[$origin][] = $errorMsg;
        $this->has_errors = true;
    }


    private function getDatos()
    {
        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
            if (!isset($this->modeDscArr[$this->mode])) {
                $this->addError("Modo invalido");
            }
        }
        if (isset($_GET["libros_id"])) {
            $this->libros_id = intval($_GET["libros_id"]);
            $tmpLibrosFromDb = LibrosDao::getById($this->libros_id);
            if ($tmpLibrosFromDb) {
                $this->libros_dsc = $tmpLibrosFromDb["libros_dsc"];
                $this->libros_isbn = $tmpLibrosFromDb["libros_isbn"];
                $this->libros_autor = $tmpLibrosFromDb["libros_autor"];
                $this->libros_categoria = $tmpLibrosFromDb["libros_categoria"];
                $this->libros_estado = $tmpLibrosFromDb["libros_estado"];
            } else {
                $this->addError("Libro no encontrado");
            }
        }
    }

    private function getPostData()
    {
        if (isset($_POST["cxfToken"])) {
            $this->cxfToken = $_POST["cxfToken"];
            if (Validators::IsEmpty($this->cxfToken)) {
                $this->addError("Token invalido");
            }
        }
        $tmpMode = "";
        if (isset($_POST["mode"])) {
            $tmpMode = $_POST["mode"];
            if (!isset($this->modeDscArr[$tmpMode])) {
                $this->addError("Modo invalido");
            }
            if ($this->mode != $tmpMode) {
                $this->addError("Modo invalido");
            }
        }
        if (isset($_POST["libros_dsc"])) {
            $this->libros_dsc = $_POST["libros_dsc"];
            if (Validators::IsEmpty($this->libros_dsc)) {
                $this->addError("Descripcion invalida", "libros_dsc_error");
            }
        }
        if (isset($_POST["libros_isbn"])) {
            $this->libros_isbn = $_POST["libros_isbn"];
            if (Validators::IsEmpty($this->libros_isbn)) {
                $this->addError("ISBN invalido", "libros_isbn_error");
            }
        }
        if (isset($_POST["libros_autor"])) {
            $this->libros_autor = $_POST["libros_autor"];
            if (Validators::IsEmpty($this->libros_autor)) {
                $this->addError("Autor invalido", "libros_autor_error");
            }
        }
        if (isset($_POST["libros_categoria"])) {
            $this->libros_categoria = $_POST["libros_categoria"];
            if (!isset($this->categoriesOptions[$this->libros_categoria])) {
                $this->addError("Categoria invalida", "libros_categoria_error");
            }
        }
        if (isset($_POST["libros_estado"])) {
            $this->libros_estado = $_POST["libros_estado"];
            if (!isset($this->estadosOptions[$this->libros_estado])) {
                $this->addError("Estado invalido", "libros_estado_error");
            }
        }
    }

    private function executePostAction()
    {
        switch ($this->mode) {
            case "INS":
                $result = LibrosDao::add(
                    $this->libros_dsc,
                    $this->libros_isbn,
                    $this->libros_autor,
                    $this->libros_categoria,
                    $this->libros_estado
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(
                        "index.php?page=Libros_LibrosList",
                        "Libro creado"
                    );
                } else {
                    $this->addError("Error al crear el libro");
                }
                break;
            case "UPD":
                $result = LibrosDao::update(
                    $this->libros_dsc,
                    $this->libros_isbn,
                    $this->libros_autor,
                    $this->libros_categoria,
                    $this->libros_estado,
                    $this->libros_id
                );
                if ($result > 0) {
                    Site::redirectToWithMsg(
                        "index.php?page=Libros_LibrosList",
                        "Libro actualizado"
                    );
                } else {
                    $this->addError("Error al actualizar el libro");
                }
                break;
            case "DEL":
                $result = LibrosDao::delete($this->libros_id);
                if ($result > 0) {
                    Site::redirectToWithMsg(
                        "index.php?page=Libros_LibrosList",
                        "Libro eliminado"
                    );
                } else {
                    $this->addError("Error al eliminar el libro");
                }
                break;
        }
    }

    private function prepareView()
    {
        $this->viewData["modeDsc"] = sprintf($this->modeDscArr[$this->mode], $this->libros_dsc);
        $this->viewData["mode"] = $this->mode;
        $this->viewData["libros_dsc"] = $this->libros_dsc;
        $this->viewData["libros_isbn"] = $this->libros_isbn;
        $this->viewData["libros_autor"] = $this->libros_autor;
        $this->viewData["libros_categoria"] = $this->libros_categoria;
        $this->viewData["libros_estado"] = $this->libros_estado;
        $this->viewData["libros_id"] = $this->libros_id;
        $this->viewData["errors"] = $this->errors;
        $this->viewData["has_errors"] = $this->has_errors;
        if ($this->mode == "DSP" || $this->mode == "DEL") {
            $this->isReadOnly = "readonly";
            if ($this->mode == "DSP") {
                $this->showActions = false;
            }
        } else {
            $this->isReadOnly = "";
            $this->showActions = true;
        }
        $this->viewData["isReadOnly"] = $this->isReadOnly;
        $this->viewData["showActions"] = $this->showActions;
        $this->viewData["cxfToken"] = $this->cxfToken;
        $this->viewData["categoriesOptions"] = ArrUtils::toOptionsArray(
            $this->categoriesOptions,
            "key",
            "value",
            "selected",
            $this->libros_categoria
        );

        $this->viewData["estadosOptions"] = ArrUtils::toOptionsArray(
            $this->estadosOptions,
            "key",
            "value",
            "selected",
            $this->libros_estado
        );
    }

    public function run(): void
    {
        //obtenerDatos del Get
        $this->getDatos();
        if ($this->isPostBack()) {
            $this->getPostData();
            $this->executePostAction();
        }
        $this->prepareView();
        Renderer::render("libros/form", $this->viewData);
    }
}
