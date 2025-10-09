<?php
    class User{

        public function validateUser($email){
            $conexion = new Conexion();
            $conexion->conectar();
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $conexion->query($sql);
            $result = $conexion->getResult();
            $conexion->desconectar();
            if($result->num_rows > 0){
                return 1;
            }
            return 0;
        }

        public function registerUser($data){
            $conexion = new  Conexion();
            $conexion->conectar();
            $sql = "INSERT INTO users (document_type_id, document_number, name, lastname, phone,email, password, rol_id) VALUES ('$data[document_type_id]', '$data[document_number]', '$data[name]', '$data[lastname]', '$data[phone]', '$data[email]', '$data[password]', 2)";
            $conexion->query($sql);
            return $conexion->getFilasAfectadas();
        }

        public function validateLogin($email, $password) {
        $conexion = new Conexion();
        $conexion->conectar();

        // Buscar usuario por email
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $conexion->query($sql);
        $result = $conexion->getResult();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verificar la contraseña cifrada
            if (password_verify($password, $user['password'])) {

                // Guardar usuario en la sesión si es necesario
                $_SESSION['user'] = [
                    'id'        => $user['id'],
                    'name'      => $user['name'],
                    'lastname'  => $user['lastname'],
                    'email'     => $user['email'],
                    'rol_id'    => $user['rol_id']
                ];

                $conexion->desconectar();
                return true;
            }
        }

        $conexion->desconectar();
        return false;
    }

    }