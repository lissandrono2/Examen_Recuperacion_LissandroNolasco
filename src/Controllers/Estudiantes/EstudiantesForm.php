<?php

namespace Controllers\Estudiantes;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;

class EstudiantesForm extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeOptions = [
        "INS" => "Nuevo Estudiante",
        "UPD" => "Actualizar Estudiante (%s %s)",
        "DEL" => "Eliminar Estudiante (%s %s)",
        "DSP" => "Detalles de Estudiante (%s %s)"
    ];

    private $id_estudiante = 0;
    private $nombre = "";
    private $apellido = "";
    private $edad = 0;
    private $especialidad = "";
    private $estudiante_xss_token = "";

    private function cargar_datos()
    {
        $this->id_estudiante = isset($_GET["id_estudiante"]) ? $_GET["id_estudiante"] : 0;
        $this->mode = isset($_GET["mode"]) ? $_GET["mode"] : "DSP";
        $this->viewData["estudiante_xss_token"] = $this->estudiante_xss_token;

        if($this->id_estudiante > 0){
            $estudiante = \Dao\Estudiantes\Estudiantes::getEstudiante($this->id_estudiante);
            if ($estudiante){
                $this ->nombre = $estudiante["nombre"];
                $this ->apellido = $estudiante["apellido"];
                $this ->edad = $estudiante["edad"];
                $this ->especialidad = $estudiante["especialidad"];
            }
        }
    }

    private function prepareViewData(){
        $viewData["mode"] = $this->mode;
        $viewData["modeDesc"] = sprintf($this->modeOptions[$this->mode], $this->id_estudiante, $this->nombre);
        $viewData["id_estudiante"] = $this->id_estudiante;
        $viewData["nombre"] = $this->nombre;
        $viewData["apellido"] = $this->apellido;
        $viewData["edad"] = $this->edad;
        $viewData["especialidad"] = $this->especialidad;
        $viewData["estudiante_xss_token"] = $this->estudiante_xss_token;

        $this->viewData = $viewData; 
    }
    public function run(): void
    {
        
        $this->cargar_datos();
        $this->prepareViewData();
        Renderer::render("estudiantes/estudiantesform", $this->viewData);
    }
}