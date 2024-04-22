<?php
$servername = "localhost";
$username = "id19771413_jacqueline";
$password = "Chilacajita1-";
$database = "id19771413_chilacajita";

//Creamos conexión
$connection = new mysqli($servername, $username, $password, $database);


$id_Proveedor = "";
$nombre = "";
$contacto = "";
$direccion = "";
$telefono = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Para mostrar los datos de proveedor
    if (!isset($_GET["id_Proveedor"])) {
        header("location: /scm-chilacajita/proveedores.php");
        exit;
    }

    $id_Proveedor = $_GET["id_Proveedor"];
    
    //Leemos la fila del producto seleccionado desde la tabla de la base de datos
    $sql = "SELECT * FROM ctg_Proveedor WHERE id_Proveedor=$id_Proveedor";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if(!$row) {
        header("location: /scm-chilacajita/proveedores.php");
        exit;
    }

    $nombre = $row["nombre"];
    $contacto = $row["contacto"];
    $direccion = $row["direccion"];
    $telefono = $row["telefono"];

} else {
    // Para actualizar los datos de cliente
    $id_Proveedor = $_POST["id_Proveedor"];
    $nombre = $_POST["nombre"];
    $contacto = $_POST["contacto"];
    $direccion = $_POST["direccion"];
    $telefono = $_POST["telefono"];

    do {
        if(empty($id_Proveedor) || empty($nombre) || empty($contacto) || empty($direccion) || empty($telefono)) {
            $errorMessage = "Todos los campos son requeridos";
            break;
        }

        $sql = "UPDATE ctg_Proveedor " .
            "SET nombre = '$nombre', contacto = '$contacto', direccion = '$direccion', telefono = '$telefono' " .
            "WHERE id_Proveedor = $id_Proveedor";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $successMessage = "Proveedor actualizado correctamente";

        header("location: /scm-chilacajita/proveedores.php");
        exit;

    } while (false);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="inventario.css"/>
    <title>Editar Proveedor | Chilacajita</title>
</head>
<body>
    <header>
        <nav class="navbar bg-warning">
          <div class="container-fluid d-flex align-items-center justify-content-center">
            <a class="navbar-brand" href="#">
              <img src="logo.png" alt="Logo" width="200" height="30" class="d-inline-block align-text-top"/>
            </a>
          </div>
        </nav>
    </header>

    <main class="container mt-4 mb-2">
        <p class="fs-3 fw-bold">Editar Proveedor</p>
    </main>

    <?php
    if (!empty($errorMessage)) {
        echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
    ?>

    <div>
        <form class="form" method="post">
            <input type="hidden" name="id_Proveedor" value="<?php echo $id_Proveedor; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Contacto</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="contacto" value="<?php echo $contacto; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Dirección</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="direccion" value="<?php echo $direccion; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Teléfono</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="telefono" value="<?php echo $telefono; ?>">
                </div>
            </div>

            <?php
            if (!empty($successMessage)) {
                echo "
                <div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'>
                        <div class='alert alert-success alert-dismissible fade show' role='alert'>
                            <strong>$successMessage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-warning">Enviar</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-danger" href="/scm-chilacajita/proveedores.php" role="button">Cancelar</a>
                </div>
        </form>
    </div>
    
    <footer class="footer fixed-bottom bg-whitesmoke">
        <div class="container text-center">
          <p style="font-size: 0.85rem;">&copy; 2024 Todos los derechos reservados. Chilacajita</p>
        </div>
    </footer>
</body>
</html>