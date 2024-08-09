<?php

namespace Controllers\Libros;

use Controllers\PublicController;
use Dao\Libros\Libros;
use Views\Renderer;

class LibrosList extends PublicController
{
    public function run(): void
    {
        $viewData["libros"] = Libros::getAll();
        Renderer::render("libros/list", $viewData);
    }
}
