<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Dao\Funciones\Funciones as FuncionesDAO;
use Views\Renderer;

class Funciones extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["funciones"] = FuncionesDAO::obtenerFunciones();
        Renderer::render("administracion/funciones/lista", $viewData);
    }
}
