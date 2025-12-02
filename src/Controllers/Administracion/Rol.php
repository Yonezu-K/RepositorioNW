<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DAO\Roles\Roles as DAORoles;
use Exception;


const RolesList = "index.php?page=Administracion-Roles";
const RolView = "administracion/roles/form";
class Rol extends PublicController
{
    private $modes = [
        "INS" => "Nuevo",
        "UPD" => "Editar %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar de %s"
    ];
    private string $mode = '';

    private string $rolescod = "";
    private string $rolesdsc = '';
    private string $rolesest = '';

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
                                $affectedRows = DAORoles::crearRol(
                                    $this->rolescod,
                                    $this->rolesdsc,
                                    $this->rolesest
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RolesList, "Nuevo Rol creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Lalamar a DAO para actualizar
                                $affectedRows = DAORoles::actualizarRol(
                                    $this->rolescod,
                                    $this->rolesdsc,
                                    $this->rolesest
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RolesList, "Rol actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Lalamar a DAO para eliminar
                                $affectedRows = DAORoles::eliminarRol(
                                    $this->rolescod
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(RolesList, "Rol eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                    }
                }
            }
            Renderer::render(

                RolView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(RolesList, "Sucedió un problema. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["rolescod"])) {
                    $tmpCodigo = $_GET["rolescod"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }
                //Extraer datos de la DB
                $tmpRol = DAORoles::obtenerRol($tmpCodigo);
                if (count($tmpRol) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->rolescod = $tmpRol["rolescod"];
                $this->rolesdsc = $tmpRol["rolesdsc"];
                $this->rolesest = $tmpRol["rolesest"];
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

        $this->rolescod = $_POST["rolescod"] ?? '';
        $this->rolesdsc = $_POST["rolesdsc"] ?? '';
        $this->rolesest = $_POST["rolesest"] ?? '';

        if (Validators::IsEmpty($this->rolesdsc)) {
            $errors[] = "El nombre no puede estar vacio.";
        }

        if (!in_array($this->rolesest, ['Activo', 'Inactivo'])) {
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->rolesdsc);
        }

        $viewData["rolescod"] = $this->rolescod;
        $viewData["rolesdsc"] = $this->rolesdsc;
        $viewData["rolesest"] = $this->rolesest;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["rolescodReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->rolesest] = "selected";
        return $viewData;
    }
}
