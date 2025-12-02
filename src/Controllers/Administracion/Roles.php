<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Dao\Roles\Roles as RolesDao;
use Views\Renderer;

class Roles extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["roles"] = RolesDao::obtenerRol();
        Renderer::render("administracion/roles/lista", $viewData);
    }
}
