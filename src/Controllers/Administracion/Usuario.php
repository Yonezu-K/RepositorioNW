<?php

namespace Controllers\Administracion;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use DAO\Usuarios\Usuarios as DAOUsuarios;
use Exception;


const UsuariosList = "index.php?page=Administracion-Usuarios";
const UsuView = "administracion/usuarios/form";
class Usuario  extends PublicController
{
    private $modes = [
        "INS" => "Nuevo",
        "UPD" => "Editar %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminar de %s"
    ];
    private string $mode = '';

    private string $usercod = "";
    private string $useremail = '';
    private string $username = '';
    private string $userpswd = '';
    private string $userfching = '';
    private string $userpswdest = '';
    private string $userpswdexp = '';
    private string $userest = '';
    private string $useractcod = '';
    private string $userpswdchg = '';
    private string $usertipo = '';

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
                                $affectedRows = DAOUsuarios::crearUsuario(
                                    $this->usercod,
                                    $this->useremail,
                                    $this->username,
                                    $this->userpswd,
                                    $this->userfching,
                                    $this->userpswdest,
                                    $this->userpswdexp,
                                    $this->userest,
                                    $this->useractcod,
                                    $this->userpswdchg,
                                    $this->usertipo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Nuevo Usuario creado satisfactoriamente.");
                                }
                                break;
                            case 'UPD':
                                //Lalamar a DAO para actualizar
                                $affectedRows = DAOUsuarios::actualizarUsuario(
                                    $this->usercod,
                                    $this->useremail,
                                    $this->username,
                                    $this->userpswd,
                                    $this->userfching,
                                    $this->userpswdest,
                                    $this->userpswdexp,
                                    $this->userest,
                                    $this->useractcod,
                                    $this->userpswdchg,
                                    $this->usertipo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Usuario actualizado satisfactoriamente.");
                                }
                                break;
                            case 'DEL':
                                //Lalamar a DAO para eliminar
                                $affectedRows = DAOUsuarios::eliminarUsuario(
                                    $this->usercod
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Usuario eliminado satisfactoriamente.");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                    }
                }
            }
            Renderer::render(

                UsuView,
                $this->preparar_datos_vista()
            );
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(UsuariosList, "Sucedió un problema. Reintente nuevamente.");
        }
    }
    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpCodigo = '';
                if (isset($_GET["usercod"])) {
                    $tmpCodigo = $_GET["usercod"];
                } else {
                    throw new Exception("Codigo no es Valido");
                }
                //Extraer datos de la DB
                $tmpUsuario = DAOUsuarios::obtenerUsuario($tmpCodigo);
                if (count($tmpUsuario) === 0) {
                    throw new Exception("No se encontro registro");
                }
                $this->usercod = $tmpUsuario["usercod"];
                $this->useremail = $tmpUsuario["useremail"];
                $this->username = $tmpUsuario["username"];
                $this->userpswd = $tmpUsuario["userpswd"];
                $this->userfching = $tmpUsuario["userfching"];
                $this->userpswdest = $tmpUsuario["userpswdest"];
                $this->userpswdexp = $tmpUsuario["userpswdexp"];
                $this->userest = $tmpUsuario["userest"];
                $this->useractcod = $tmpUsuario["useractcod"];
                $this->userpswdchg = $tmpUsuario["userpswdchg"];
                $this->usertipo = $tmpUsuario["usertipo"];
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

        $this->usercod = intval($_POST["usercod"] ?? '');
        $this->useremail = $_POST["useremail"] ?? '';
        $this->username = $_POST["username"] ?? '';
        $this->userpswd = $_POST["userpswd"] ?? '';
        $this->userfching = $_POST["userfching"] ?? '';
        $this->userpswdest = $_POST["userpswdest"] ?? '';
        $this->userpswdexp = $_POST["userpswdexp"] ?? '';
        $this->userest = $_POST["userest"] ?? '';
        $this->useractcod = $_POST["useractcod"] ?? '';
        $this->userpswdchg = $_POST["userpswdchg"] ?? '';
        $this->usertipo = $_POST["usertipo"] ?? '';

        if (Validators::IsEmpty($this->username)) {
            $errors[] = "El nombre no puede estar vacio.";
        }

        if (!in_array($this->userest, ['Activo', 'Inactivo'])) {
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->username);
        }

        $viewData["usercod"] = $this->usercod;
        $viewData["useremail"] = $this->useremail;
        $viewData["username"] = $this->username;
        $viewData["userpswd"] = $this->userpswd;
        $viewData["userfching"] = $this->userfching;
        $viewData["userpswdest"] = $this->userpswdest;
        $viewData["userpswdexp"] = $this->userpswdexp;
        $viewData["userest"] = $this->userest;
        $viewData["useractcod"] = $this->useractcod;
        $viewData["userpswdchg"] = $this->userpswdchg;
        $viewData["usertipo"] = $this->usertipo;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["usercodReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->userest] = "selected";
        return $viewData;
    }
}
