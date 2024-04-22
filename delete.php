<?php
if (isset($_GET["id_Producto"])) {
    $id_Producto = $_GET["id_Producto"];

    $servername = "localhost";
    $username = "id19771413_jacqueline";
    $password = "Chilacajita1-";
    $database = "id19771413_chilacajita";

    // Crear conexión
    $connection = new mysqli($servername, $username, $password, $database);
    
    $sql = "DELETE FROM ctg_Producto WHERE id_Producto=$id_Producto";
    $connection->query($sql);
}

header("location: productos.php");
exit;
?>