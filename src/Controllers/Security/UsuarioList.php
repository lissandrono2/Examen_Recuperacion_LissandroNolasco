<?php

namespace Controllers\Security;

use Dao\Security\Usuario as UsuarioDao;
use Controllers\PublicController;
use Views\Renderer;

class UsuarioList extends PublicController
{
    public function run(): void
    {
        $viewData["rows"] = UsuarioDao::getAll();
        Renderer::render("security/usuario_list", $viewData);
    }
}
