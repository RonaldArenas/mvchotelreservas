<?php
session_start();

    require_once 'controllers/controllerBase.php';
    require_once 'controllers/controllerReservation.php';
    require_once 'config/config.php';
    require_once 'models/conexion.php';
    require_once 'models/user.php';
    require_once 'lib/fpdf/fpdf.php';

    $controllerBase = new controllerBase();
    $controllerReservation = new controllerReservation();

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

        if($_GET['action'] == 'loginUser'){
            $controllerBase->loginUser($_POST);
        }

        if($_GET['action'] == 'formReservas' ){
            $controllerBase->verPaginaInicio('views/html/auth/formReservas.php');
        }

        if($_GET['action'] == 'logout' ){
            $controllerReservation->logout();
        }

        if($_GET['action'] == 'registerReserva' ){
            $controllerReservation->registerReserva($_POST);
        }

        if($_GET['action'] == 'editarReserva' ){
            $controllerReservation->editarReserva($_POST);
        }

         if($_GET['action'] == 'eliminarReserva' ){
            $controllerReservation->eliminarReserva($_POST);
        }

        if($_GET['action'] == 'generateReport' ){
            $controllerReservation->generateReport();
        }

        

    }

    else{
        $controllerBase->verPaginaInicio('views/html/home.php');
    }