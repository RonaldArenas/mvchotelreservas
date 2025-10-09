<?php


// si el usuario no está logueado, lo enviamos al login
if (!isset($_SESSION['user'])) {
  header('Location: index.php?action=getLoginUser');
  exit;
}
?>

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
      display: flex;
      flex-direction: column;
      height: 100vh;
    }
    header {
      background-color: #155d34;
      color: #fff;
      padding: 8px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 15px;
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
      justify-content: center;
      align-items: center;
      padding: 10px;
    }
    .form-container {
      background: rgba(255,255,255,0.95);
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.25);
      width: 550px;
      text-align: center;
    }
    .form-container h2 {
      font-weight: bold;
      margin-bottom: 8px;
      font-size: 24px;
    }
    .form-container p {
      color: #6c757d;
      font-size: 14px;
      margin-bottom: 20px;
    }
    .input-group-text {
      background: #f1f1f1;
    }
    .btn-primary {
      background-color: #1c8c44;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      padding: 10px;
    }
    .btn-primary:hover {
      background-color: #157a39;
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
    <nav>
      <a href="#">Inicio</a>
      <a href="#">Habitaciones</a>
      <a href="#">Servicios</a>
      <a href="#">Contacto</a>
      <a href="index.php?action=logout" class="btn-logout">Cerrar sesión</a>
    </nav>
  </header>

  <!-- Contenido con formulario -->
  <div class="content">
    <div class="form-container">
      <div class="mb-2">
        <i class="fa-solid fa-calendar-check fa-2x" style="color:#1c8c44;"></i>
      </div>
      <h2>Reservar habitación</h2>
      <p>Complete los datos para su reserva</p>

      <form action="index.php?action=guardarReserva" method="POST">

        <!-- Nombre -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="nombre" class="form-control" 
                 value="<?= $_SESSION['user']['name'] ?>" readonly>
        </div>

        <!-- Apellido -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
          <input type="text" name="apellido" class="form-control" 
                 value="<?= $_SESSION['user']['lastname'] ?>" readonly>
        </div>

        <!-- Fechas -->
        <div class="row mb-3">
          <div class="col input-group">
            <span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
            <input type="date" name="fecha_entrada" class="form-control" required>
          </div>
          <div class="col input-group mt-2 mt-md-0">
            <span class="input-group-text"><i class="fa-solid fa-calendar-days"></i></span>
            <input type="date" name="fecha_salida" class="form-control" required>
          </div>
        </div>

        <!-- Habitación -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-bed"></i></span>
          <select name="habitacion" class="form-select" required>
            <option value="">Tipo de habitación...</option>
            <option value="individual">Individual</option>
            <option value="doble">Doble</option>
            <option value="suite">Suite</option>
          </select>
        </div>

        <!-- Número de personas -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-user-group"></i></span>
          <input type="number" name="personas" class="form-control" placeholder="Número de personas" min="1" max="6" required>
        </div>

        <!-- Comentarios -->
        <div class="input-group mb-3">
          <span class="input-group-text"><i class="fa-solid fa-comment"></i></span>
          <textarea name="comentarios" class="form-control" rows="2" placeholder="Comentarios o solicitudes especiales"></textarea>
        </div>

        <!-- Botón -->
        <button type="submit" class="btn btn-primary w-100">Confirmar Reserva</button>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    © 2025 Hotel Naturaleza - Todos los derechos reservados
  </footer>
</body>
</html>
