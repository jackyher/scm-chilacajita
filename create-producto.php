<?php
$servername = "localhost";
$username = "id19771413_jacqueline";
$password = "Chilacajita1-";
$database = "id19771413_chilacajita";

//Creamos conexión
$connection = new mysqli($servername, $username, $password, $database);

//Checamos la conexión
if ($connection->connect_error) {
  die("Conexión fallida: " . $connection->connect_error);
}

//Obtener datos de producto
$nombre = "";
$descripcion = "";
$precio_unitario = "";
$stock_disponible = "";
$stock_minimo = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $precio_unitario = $_POST["precio_unitario"];
    $stock_disponible = $_POST["stock_disponible"];
    $stock_minimo = $_POST["stock_minimo"];

    do {
        if(empty($nombre) || empty($descripcion) || empty($precio_unitario) || empty($stock_disponible) || empty($stock_minimo)) {
            $errorMessage = "Todos los campos son requeridos";
            break;
        }

        //Añadir nuevo producto a la base de datos
        $sql = "INSERT INTO ctg_Producto (nombre, descripcion, precio_unitario, stock_disponible, stock_minimo)" .
                "VALUES ('$nombre', '$descripcion', '$precio_unitario', '$stock_disponible', '$stock_minimo')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $nombre = "";
        $descripcion = "";
        $precio_unitario = "";
        $stock_disponible = "";
        $stock_minimo = "";

        $successMessage = "Producto añadido correctamente";

        header("location: /scm-chilacajita/productos.php");
        exit;
        
    } while(false);
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
    <title>Crear Producto | Chilacajita</title>
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
        <p class="fs-3 fw-bold">Nuevo Producto</p>
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

    <div class="container d-flex justify-content-center">
        <form class="form" method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nombre</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="nombre" value="<?php echo $nombre; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Descripción</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="descripcion" value="<?php echo $descripcion; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Precio Unitario</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="precio_unitario" value="<?php echo $precio_unitario; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Stock Disponible</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="stock_disponible" value="<?php echo $stock_disponible; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Stock Minimo</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="stock_minimo" value="<?php echo $stock_minimo; ?>">
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
                    <a class="btn btn-outline-danger" href="/scm-chilacajita/productos.php" role="button">Cancelar</a>
                </div>
        </form>
    </div>
    
    <footer class="footer fixed-bottom bg-whitesmoke">
        <div class="container text-center">
          <p style="font-size: 0.85rem;">&copy; 2024 Todos los derechos reservados. Chilacajita</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>