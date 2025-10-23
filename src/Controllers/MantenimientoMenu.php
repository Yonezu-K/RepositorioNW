<?php

namespace Controllers;

use Controllers\PublicController;
use Views\Renderer;

class MantenimientoMenu extends PublicController
{
    public function run(): void
    {
        $arrMenues = [
            "items" => [
                [

                    "label" => "Productos",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Productos"
                ],
                [

                    "label" => "Categorias",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Categorias"
                ],
                [

                    "label" => "Ofertas",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Ofertas"
                ],
                [

                    "label" => "Cupones",
                    "icon" => "",
                    "url" => "index.php?page=Menu-Cupones"
                ],
            ]
        ];
        Renderer::render("mantenimientos", $arrMenues);
    }
}
