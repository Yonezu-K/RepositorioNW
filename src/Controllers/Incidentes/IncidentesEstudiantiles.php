<?php

namespace Controllers\Incidentes;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;
use Dao\IncidentesEstudiantiles\IncidentesEstudiantiles as DAOIncidentes;

class IncidentesEstudiantiles extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["incidentes_estudiantiles"] = DAOIncidentes::obtenerIncidentes();
        Renderer::render("incidentes/incidentesestudiantiles/lista", $viewData);
    }
}
