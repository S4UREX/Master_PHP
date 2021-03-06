<?php

function mostrarErrores($errores, $campo)
{
    $alerta = '';
    if (isset($errores[$campo]) && !empty($campo)) {
        $alerta = "<div class='alerta alerta-error'>" . $errores[$campo] . "</div>";
    }

    return $alerta;
}

function borrarErrores()
{
    $borrado = false;

    if (isset($_SESSION['errores'])) {
        $_SESSION['errores'] = null;
        $borrado = true;
    }

    if (isset($_SESSION['errores_entrada'])) {
        $_SESSION['errores_entrada'] = null;
        $borrado = true;
    }

    if (isset($_SESSION['completado'])) {
        $_SESSION['completado'] = null;
        $borrado = true;
    }

    return $borrado;
}

function conseguirCategoria($db)
{
    $sql = "SELECT * FROM categorias ORDER BY id";
    $categorias = mysqli_query($db, $sql);
    $resultado = array();

    if ($categorias && mysqli_num_rows($categorias) >= 1) {
        $resultado = $categorias;
    }

    return $resultado;
}

function conseguirEntrada($conexion, $id){
    $sql = "
    SELECT e.*, c.nombre AS 'categoria', CONCAT(u.nombre,' ',u.apellidos) AS 'usuario'
    FROM entradas AS e 
    INNER JOIN categorias AS c
        ON e.categoria_id = c.id
    INNER JOIN usuarios AS u 
        ON e.usuario_id = u.id
    WHERE e.id = $id;";

    $entrada = mysqli_query($conexion, $sql);

    $resultado = array();

    if($entrada && mysqli_num_rows($entrada) >= 1){
        $resultado = mysqli_fetch_assoc($entrada);
    }

    return $resultado;

}

function conseguirEntradas($conexion, $limit = null, $categoria = null, $busqueda = null)
{
    $sql = "SELECT e.*, c.nombre AS 'categoria'
            FROM entradas AS e
            INNER JOIN categorias c 
            ON e.categoria_id = c.id";

    if(!empty($categoria)){
        $sql .= " WHERE c.id = $categoria";
    }

    if(!empty($busqueda)){
        $sql .= " WHERE e.titulo LIKE '%$busqueda%' ";
    }

    $sql .= " ORDER BY e.id DESC";

    if($limit != null){
        $sql .= " LIMIT 4";
    }

    $entradas = mysqli_query($conexion, $sql);
    $resultado = array();
    if ($entradas && mysqli_num_rows($entradas) >= 1) {
        $resultado = $entradas;
    }
    return $resultado;
}



function limitarPalabras($palabra, $limite){
    $delimitar = explode(" ", $palabra);
    $resultado = "";

    //Mostramos hasta el limite de palabras
    for ($i = 0; $i < $limite; $i++){
        if($i >= count($delimitar)){//En caso de superar el maximo de palabras, salimos para evitar errores
            break;
        }
        $resultado .= $delimitar[$i]." ";
    }

    //al maximo de palabras, indicamos que hay mas palabras
    if(count($delimitar) > $limite){
        $resultado .= "...";
    }

    return $resultado;
}