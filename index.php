<!DOCTYPE html>
<html>
<head>
  <title>Xestión de alumnos 2000</title>
</head>
<body>

  <center><img src="imaxe.jpg"/></center>

  <h1>Crear táboa de alumnos</h1>

  <form method="post">
    <input type="submit" name="crear_db" value="Crear base de datos">
  </form>

  <?php

  // Se pulsaches o botón para crear a base de datos
  if (isset($_POST['crear_db'])) {

    // Incluir el ficheiro de configuración da base de datos
    require_once 'config.php';

    // Crear a conexión á base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar se a conexión se fixo correctamente
    if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
      echo "A base de datos $dbname creouse correctamente.";
      $conn->select_db($dbname);
      // Crear táboa alumnos con clave primaria autoincremental
      $sql = "CREATE TABLE alumnos (
          id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
          nome VARCHAR(30) NOT NULL,
          apelidos VARCHAR(30) NOT NULL
      )";
      if ($conn->query($sql) === TRUE) {
        echo "A táboa alumnos creouse correctamente.";
      } else {
        echo "Erro creando a táboa alumnos: " . $conn->error;
      }
    } else {
      echo "Erro creando a base de datos $dbname: " . $conn->error;
    }

    // Pechar a conexión á base de datos
    $conn->close();
  }
  ?>

  <h1>Introducir datos de alumno</h1>
  <form method="post">
    <label>Nome:</label>
    <input type="text" name="nome"><br><br>
    <label>Apelidos:</label>
    <input type="text" name="apelidos"><br><br>
    <input type="submit" name="gardar" value="Gardar">
  </form>

  <?php

  // Se pulsaches o botón gardar
  if (isset($_POST['gardar'])) {

    // Incluir ficheiro de configuración da base de datos
    require_once 'config.php';

    // Crear a conexión á base de datos
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar conexión
    if ($conn->connect_error) {
      die("Conexión fallida: " . $conn->connect_error);
    }

    // Obter valores do formulario
    $nome = $_POST['nome'];
    $apelidos = $_POST['apelidos'];

    // Insertar datos na táboa
    $sql = "INSERT INTO alumnos (nome, apelidos) VALUES ('$nome', '$apelidos')";

    if ($conn->query($sql) === TRUE) {
      echo "Os datos do alumno gardáronse correctamente.";
    } else {
      echo "Erro gardando os datos do alumno: " . $conn->error;
    }

    $conn->close();
  }
  ?>

  <hr/>

  <?php
  require_once 'config.php';

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
  }
  // Obter lista de alumnos da táboa
  $sql = "SELECT * FROM alumnos";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Amosar a lista de alumnos
    echo "<h2>Lista de alumnos:</h2>";
    echo "<ul>";
    while($row = $result->fetch_assoc()) {
      echo "<li>(" . $row["id"] . ") " . $row["nome"] . " " . $row["apelidos"] . "</li>";
    }
    echo "</ul>";
  } else {
    echo "Non hai alumnos rexistrados.";
  }

  $conn->close();
  ?>

</body>
</html>
