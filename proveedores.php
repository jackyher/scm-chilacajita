<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="inventario.css"/>
    <title>Proveedores | Chilacajita</title>
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
      <div class="row align-items-center">
        <div class="col">
          <h1 class="fs-3 fw-bold">Proveedores</h1>
        </div>
        <div class="col-auto">
          <a class="btn btn-warning" href="/scm-chilacajita/create-proveedor.php" role="button">Nuevo Proveedor</a>
          <a class="btn btn-outline-secondary" href="/scm-chilacajita/index.html" role="button">Volver</a>
        </div>
      </div>
    </main>

    <div class="d-flex justify-content-center table-container">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Contacto</th>
                <th scope="col">Dirección</th>
                <th scope="col">Teléfono</th>
              </tr>
            </thead>
            <tbody>
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

              //Leer todas las filas de la base de datos
              $sql = "SELECT * FROM ctg_Proveedor";
              $result = $connection->query($sql);

              if (!$result) {
                die("Query inválido: " . $connection->error);
              }

              //Leemos datos de cada columna
              while($row = $result->fetch_assoc()) {
                echo "
                <tr>
                  <td>$row[id_Proveedor]</td>
                  <td>$row[nombre]</td>
                  <td>$row[contacto]</td>
                  <td>$row[direccion]</td>
                  <td>$row[telefono]</td>
                  <td>
                    <a class='btn btn-warning btn-sm' href='/scm-chilacajita/edit-proveedor.php?id_Proveedor=$row[id_Proveedor]'>Editar</a>
                    <a class='btn btn-danger btn-sm' href='/scm-chilacajita/delete-proveedor.php?id_Proveedor=$row[id_Proveedor]'>Borrar</a>
                  </td>
                </tr>
                ";
              }
              ?>
            </tbody>
          </table>
    </div>
    
    <footer class="footer mt-auto">
        <div class="container text-center">
          <p style="font-size: 0.85rem;">&copy; 2024 Todos los derechos reservados. Chilacajita</p>
        </div>
    </footer>
</body>
</html>