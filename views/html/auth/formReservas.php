<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reservas - Hotel Naturaleza</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      height: 100vh;
      display: flex;
      flex-direction: column;
    }
    header {
      background-color: #155d34;
      color: #fff;
      padding: 8px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header h2 {
      margin: 0;
      font-weight: bold;
      font-size: 20px;
    }
    nav a {
      color: #fff;
      margin-left: 15px;
      text-decoration: none;
      font-weight: 500;
    }
    .btn-logout {
      border: 1px solid #fff;
      padding: 5px 12px;
      border-radius: 6px;
      transition: background 0.3s;
    }
    .btn-logout:hover {
      background: #fff;
      color: #155d34 !important;
    }
    .content {
      flex: 1;
      display: flex;
      justify-content: space-around;
      align-items: flex-start;
      padding: 30px;
      gap: 20px;
    }
    .form-container, .table-container {
      background: rgba(255,255,255,0.95);
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
    }
    .form-container {
      width: 480px;
    }
    .table-container {
      flex: 1;
      overflow-y: auto;
      max-height: 550px;
    }
    .form-container h2 {
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 24px;
    }
    .btn-primary {
      background-color: #1c8c44;
      border: none;
    }
    .btn-primary:hover {
      background-color: #157a39;
    }
    .btn-action {
      border: none;
      padding: 5px 8px;
      border-radius: 6px;
      cursor: pointer;
    }
    footer {
      background-color: #155d34;
      color: #fff;
      text-align: center;
      padding: 8px;
      font-size: 13px;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <h2>Hotel Naturaleza</h2>
    <?php
      if (isset($_SESSION['user']['name'])) {
          echo "<h2>Bienvenido " . htmlspecialchars($_SESSION['user']['name']) . " 👋</h2>";
      } else {
          echo "<h2>Bienvenido invitado</h2>";
      }
    ?>
    <nav>
      <a href="#">Inicio</a>
      <a href="#">Habitaciones</a>
      <a href="#">Servicios</a>
      <a href="#">Contacto</a>
      <a href="index.php?action=logout" class="btn btn-warning">Cerrar sesión</a>
    </nav>
  </header>

  <!-- Contenido -->
  <div class="content">
    <!-- Formulario -->
    <div class="form-container">
      <div class="mb-2 text-center">
        <i class="fa-solid fa-calendar-check fa-2x" style="color:#1c8c44;"></i>
      </div>
      

      <form action="<?= SITE_URL ?>index.php?action=registerReserva" method="POST">
        <h2>Reservar habitación</h2>
        <p class="text-muted">Complete los datos para su reserva</p>
          


        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="nombre" class="form-control" placeholder="Nombres" >
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="apellido" class="form-control" placeholder="Apellidos" >
        </div>

        <div class="row mb-3">
          <div class="col input-group">
            <span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
            <input type="date" name="fecha_entrada" class="form-control" >
          </div>
          <div class="col input-group mt-2 mt-md-0">
            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
            <input type="date" name="fecha_salida" class="form-control" >
          </div>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-bed"></i></span>
          <select name="habitacion" class="form-select" >
            <option value="">Tipo de habitación...</option>
            <option value="individual">Individual</option>
            <option value="doble">Doble</option>
            <option value="suite">Suite</option>
          </select>
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user-group"></i></span>
          <input type="number" name="personas" class="form-control" placeholder="Número de personas" min="1" max="6" >
        </div>

        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-comment"></i></span>
          <textarea name="comentarios" class="form-control" rows="2" placeholder="Comentarios o solicitudes especiales"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100" name="btnregister" value="1">Confirmar Reserva</button>
      </form>
    </div>

    <!-- Tabla de reservas -->
    <div class="table-container">
      <h4 class="mb-3 text-center text-success">Reservas recientes</h4>

      <?php
          if (isset($_SESSION['reserva_msg'])) {
              $msg = $_SESSION['reserva_msg'];
              echo '<div class="alert alert-' . $msg['type'] . ' mt-2">' . $msg['text'] . '</div>';
              unset($_SESSION['reserva_msg']); // limpiar para no mostrarlo otra vez
          }
      ?>
      <table class="table table-striped table-bordered">
        <thead class="table-success">
          <tr>
            <th>nombre</th>
            <th>Apellido</th>
            <th>Fecha entrada</th>
            <th>fecha salida</th>
            <th>Habitación</th>
            <th>Numero de personas</th>
            <th>Comentarios</th>
            <th>Opciones</th>
          </tr>
        </thead>
        <tbody>
         <?php
              // Instanciamos la clase y conectamos
              $conexion = new conexion();
              $conexion->conectar();

              // Ejecutamos la consulta
              $userId = $_SESSION['user']['id'];
              $conexion->query("SELECT * FROM reservations WHERE user_id = $userId");
              $resultado = $conexion->getResult(); // obtenemos el resultado

              // Recorremos los datos
              while($datos = $resultado->fetch_object()){?>
                <tr>
                  <td><?= $datos->nombre ?></td>
                  <td><?= $datos->apellido ?></td>
                  <td><?= $datos->fecha_entrada ?></td>
                  <td><?= $datos->fecha_salida ?></td>
                  <td><?= $datos->habitacion ?></td>
                  <td><?= $datos->personas ?></td>
                  <td><?= $datos->comentarios ?></td>
                  <td>
                    <a href="<?= SITE_URL ?>index.php?action=editarReserva&id=<?= $datos->id ?>" class="btn btn-small btn-warning"><i class="fa-solid fa-pen-to-square"></i></a>
                    <a href="<?= SITE_URL ?>index.php?action=eliminarReserva&id=<?= $datos->id ?>" onclick="return confirm('¿Estás seguro de eliminar esta reserva?')" class="btn btn-small btn-danger"><i class="fa-solid fa-trash"></i></a>
                  </td>
                </tr>
              <?php }
              ?>
                     
        </tbody>
        
      </table>
      <div class="text-center mt-3">
        <a href="<?= SITE_URL ?>index.php?action=generateReport" class="btn btn-dark" target="_blank"><i class="fas fa-file-invoice-dollar me-2"></i>Generar Reporte PDF</a>
        <a href="<?= SITE_URL ?>index.php?action=generateReportExcel" class="btn btn-primary" target="_blank"><i class="fas fa-file-invoice-dollar me-2"></i>Generar Reporte EXCEL</a>
      </div>
    </div>
   
  </div>
  

  <footer>
    © 2025 Hotel Naturaleza - Todos los derechos reservados
  </footer>
</body>
</html>