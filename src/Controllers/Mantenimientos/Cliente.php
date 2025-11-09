<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DAO\Clientes\Clientes as DAOClientes;
use Exception;


const ClientesList = "index.php?page=Mantenimientos-Clientes";
const ClientView = "mantenimientos/clientes/form";
class Cliente extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Cliente",
        "UPD" => "Editar %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar %s"
    ];
    private string $mode = '';

    private string $codigo = '';
    private string $nombre = '';
    private string $direccion = '';
    private string $telefono = '';
    private string $correo = '';
    private string $estado = '';
    private int $evaluacion = 0;

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
                                $affectedRows = DAOClientes::crearCliente(
                                    $this->codigo,
                                    $this->nombre,
                                    $this->direccion,
                                    $this->telefono,
                                    $this->correo,
                                    $this->estado,
                                    $this->evaluacion
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ClientesList, "Nuevo CLiente creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Lalamar a DAO para actualizar
                                $affectedRows = DAOClientes::actualizarCliente(
                                    $this->codigo,
                                    $this->nombre,
                                    $this->direccion,
                                    $this->telefono,
                                    $this->correo,
                                    $this->estado,
                                    $this->evaluacion
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(ClientesList, "CLiente actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Lalamar a DAO para eliminar
                                $affectedRows = DAOClientes::eliminarCliente(
                                    $this->codigo
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
            Site::redirectToWithMsg(ClientesList, "Susedio un problema. Reitente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["codigo"])) {
                    $tmpCodigo = $_GET["codigo"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }
                //Extraer datos de la DB
                $tmpCliente = DAOClientes::obtenerCLientePorCodigo($tmpCodigo);
                if (count($tmpCliente) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->codigo = $tmpCliente["codigo"];
                $this->nombre = $tmpCliente["nombre"];
                $this->direccion = $tmpCliente["direccion"];
                $this->telefono = $tmpCliente["telefono"];
                $this->correo = $tmpCliente["correo"];
                $this->estado = $tmpCliente["estado"];
                $this->evaluacion = $tmpCliente["evaluacion"];
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

        $this->codigo = $_POST["codigo"] ?? '';
        $this->nombre = $_POST["nombre"] ?? '';
        $this->direccion = $_POST["direccion"] ?? '';
        $this->telefono = $_POST["telefono"] ?? '';
        $this->correo = $_POST["correo"] ?? '';
        $this->estado = $_POST["estado"] ?? 'ACT';
        $this->evaluacion = intval($_POST["evaluacion"] ?? '');

        if (Validators::IsEmpty($this->nombre)) {
            $errors[] = "El nombre no puede estar vacio.";
        }

        if (!in_array($this->estado, ['ACT', 'INA'])) {
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->nombre);
        }

        $viewData["codigo"] = $this->codigo;
        $viewData["nombre"] = $this->nombre;
        $viewData["direccion"] = $this->direccion;
        $viewData["telefono"] = $this->telefono;
        $viewData["correo"] = $this->correo;
        $viewData["estado"] = $this->estado;
        $viewData["evaluacion"] = $this->evaluacion;

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
