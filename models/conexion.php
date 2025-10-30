<?php

class conexion {

    private $mySQLI;
    private $sql;
    private $result;
    private $filasAfectadas;
    private $usuario; 

    public function conectar() {
        $host = 'localhost';
        $db = "hotel_reservas";
        $user = 'root';
        $password = '';
        $this->mySQLI = new mysqli($host,$user,$password,$db);
        if(mysqli_connect_error()){
            throw new Exception('Error de conexion a la base de datos');
        }
    }

    // $conexion=new mysqli("localhost", "root", "", "hotel_reservas");
    // $conexion->set_charset("utf8");

    public function desconectar() {
        $this->mySQLI->close();
    }

    public function query($sql) {
        $this->sql = $this->prepararAuditoria($sql); // <-- agregado
        $this->result = $this->mySQLI->query($sql);
        $this->filasAfectadas = $this->mySQLI->affected_rows;
    }

    public function getResult(){
        return $this->result;
    }
        
    public function getFilasAfectadas(){
        return $this->filasAfectadas;
    }

    public function setUsuario($usuario) { // <-- agregado
        $this->usuario = $usuario;
    }

    private function prepararAuditoria($sql) {
    $usuario = $this->usuario ?? 'sistema';

    // Si es un INSERT → agregar created_at / created_by si no existen
    if (stripos($sql, 'insert into') === 0) {
        // Si no tiene created_at, lo agregamos
        if (stripos($sql, 'created_at') === false && stripos($sql, 'created_by') === false) {
            $sql = preg_replace(
                '/\)\s*values\s*\(/i',
                ', created_at, created_by) VALUES (NOW(), "' . $usuario . '", ',
                $sql
            );
        }
    }

    // Si es un UPDATE → agregar updated_at / updated_by
    if (stripos($sql, 'update') === 0) {
        if (stripos($sql, 'updated_at') === false && stripos($sql, 'updated_by') === false) {
            $sql = preg_replace(
                '/set\s+/i',
                'SET updated_at = NOW(), updated_by = "' . $usuario . '", ',
                $sql
            );
        }
    }

    // Si es un DELETE → convertir a borrado lógico
    if (stripos($sql, 'delete from') === 0) {
        $sql = preg_replace(
            '/delete from\s+(\w+)\s+where\s+id\s*=\s*(\d+)/i',
            'UPDATE $1 SET deleted_at = NOW(), deleted_by = "' . $usuario . '" WHERE id = $2',
            $sql
        );
    }

    return $sql;
    }

    public function getConexion() {
    return $this->mySQLI;
    }


}