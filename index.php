<?php
session_start();

    require_once 'controllers/controllerBase.php';
    require_once 'config/config.php';
    require_once 'models/conexion.php';
    require_once 'models/user.php';

    $controllerBase = new controllerBase();

    if(isset($_GET['action'])){

        if($_GET['action'] == 'getFormRegisterUser' ){
            $controllerBase->verPaginaInicio('views/html/auth/register.php');
        }

        if($_GET['action'] == 'registerUser'){
            $controllerBase->registerUser($_POST);
        }

        if($_GET['action'] == 'getFormLoginUser' ){
            $controllerBase->verPaginaInicio('views/html/auth/login.php');
        }

        if($_GET['action'] == 'loginUser' ){
            $controllerBase->loginUser($_POST);
        }

        if($_GET['action'] == 'formReservas' ){
            $controllerBase->formReservas();
        }

        if($_GET['action'] == 'logout' ){
            $controllerBase->logout();
        }

    }

    else{
        $controllerBase->verPaginaInicio('views/html/home.php');
    }




