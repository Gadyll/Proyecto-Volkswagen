<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Volkswagen | Panel Administrativo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root {
      --vw-dark: #0a1931;
      --vw-blue: #0055a5;
      --vw-gray: #f4f6f9;
      --vw-light: #e9eef5;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--vw-gray);
      overflow-x: hidden;
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      background: var(--vw-dark);
      color: white;
      display: flex;
      flex-direction: column;
      padding: 20px 0;
      z-index: 100;
    }

    .sidebar .brand {
      text-align: center;
      font-weight: bold;
      color: white;
      margin-bottom: 40px;
    }

    .sidebar .brand img {
      width: 50px;
      height: 50px;
      margin-bottom: 10px;
    }

    .nav-link {
      color: #cbd3e1 !important;
      font-weight: 500;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      border-left: 3px solid transparent;
      transition: all 0.25s;
    }

    .nav-link:hover,
    .nav-link.active {
      background: var(--vw-blue);
      color: #fff !important;
      border-left-color: #00a2ff;
    }

    .sidebar .footer {
      margin-top: auto;
      padding: 15px;
      text-align: center;
      font-size: 0.8rem;
      color: #9faec6;
    }

    /* ===== CONTENT AREA ===== */
    .content {
      margin-left: 260px;
      padding: 30px;
    }

    .card {
      border: none;
      border-radius: 12px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
      background: #fff;
    }

    .btn-vw {
      background: var(--vw-blue);
      color: white;
      border: none;
      transition: 0.2s;
    }

    .btn-vw:hover {
      background: #003e7c;
      color: white;
    }

    .alert {
      border-radius: 10px;
    }

    @media (max-width: 992px) {
      .sidebar {
        width: 100%;
        height: auto;
        flex-direction: row;
        justify-content: space-around;
        padding: 10px 0;
        position: relative;
      }

      .sidebar .brand {
        display: none;
      }

      .content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  <!-- ===== SIDEBAR ===== -->
  <div class="sidebar">
    <div class="brand">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6d/Volkswagen_logo_2019.svg" alt="Volkswagen Logo">
      <div>Volkswagen</div>
    </div>

    <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>

    <a href="{{ route('ordenes.index') }}" class="nav-link {{ request()->is('ordenes*') ? 'active' : '' }}">
      <i class="bi bi-journal-text"></i> Órdenes
    </a>

    <a href="{{ route('asesores.index') }}" class="nav-link {{ request()->is('asesores*') ? 'active' : '' }}">
      <i class="bi bi-people"></i> Asesores
    </a>

    <a href="#" class="nav-link">
      <i class="bi bi-gear"></i> Configuración
    </a>

    <div class="footer">© {{ date('Y') }} Volkswagen México</div>
  </div>

  <!-- ===== CONTENT AREA ===== -->
  <div class="content">
    {{-- Mensajes de confirmación --}}
    @if(session('ok'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        ✅ {{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Mensajes de error --}}
    @if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        ⚠️ {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    {{-- Contenido dinámico --}}
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Cerrar alertas automáticamente después de 5 segundos
    setTimeout(() => {
      const alerts = document.querySelectorAll('.alert');
      alerts.forEach(a => new bootstrap.Alert(a).close());
    }, 5000);
  </script>
</body>
</html>

