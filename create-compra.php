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

//Obtener los datos de productos
$query_productos = "SELECT id_Producto, nombre FROM ctg_Producto";
$result_productos = $connection->query($query_productos);

//Obtener datos de proveedores
$query_proveedores = "SELECT id_Proveedor, nombre FROM ctg_Proveedor";
$result_proveedores = $connection->query($query_proveedores);

//Obtener datos de compras

$producto = "";
$proveedor = "";
$cod_barra = mt_rand(1000000000, 9999999999);
$cantidad = "";
$precio_unitario_compra = "";
$fecha_compra = date("Y-m-d H:i:s");

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = $_POST["producto"];
    $proveedor = $_POST["proveedor"];
    $cod_barra = $_POST["cod_barras"];
    $cantidad = $_POST["cantidad"];
    $precio_unitario_compra = $_POST["precio_unitario_compra"];
    $fecha_compra = $_POST["fecha_compra"];

    do {
        if(empty($producto) || empty($proveedor) || empty($cod_barra) || empty($cantidad) || empty($precio_unitario_compra) || empty($fecha_compra)) {
            $errorMessage = "All the fields are required";
            break;
        }

        //Añadir nueva compra a la base de datos
        $sql = "INSERT INTO ms_compras (id_Producto, id_Proveedor, cod_barras, cantidad, precio_unitario_compra, fecha_compra)" .
                "VALUES ('$producto', '$proveedor', '$cod_barra', '$cantidad', '$precio_unitario_compra', '$fecha_compra')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        //Actualizar el stock disponible en la tabla de productos
        $sql_update_stock = "UPDATE ctg_Producto SET stock_disponible = stock_disponible + '$cantidad' WHERE id_Producto = '$producto'";
        $result_update_stock = $connection->query($sql_update_stock);

        if (!$result_update_stock) {
            $errorMessage = "Error al actualizar el stock: " . $connection->error;
            break;
        }

        $producto = "";
        $proveedor = "";
        $cod_barra = "";
        $cantidad = "";
        $precio_unitario_compra = "";
        $fecha_compra = "";

        $successMessage = "Compra añadida correctamente";

        header("location: /scm-chilacajita/compras.php");
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
    <title>Crear Compra | Chilacajita</title>
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
        <p class="fs-3 fw-bold">Nueva Compra</p>
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
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Producto</label>
                <div class="col-sm-6">
                    <select class="form-select" name="producto">
                        <?php
                        while ($row = $result_productos->fetch_assoc()) {
                            echo "<option value='" . $row['id_Producto'] . "'>" . $row['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Proveedor</label>
                <div class="col-sm-6">
                    <select class="form-select" name="proveedor">
                        <?php
                        while ($row = $result_proveedores->fetch_assoc()) {
                            echo "<option value='" . $row['id_Proveedor'] . "'>" . $row['nombre'] . "</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Código de barras</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="cod_barras" value="<?php echo $cod_barra; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Cantidad</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="cantidad" value="<?php echo $cantidad; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Precio unitario</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="precio_unitario_compra" value="<?php echo $precio_unitario_compra; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Fecha</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="fecha_compra" value="<?php echo $fecha_compra; ?>">
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
                    <a class="btn btn-outline-danger" href="/scm-chilacajita/compras.php" role="button">Cancelar</a>
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