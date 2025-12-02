<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Dao\Usuarios\Usuarios as UsuariosDAO;
use Views\Renderer;


class Usuarios extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["usuarios"] = UsuariosDAO::obtenerUsuario();
        Renderer::render("administracion/usuarios/lista", $viewData);
    }
}
