<?php

namespace Controllers\Estudiantes;

use Controllers\PublicController;
use Dao\Estudiantes\Estudiantes as DaoEstudiantes;
use Views\Renderer;

class EstudiantesListado extends PublicController
{

    public function run(): void
    {
        $viewData = [];
        $viewData["estudiantescienciascomputacionales"] = DaoEstudiantes::getAllEstudiantes();
        Renderer::render("estudiantes/estudianteslistado", $viewData);
    }
}
?>