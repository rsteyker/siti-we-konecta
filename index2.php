<?php 
    //Importar la conexión a la bd
    include("./config/database.php");

    //Creamos la función para obtener todos los producto
    function obtenerProductos($conn){
        $sql = "SELECT * FROM  productos";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }else{
            return array();
        }
    }


    // Creamos la función para agregar un nuevo producto
    function agreagrProducto($conn, $nombre, $referencia, $precio, $peso, $categoria, $stock, $fecha_creacion){
        $sql = "INSERT INTO productos (nombre_producto, referencia, precio, peso, categoria, stock, fecha_creacion) 
                VALUES ('$nombre', '$referencia', $precio, $peso, '$categoria', $stock, '$fecha_creacion')";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Cramos la función para editar un producto existente
    function editarProducto($conn, $id, $nombre, $referencia, $precio, $peso, $categoria, $stock, $fecha_creacion){
        $sql = "UPDATE productos SET nombre_producto='$nombre', referencia='$referencia', precio=$precio, peso=$peso, categoria='$categoria', stock=$stock, fecha_creacion='$fecha_creacion' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Creamos la función para eliminar un producto
    function eliminarProducto($conn, $id){
        $sql = "DELETE FROM productos WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }


    // Procesamos el formulario de agregar/editar producto
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // Obtener los datos del formulario
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $referencia = $_POST["referencia"];
        $precio = $_POST["precio"];
        $peso = $_POST["peso"];
        $categoria = $_POST["categoria"];
        $stock = $_POST["stock"];
        $fecha_creacion = $_POST["fecha_creacion"];

        // Agregar o editar el producto según el valor del campo "id"
        if ($id == "id") {
            agreagrProducto($conn, $nombre, $referencia, $precio, $peso, $categoria, $stock, $fecha_creacion);
        } else {
            editarProducto($conn, $id, $nombre, $referencia, $precio, $peso, $categoria, $stock, $fecha_creacion);
        }
    }

    // Luego procesamos la eliminación de un producto
    if (isset($_GET["eliminar"])) {
        $id = $_GET["eliminar"];
        eliminarProducto($conn, $id);
    }

    // Obtenemos todos los productos de la base de datos
    $productos = obtenerProductos($conn);





    // Función para realizar una venta
    function realizarVenta($conn, $idProducto, $cantidad){
      // Verificar si el producto tiene stock suficiente
      $producto = obtenerProductoPorId($conn, $idProducto);
      if ($producto["stock" >= $cantidad]) {
        // Restar la cantidad del producto vendido al stock
        $nuevoStock = $producto["stock"] - $cantidad;
        $sqlUpdateStock = "UPDATE productos SET stock=$nuevoStock WHERE id=$idProducto";
        $conn->query($sqlUpdateStock);

        // Registrar la venta en la tabla de ventas
        $fechaVenta = date("Y-m-d");
        $sqlInsertVenta = "INSERT INTO ventas (id_producto, cantidad, fecha_venta) 
                           VALUES ($idProducto, $cantidad, '$fechaVenta')";
        $conn->query($sqlInsertVenta);

        return true;
      } else {
        return false;
      }

    }

    // Obtener un producto por su ID
    function obtenerProductoPorId($conn, $id){
      $sql = "SELECT * FROM productos WHERE id=$id";
      $resultado = $conn->query($sql);

      if ($resultado->num_rows == 1) {
        return $resultado->fetch_assoc();
      } else {
        return null;
      }
    }

    // Procesar la venta de un producto
    if (isset($_POST["venta"])) {
      $idProducto = $_POST["id_producto"];
      $cantidad = $_POST["cantidad"];
    
      if (realizarVenta($conn, $idProducto, $cantidad)) {
        echo "Venta realizada con éxito.";
      } else {
        echo "No es posible realizar la venta. Stock insuficiente.";
      }
    }

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Productos Konecta</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <h1>Gestión de Productos Konecta</h1>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Referencia</th>
          <th>Precio</th>
          <th>Peso</th>
          <th>Categoría</th>
          <th>Stock</th>
          <th>Fecha de Creación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($productos as $producto) { ?>
          <tr>
            <td><?php echo $producto["id"]; ?></td>
            <td><?php echo $producto["nombre_producto"]; ?></td>
            <td><?php echo $producto["referencia"]; ?></td>
            <td><?php echo $producto["precio"]; ?></td>
            <td><?php echo $producto["peso"]; ?></td>
            <td><?php echo $producto["categoria"]; ?></td>
            <td><?php echo $producto["stock"]; ?></td>
            <td><?php echo $producto["fecha_creacion"]; ?></td>
            <td>
              <a href="?eliminar=<?php echo $producto["id"]; ?>" class="btn btn-danger btn-sm">Eliminar</a>
              <a href="?editar=<?php echo $producto["id"]; ?>" class="btn btn-success btn-sm">Editar</a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <h2>Agregar/Editar Producto</h2>
    <form method="POST">
      <input type="hidden" name="id" value="">
      <div class="form-group">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>
      </div>
      <div class="form-group">
        <label for="referencia">Referencia:</label>
        <input type="text" class="form-control" id="referencia" name="referencia" required>
      </div>
      <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="number" class="form-control" id="precio" name="precio" required>
      </div>
      <div class="form-group">
        <label for="peso">Peso:</label>
        <input type="number" class="form-control" id="peso" name="peso" required>
      </div>
      <div class="form-group">
        <label for="categoria">Categoría:</label>
        <input type="text" class="form-control" id="categoria" name="categoria" required>
      </div>
      <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="number" class="form-control" id="stock" name="stock" required>
      </div>
      <div class="form-group">
        <label for="fecha_creacion">Fecha de Creación:</label>
        <input type="date" class="form-control" id="fecha_creacion" name="fecha_creacion" required>
      </div>
      <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
  </div>

  <section class="container mt-5 mb-5">
    <h2>Realizar Venta</h2>
    <form method="POST">
      <div class="form-group">
        <label for="id_producto">ID del Producto:</label>
        <input type="number" class="form-control" id="id_producto" name="id_producto" required>
      </div>
      <div class="form-group">
        <label for="cantidad">Cantidad:</label>
        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
      </div>
      <button type="submit" class="btn btn-primary" name="venta">Realizar Venta</button>
    </form>
  </section>


  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>