<?php
if (isset($_GET["id_Proveedor"])) {
    $id_Proveedor = $_GET["id_Proveedor"];

    $servername = "localhost";
    $username = "id19771413_jacqueline";
    $password = "Chilacajita1-";
    $database = "id19771413_chilacajita";

    // Crear conexión
    $connection = new mysqli($servername, $username, $password, $database);
    
    $sql = "DELETE FROM ctg_Proveedor WHERE id_Proveedor=$id_Proveedor";
    $connection->query($sql);
}

header("location: proveedores.php");
exit;
?>