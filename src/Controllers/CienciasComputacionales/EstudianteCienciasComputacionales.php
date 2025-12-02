<?php

namespace Controllers\CienciasComputacionales;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;
use Dao\EstudiantesCienciasComputacionales\EstudiantesCienciasComputacionales as DAOEstudiantes;

class EstudianteCienciasComputacionales extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["EstudianteCienciasComputacionales"] = DAOEstudiantes::obtenerEstudiantes();
        Renderer::render("cienciascomputacionales/estudiantecienciascomputacionales/lista", $viewData);
    }
}
