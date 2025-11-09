<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Utilities\Site;
use Views\Renderer;
use Exception;
use ReturnTypeWillChange;

const ClientesList = "index.php?page=Mantenimientos-Clientes";
const ClientView = "mantenimiento/clientes/form";
class Cliente extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Cliente",
        "UPD" => "Editar %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar %s"
    ];
    private string $mode = '';

    public function run(): void
    {
        try {
            $this->page_init();

            Renderer::render(
                ClientView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(ClientesList, "Susedio un preblema.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
        } else {
            throw new Exception("Valor de mode no es valido");
        }
    }

    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode;

        return $viewData;
    }
}
