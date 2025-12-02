<?php

namespace Controllers\Incidentes;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DAO\IncidentesEstudiantiles\IncidentesEstudiantiles as DAOIncidentes;
use Exception;


const ClientesList = "index.php?page=Incidentes-IncidentesEstudiantiles";
const ClientView = "incidentes/incidentesestudiantiles/form";
class IncidentesEstudiante extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Incidente Estudiantil",
        "UPD" => "Editar incidente de %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar incidente de %s"
    ];
    private string $mode = '';

    private int $id = 0;
    private string $estudiante_nombre = '';
    private string $fecha_incidente = '';
    private string $tipo_incidente = '';
    private string $descripcion = '';
    private string $accion_tomada = '';
    private string $estado = 'Abierto';

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
                                $affectedRows = DAOIncidentes::crearIncidentes(
                                    $this->id,
                                    $this->estudiante_nombre,
                                    $this->fecha_incidente,
                                    $this->tipo_incidente,
                                    $this->descripcion,
                                    $this->accion_tomada,
                                    $this->estado
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ClientesList, "Nuevo CLiente creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Lalamar a DAO para actualizar
                                $affectedRows = DAOIncidentes::actualizarIncidentes(
                                    $this->id,
                                    $this->estudiante_nombre,
                                    $this->fecha_incidente,
                                    $this->tipo_incidente,
                                    $this->descripcion,
                                    $this->accion_tomada,
                                    $this->estado
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ClientesList, "CLiente actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Lalamar a DAO para eliminar
                                $affectedRows = DAOIncidentes::eliminarIncidentes(
                                    $this->id
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ClientesList, "CLiente eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                    }
                }
            }
            Renderer::render(

                ClientView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(ClientesList, "Sucedió un problema. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["id"])) {
                    $tmpCodigo = $_GET["id"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }
                //Extraer datos de la DB
                $tmpIncidente = DAOIncidentes::obtenerIncidentesPorCodigo($tmpCodigo);
                if (count($tmpIncidente) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->id = $tmpIncidente["id"];
                $this->estudiante_nombre = $tmpIncidente["estudiante_nombre"];
                $this->fecha_incidente = $tmpIncidente["fecha_incidente"];
                $this->tipo_incidente = $tmpIncidente["tipo_incidente"];
                $this->descripcion = $tmpIncidente["descripcion"];
                $this->accion_tomada = $tmpIncidente["accion_tomada"];
                $this->estado = $tmpIncidente["estado"];
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

        $this->id = intval($_POST["id"] ?? '');
        $this->estudiante_nombre = $_POST["estudiante_nombre"] ?? '';
        $this->fecha_incidente = $_POST["fecha_incidente"] ?? '';
        $this->tipo_incidente = $_POST["tipo_incidente"] ?? '';
        $this->descripcion = $_POST["descripcion"] ?? '';
        $this->accion_tomada = $_POST["accion_tomada"] ?? '';
        $this->estado = $_POST["estado"] ?? 'Activo';

        if (Validators::IsEmpty($this->estudiante_nombre)) {
            $errors[] = "El nombre no puede estar vacio.";
        }

        if (!in_array($this->estado, ['Activo', 'Inactivo'])) {
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->estudiante_nombre);
        }

        $viewData["id"] = $this->id;
        $viewData["estudiante_nombre"] = $this->estudiante_nombre;
        $viewData["fecha_incidente"] = $this->fecha_incidente;
        $viewData["tipo_incidente"] = $this->tipo_incidente;
        $viewData["descripcion"] = $this->descripcion;
        $viewData["accion_tomada"] = $this->accion_tomada;
        $viewData["estado"] = $this->estado;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->estado] = "selected";
        return $viewData;
    }
}
