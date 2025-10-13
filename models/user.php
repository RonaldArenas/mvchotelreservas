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

        
        public function validateLogin($email) {
            $conexion = new Conexion();
            $conexion->conectar();
            $sql = "SELECT * FROM users where email = '$email'";
            $conexion->query($sql);
            $result = $conexion->getResult();
            return $result;
        
        }
    }