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

    }
    