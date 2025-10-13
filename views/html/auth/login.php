<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Hotel Naturaleza</title>
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
    .btn-ingresar {
      border: 1px solid #fff;
      padding: 5px 12px;
      border-radius: 6px;
      transition: background 0.3s;
    }
    .btn-ingresar:hover {
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
      width: 500px; /* más grande y proporcional */
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
    .extra-text {
      margin-top: 15px;
      font-size: 14px;
    }
    .extra-text a {
      text-decoration: none;
      font-weight: bold;
      color: #1c8c44;
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
      <a href="#" class="btn-ingresar">Ingresar</a>
    </nav>
  </header>

  <!-- Contenido con formulario -->
  <div class="content">
    <div class="form-container">
      <div class="mb-2">
        <i class="fa-solid fa-user-plus fa-2x" style="color:#1c8c44;"></i>
      </div>
      <h2>Iniciar Sesión</h2>
      <p>Ingresa tus datos</p>
    
    
    
      <?php if (isset($_SESSION['errors']['login'])): ?>
    <div class="alert alert-danger" role="alert">
        <?= $_SESSION['errors']['login']; ?>
    </div>
    <?php unset($_SESSION['errors']['login']); ?>
    <?php endif; ?>


    

      <form action="<?= SITE_URL ?>index.php?action=loginUser" method="post" >
        
        
        <!-- Email -->
        <div class="row mb-3">
          <div class="col-6 input-group">
            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
            <input type="email" class="form-control" name="email" placeholder="Email" value="<?= $_SESSION['old']['email'] ?? '' ?>">
          </div>
        </div>

        <!-- Contraseña -->
        <div class="input-group mb-2">
          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
          <input type="password" class="form-control" name="password" placeholder="Contraseña">
        </div>

        <!-- Botón -->
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>

        <!-- Texto extra -->
        <div class="extra-text">
          ¿No tienes cuenta? <a href="<?= SITE_URL ?>index.php?action=getFormRegisterUser">Registrate aquí</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    © 2025 Hotel Naturaleza - Todos los derechos reservados
  </footer>
</body>
</html>
