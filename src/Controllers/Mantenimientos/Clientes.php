<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Dao\Dao;
use Views\Renderer;
use Dao\Clientes\Clientes as ClientesDAO;

class Clientes extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $tmpClientes = ClientesDAO::obtenerCLientes();
        $viewData["clientes"] = [];
        $totalNota = 0;
        foreach ($tmpClientes as $cliente) {
            $clienteNormalizado = $cliente;
            $clienteNormalizado["nota"] = $cliente["evaluacion"] / 100 * 5;
            $totalNota += $clienteNormalizado["nota"];
            if ($clienteNormalizado["nota"] > 4.5) {
                $clienteNormalizado["grade"] = "A";
            } elseif ($clienteNormalizado["nota"] > 4.0) {
                $clienteNormalizado["grade"] = "B";
            } elseif ($clienteNormalizado["nota"] > 3.5) {
                $clienteNormalizado["grade"] = "C";
            } elseif ($clienteNormalizado["nota"] > 3.0) {
                $clienteNormalizado["grade"] = "D";
            } elseif ($clienteNormalizado["nota"] > 2.5) {
                $clienteNormalizado["grade"] = "E";
            } else {
                $clienteNormalizado["grade"] = "F";
            }
            $viewData["clientes"][] = $clienteNormalizado;
        }
        $viewData["total"] = count($viewData["clientes"]);
        $viewData["totalNota"] = $totalNota;
        Renderer::render("mantenimientos/clientes/lista", $viewData);
    }
}
