<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DAO\Funciones\Funciones as DAOFunciones;
use Exception;


const FuncionList = "index.php?page=Administracion-Funciones";
const FuncionView = "administracion/funciones/form";
class Funcion extends PublicController
{
    private $modes = [
        "INS" => "Nuevo",
        "UPD" => "Editar %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar de %s"
    ];
    private string $mode = '';

    private string $fncod = "";
    private string $fndsc = '';
    private string $fnest = '';
    private string $fntyp = '';

    private string $validationToken = '';

    private array $errores = [];

    public function run(): void
    {
        try {
            $this->page_init();
            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();
                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case 'INS':
                                //Lalamar a DAO para ingresar
                                $affectedRows = DAOFunciones::crearFuncion(
                                    $this->fncod,
                                    $this->fndsc,
                                    $this->fnest,
                                    $this->fntyp
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FuncionList, "Nuevo Funciones creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Lalamar a DAO para actualizar
                                $affectedRows = DAOFunciones::actualizarFuncion(
                                    $this->fncod,
                                    $this->fndsc,
                                    $this->fnest,
                                    $this->fntyp
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FuncionList, "Funciones actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Lalamar a DAO para eliminar
                                $affectedRows = DAOFunciones::eliminarFuncion(
                                    $this->fncod
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(FuncionList, "Funciones eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                    }
                }
            }
            Renderer::render(

                FuncionView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(FuncionList, "Sucedió un problema. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["fncod"])) {
                    $tmpCodigo = $_GET["fncod"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }
                //Extraer datos de la DB
                $tmpFuncion = DAOFunciones::obtenerFunciones($tmpCodigo);
                if (count($tmpFuncion) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->fncod = $tmpFuncion["fncod"];
                $this->fndsc = $tmpFuncion["fndsc"];
                $this->fnest = $tmpFuncion["fnest"];
                $this->fntyp = $tmpFuncion["fntyp"];
            }
        } else {
            throw new Exception("Valor de mode no es valido");
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->validationToken = $_POST["vlt"] ?? '';

        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception("Error de validacion de Token.");
        }

        $this->fncod = $_POST["fncod"] ?? '';
        $this->fndsc = $_POST["fndsc"] ?? '';
        $this->fnest = $_POST["fnest"] ?? '';
        $this->fntyp = $_POST["fntyp"] ?? '';

        if (Validators::IsEmpty($this->fndsc)) {
            $errors[] = "El nombre no puede estar vacio.";
        }

        if (!in_array($this->fnest, ['Activo', 'Inactivo'])) {
            $errors[] = "El estado es Incorrecto.";
        }

        return $errors;
    }

    private function generarTokenDeValidacion()
    {
        $this->validationToken = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->validationToken;
    }
    private function preparar_datos_vista()
    {
        $viewData = [];
        $viewData["mode"] = $this->mode;

        $viewData["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->fndsc);
        }

        $viewData["fncod"] = $this->fncod;
        $viewData["fndsc"] = $this->fndsc;
        $viewData["fnest"] = $this->fnest;
        $viewData["fntyp"] = $this->fntyp;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["fncodReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";
        return $viewData;
    }
}
