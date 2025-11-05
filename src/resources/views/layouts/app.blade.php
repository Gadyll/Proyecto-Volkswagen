<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VW – Checklist Órdenes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root{ --vw-blue:#001489; --vw-sky:#0099DA; --vw-grey:#B7B7B7; }
    .navbar { background: var(--vw-blue); }
    .navbar-brand, .nav-link { color:#fff !important; }
    .btn-vw { background: var(--vw-sky); color:#fff; border:none; }
    .card { border-radius: 14px; }
  </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('ordenes.index') }}">Volkswagen · Órdenes</a>
    <div class="ms-auto">
      <a href="{{ route('asesores.index') }}" class="nav-link d-inline">Asesores</a>
      <a href="{{ route('ordenes.index') }}" class="nav-link d-inline">Órdenes</a>
    </div>
  </div>
</nav>
<div class="container mb-5">
  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @yield('content')
</div>
</body>
</html>
