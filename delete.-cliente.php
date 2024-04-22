<?php
if (isset($_GET["id_Cliente"])) {
    $id_Cliente = $_GET["id_Cliente"];

    $servername = "localhost";
    $username = "id19771413_jacqueline";
    $password = "Chilacajita1-";
    $database = "id19771413_chilacajita";

    // Crear conexión
    $connection = new mysqli($servername, $username, $password, $database);
    
    $sql = "DELETE FROM ctg_cliente WHERE id_Cliente=$id_Cliente";
    $connection->query($sql);
}

header("location: cliente.php");
exit;
?>