<?php

namespace Controllers\CienciasComputacionales;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use Dao\EstudiantesCienciasComputacionales\EstudiantesCienciasComputacionales as DAOEstudiantes;
use Exception;


const EstuList = "index.php?page=CienciasComputacionales-EstudianteCienciasComputacionales";
const EstuView = "cienciascomputacionales/estudiantecienciascomputacionales/form";
class EstudianteCienciasComputacional extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Incidente Estudiantil",
        "UPD" => "Editar incidente de %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar incidente de %s"
    ];
    private string $mode = '';

    private string $id_estudiante = '';
    private string $nombre = '';
    private string $apellido = '';
    private string $edad = '';
    private string $especialidad = '';

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
                                //Llamar a DAO para ingresar
                                $affectedRows = DAOEstudiantes::crearEstudiante(
                                    $this->id_estudiante,
                                    $this->nombre,
                                    $this->apellido,
                                    $this->edad,
                                    $this->especialidad
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(EstuList, "Nuevo Estudiante creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Llamar a DAO para actualizar
                                $affectedRows = DAOEstudiantes::actualizarEstudiante(
                                    $this->id_estudiante,
                                    $this->nombre,
                                    $this->apellido,
                                    $this->edad,
                                    $this->especialidad
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(EstuList, "Estudiante actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Llamar a DAO para eliminar
                                $affectedRows = DAOEstudiantes::eliminarEstudiante(
                                    $this->id_estudiante
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(EstuList, "Estudiante eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                    }
                }
            }
            Renderer::render(
                EstuView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(EstuList, "Sucedió un problema. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["id_estudiante"])) {
                    $tmpCodigo = $_GET["id_estudiante"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }

                $tmpEstudiante = DAOEstudiantes::obtenerEstudiantePorCodigo($tmpCodigo);
                if (count($tmpEstudiante) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->id_estudiante = $tmpEstudiante["id_estudiante"];
                $this->nombre = $tmpEstudiante["nombre"];
                $this->apellido = $tmpEstudiante["apellido"];
                $this->edad = $tmpEstudiante["edad"];
                $this->especialidad = $tmpEstudiante["especialidad"];
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

        $this->id_estudiante = intval($_POST["id_estudiante"] ?? '');
        $this->nombre = $_POST["nombre"] ?? '';
        $this->apellido = $_POST["apellido"] ?? '';
        $this->edad = intval($_POST["edad"] ?? '');
        $this->especialidad = $_POST["especialidad"] ?? '';

        if (Validators::IsEmpty($this->nombre)) {
            $errors[] = "El nombre no puede estar vacio.";
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombre);
        }

        $viewData["id_estudiante"] = $this->id_estudiante;
        $viewData["nombre"] = $this->nombre;
        $viewData["apellido"] = $this->apellido;
        $viewData["edad"] = $this->edad;
        $viewData["especialidad"] = $this->especialidad;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        return $viewData;
    }
}
