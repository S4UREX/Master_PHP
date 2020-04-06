<?php

//Iniciar la sesion y la conexion a la base de datos
require_once 'includes/conexion.php';

//Recoger los datos del formulario
if(isset($_POST)){

    //Borrar error antiguo
    if(isset($_SESSION['error_login'])){
        unset($_SESSION['error_login']);
    }

    //Datos del formulario
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password_segura = '';

    //Consulta para comprobar las credenciales del usuario
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $login = mysqli_query($db, $sql);

    if($login && mysqli_num_rows($login) == 1 ){

        $usuario = mysqli_fetch_assoc($login);

        //Comprobar la contraseña
        $verify = password_verify($password, $usuario['password']);

        if($verify){
            //Utilizar una sesion para guardar los datos del usuario logueado
            $_SESSION['usuario'] = $usuario;

        }else{
            //Si algo falla mandar una sesion con el fallo
            $_SESSION['error_login'] = "Login incorrecto";
        }

    }else{
        //Mensaje de error

    }
}

//Redirigir al index
header("Location: index.php");