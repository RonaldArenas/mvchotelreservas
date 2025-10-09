<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hotel Naturaleza</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
    }
    .navbar {
      background: linear-gradient(90deg, #1b4332, #2d6a4f);
    }
    .navbar a {
      color: white !important;
      font-weight: 500;
    }
    .hero {
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                  url('https://images.unsplash.com/photo-1506748686214-e9df14d4d9d0?auto=format&fit=crop&w=1950&q=80') no-repeat center center;
      background-size: cover;
      color: white;
      padding: 100px 20px;
      text-align: left;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .hero p {
      font-size: 1.2rem;
    }
    .room-card img {
      border-radius: 15px;
      height: 250px;
      object-fit: cover;
    }
    footer {
      background: #1b4332;
      color: white;
      padding: 20px;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Hotel Naturaleza</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#habitaciones">Habitaciones</a></li>
          <li class="nav-item"><a class="nav-link" href="#servicios">Servicios</a></li>
          <li class="nav-item"><a class="nav-link" href="#contacto">Contacto</a></li>
          <li class="nav-item"><a class="btn btn-outline-light ms-2" href="<?= SITE_URL ?>index.php?action=getFormLoginUser">Ingresar</a></li>
          <li class="nav-item"><a class="btn btn-success ms-2" href="<?= SITE_URL ?>index.php?action=getFormRegisterUser">Registrarse</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <h1>Bienvenido al Hotel Naturaleza</h1>
      <p>Un refugio en medio de la tranquilidad y la belleza natural. Vive una experiencia única rodeado de paisajes verdes y comodidad.</p>
      <a href="#habitaciones" class="btn btn-success btn-lg mt-3">Reservar Ahora</a>
    </div>
  </section>

  <!-- Habitaciones -->
  <section id="habitaciones" class="container py-5">
    <h2 class="text-center mb-4">Nuestras Habitaciones</h2>
    <p class="text-center text-muted mb-5">Descubre la comodidad y elegancia de nuestras opciones</p>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card room-card shadow-sm">
          <img src="https://images.unsplash.com/photo-1600585154356-596af9009a47?auto=format&fit=crop&w=1000&q=80" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title">Suite de Lujo</h5>
            <p class="card-text">Con vista a la montaña y jacuzzi privado.</p>
            <a href="#" class="btn btn-success w-100">Reservar</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card room-card shadow-sm">
          <img src="https://images.unsplash.com/photo-1501117716987-c8e1ecb2100d?auto=format&fit=crop&w=1000&q=80" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title">Habitación Doble</h5>
            <p class="card-text">Perfecta para parejas que aman la naturaleza.</p>
            <a href="#" class="btn btn-success w-100">Reservar</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card room-card shadow-sm">
          <img src="https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1000&q=80" class="card-img-top">
          <div class="card-body">
            <h5 class="card-title">Cabaña Familiar</h5>
            <p class="card-text">Espacio ideal para disfrutar con toda la familia.</p>
            <a href="#" class="btn btn-success w-100">Reservar</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; 2025 Hotel Naturaleza - Todos los derechos reservados</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
