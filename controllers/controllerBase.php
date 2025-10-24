    <?php
    class ControllerBase
    {
        public function verPaginaInicio($pagina)
        {
            include_once $pagina;
        }

        public function registerUser($datos)
        {

            //limpiar errores previos
            unset($_SESSION['errors']);
            unset($_SESSION['old']);
            unset($_SESSION['success']);

            $errores = $this->validateData($datos);
            var_dump($errores);
            if (count($errores) > 0) {
                $_SESSION['errors'] = $errores;
                $_SESSION['old'] = $datos;

                header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
                exit;
            }

            var_dump($datos);

            $usuario = new User();
            $exist = $usuario->validateUser($datos['email']);
            if ($exist > 0) {
                echo "encontro usuario";
                exit;
            }
            $datos['password'] = password_hash($datos['password'], PASSWORD_DEFAULT);
            $create = $usuario->registerUser($datos);
            if ($create > 0) {

                $_SESSION['success'] = 'Usuario registrado exitosamente';
                header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
                exit;
            } else {

                $_SESSION['errors'] = ['general' => 'Error al registrar el usuario. Intentelo de nuevo.'];
                $_SESSION['old'] = $datos;
                header('Location: ' . SITE_URL . 'index.php?action=getFormRegisterUser');
                exit;
            }
        }

        public function validateData($datos)
        {
            $errores = [];

            if (!isset($datos['document_type_id']) || $datos['document_type_id'] === "") {
                $errores['document_type_id'] = 'El tipo de documento es requerido';
            }

            if (empty(trim($datos['document_number'] ?? ''))) {
                $errores['document_number'] = 'El número de documento es requerido';
            }

            if (empty(trim($datos['name'] ?? ''))) {
                $errores['name'] = 'El nombre es requerido';
            }

            if (empty(trim($datos['lastname'] ?? ''))) {
                $errores['last_name'] = 'El apellido es requerido';
            }

            if (empty(trim($datos['phone'] ?? ''))) {
                $errores['phone'] = 'El teléfono es requerido';
            }

            if (empty(trim($datos['email'] ?? ''))) {
                $errores['email'] = 'El email es requerido';
            } elseif (!filter_var($datos['email'], FILTER_VALIDATE_EMAIL)) {
                $errores['email'] = 'El email no es válido';
            }

            if (empty($datos['password'] ?? '')) {
                $errores['password'] = 'La contraseña es requerida';
            } elseif (strlen($datos['password']) < 3) {
                $errores['password'] = 'La contraseña debe tener al menos 3 caracteres';
            }

            return $errores;
        }

        public function validarUser($datos)
        {
            $user = new User();
            $user->validateUser($datos);
        }

        public function loginUser($datos)
        {
            if (empty(trim($datos['email'])) || empty(trim($datos['password']))) {
                $_SESSION['errors']['login'] = 'Usuario o contraseña incorrectos.';
                header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
                exit;
            }

            $user = new User();
            $result = $user->validateLogin($datos['email']);

            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                if (password_verify($datos['password'], $userData['password'])) {
                    $_SESSION['user'] = $userData;
                    header('Location: ' . SITE_URL . 'index.php?action=formReservas');
                    exit;
                } else {
                    $_SESSION['errors']['login'] = 'Contraseña incorrecta.';
                    header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
                    exit;
                }
            }else {
                $_SESSION['errors']['login'] = 'Usuario o contraseña incorrectos.';
                header('Location: ' . SITE_URL . 'index.php?action=getFormLoginUser');
                exit;
            }
        }    

    public function registerReserva($datos){
        unset($_SESSION['reserva_msg']); // limpiar mensaje previo

        if (!empty($datos["btnregister"])) {
            // Validamos solo los campos obligatorios
            if (!empty(trim($datos["nombre"])) && !empty(trim($datos["apellido"])) &&
                !empty(trim($datos["fecha_entrada"])) && !empty(trim($datos["fecha_salida"])) &&
                !empty(trim($datos["habitacion"])) && !empty(trim($datos["personas"]))) {

            // Conexión a la base de datos
                require_once "models/conexion.php";
                $conexion = new conexion();
                $conexion->conectar();

                // Escapar valores para evitar errores o inyecciones
                $nombre = ($datos['nombre']);
                $apellido = ($datos['apellido']);
                $fechaEntrada = ($datos['fecha_entrada']);
                $fechaSalida = ($datos['fecha_salida']);
                $habitacion = ($datos['habitacion']);
                $personas = ($datos['personas']);
                $comentarios = !empty(trim($datos['comentarios'] ?? '')) ? trim($datos['comentarios']) : '';
                
                $userId = $_SESSION['user']['id']; // ID del usuario logueado
                // Insertar registro
                $sql = "INSERT INTO reservations (nombre, apellido, fecha_entrada, fecha_salida, habitacion, personas, comentarios, user_id)
                        VALUES ('$nombre', '$apellido', '$fechaEntrada', '$fechaSalida', '$habitacion', '$personas', '$comentarios', '$userId')";

                $conexion->setUsuario($_SESSION['user']['email']);
                $conexion->query($sql);

                if ($conexion->getFilasAfectadas() > 0) {
                    $_SESSION['reserva_msg'] = ['type' => 'success', 'text' => 'Reserva registrada con éxito'];
                } else {
                    $_SESSION['reserva_msg'] = ['type' => 'danger', 'text' => 'Error al registrar la reserva. Inténtelo de nuevo.'];
                }

                $conexion->desconectar();

            } else {
                $_SESSION['reserva_msg'] = ['type' => 'danger', 'text' => 'ALGUNO DE LOS CAMPOS ESTÁ VACÍO'];
            }
        }

        // Volver al formulario
        header('Location: ' . SITE_URL . 'index.php?action=formReservas');
        exit;
    }

    public function editarReserva($datos)
    {
        unset($_SESSION['reserva_msg']);
        require_once "models/conexion.php";
        $conexion = new Conexion();
        $conexion->conectar();

        // Si llega el id por GET, cargamos los datos para editar
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $conexion->query("SELECT * FROM reservations WHERE id = $id");
            $res = $conexion->getResult();
            $reserva = $res->fetch_assoc();
            $conexion->desconectar();
            include_once 'views/html/auth/editarReserva.php'; // vista del formulario de edición
            return;
        }

        // Si llega por POST (cuando se envía el formulario)
        if (isset($datos['btneditar'])) {
            $id = intval($datos['id']);
            $nombre = ($datos['nombre']);
            $apellido = ($datos['apellido']);
            $fechaEntrada = ($datos['fecha_entrada']);
            $fechaSalida = ($datos['fecha_salida']);
            $habitacion = ($datos['habitacion']);
            $personas = ($datos['personas']);
            $comentarios = trim($datos['comentarios']);

            $sql = "UPDATE reservations 
                    SET nombre='$nombre', apellido='$apellido', fecha_entrada='$fechaEntrada',
                        fecha_salida='$fechaSalida', habitacion='$habitacion',
                        personas='$personas', comentarios='$comentarios'
                    WHERE id=$id";

            $conexion->setUsuario($_SESSION['user']['email']); // 👈 Agregado
            $conexion->query($sql);
            $conexion->desconectar();

            if ($conexion->getFilasAfectadas() > 0) {
                $_SESSION['reserva_msg'] = ['type' => 'dark', 'text' => 'Reserva actualizada con éxito'];
            } else {
                $_SESSION['reserva_msg'] = ['type' => 'danger', 'text' => 'No se pudo actualizar la reserva'];
            }

            header('Location: ' . SITE_URL . 'index.php?action=formReservas');
            exit;
        }
    }


    public function eliminarReserva($datos)
    {
        unset($_SESSION['reserva_msg']);
        if (isset($_GET['id'])) {
            require_once "models/conexion.php";
            $conexion = new Conexion();
            $conexion->conectar();

            $id = intval($_GET['id']);
            $conexion->setUsuario($_SESSION['user']['email']);
            $conexion->query("DELETE FROM reservations WHERE id = $id");
            $afectadas = $conexion->getFilasAfectadas();
            $conexion->desconectar();

            if ($afectadas > 0) {
                $_SESSION['reserva_msg'] = ['type' => 'dark', 'text' => 'Reserva eliminada correctamente'];
            } else {
                $_SESSION['reserva_msg'] = ['type' => 'danger', 'text' => 'Error al eliminar la reserva'];
            }
        }

        header('Location: ' . SITE_URL . 'index.php?action=formReservas');
        exit;
    }

    public function logout() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Limpiar y destruir sesión
        session_unset();
        session_destroy();

        // Redirigir al login
        header("Location: index.php?action=getFormLoginUser&msg=logout");
        exit();
    }

    public function generateReport(){   
       require_once 'views/reports/reportBase.php';
    }


    }
    