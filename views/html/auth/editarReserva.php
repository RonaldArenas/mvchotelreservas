<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Reserva - Hotel Naturaleza</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow p-4">
      <h3 class="text-center text-success mb-4"><i class="fa-solid fa-pen-to-square"></i> Editar Reserva</h3>
      <form action="<?= SITE_URL ?>index.php?action=editarReserva" method="POST">
        <input type="hidden" name="id" value="<?= $reserva['id'] ?>">

        <div class="row mb-3">
          <div class="col">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $reserva['nombre'] ?>" required>
          </div>
          <div class="col">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="<?= $reserva['apellido'] ?>" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <label>Fecha entrada</label>
            <input type="date" name="fecha_entrada" class="form-control" value="<?= $reserva['fecha_entrada'] ?>" required>
          </div>
          <div class="col">
            <label>Fecha salida</label>
            <input type="date" name="fecha_salida" class="form-control" value="<?= $reserva['fecha_salida'] ?>" required>
          </div>
        </div>

        <div class="mb-3">
          <label>Tipo de habitación</label>
          <select name="habitacion" class="form-select" required>
            <option <?= $reserva['habitacion'] == 'individual' ? 'selected' : '' ?> value="individual">Individual</option>
            <option <?= $reserva['habitacion'] == 'doble' ? 'selected' : '' ?> value="doble">Doble</option>
            <option <?= $reserva['habitacion'] == 'suite' ? 'selected' : '' ?> value="suite">Suite</option>
          </select>
        </div>

        <div class="mb-3">
          <label>Número de personas</label>
          <input type="number" name="personas" class="form-control" value="<?= $reserva['personas'] ?>" min="1" max="6" required>
        </div>

        <div class="mb-3">
          <label>Comentarios</label>
          <textarea name="comentarios" class="form-control" rows="2"><?= $reserva['comentarios'] ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
          <a href="<?= SITE_URL ?>index.php?action=formReservas" class="btn btn-secondary">Cancelar</a>
          <button type="submit" class="btn btn-success" name="btneditar" value="1">Guardar cambios</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
