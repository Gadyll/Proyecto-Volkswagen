@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">📋 Órdenes registradas</h3>
  <a href="{{ route('ordenes.create') }}" class="btn btn-vw">➕ Nueva orden</a>
</div>

<div class="card p-4 mb-4">
  <form method="get" action="{{ route('ordenes.index') }}" class="row g-3 align-items-end">
    <div class="col-md-3">
      <label class="form-label">Buscar por asesor</label>
      <select name="asesor_id" class="form-select">
        <option value="">Todos</option>
        @foreach(\App\Models\Asesor::orderBy('nombre')->get() as $asesor)
          <option value="{{ $asesor->id }}" {{ request('asesor_id') == $asesor->id ? 'selected' : '' }}>
            {{ $asesor->nombre }} {{ $asesor->apellido }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="col-md-3">
      <label class="form-label">Desde</label>
      <input type="date" name="desde" value="{{ request('desde') }}" class="form-control">
    </div>
    <div class="col-md-3">
      <label class="form-label">Hasta</label>
      <input type="date" name="hasta" value="{{ request('hasta') }}" class="form-control">
    </div>

    <div class="col-md-3 d-flex gap-2">
      <button class="btn btn-vw w-100">🔍 Filtrar</button>
      <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary w-100">♻ Limpiar</a>
    </div>
  </form>
</div>

<div class="card p-3">
  <table class="table table-hover align-middle">
    <thead class="table-light">
      <tr>
        <th># Orden</th>
        <th>Chasis</th>
        <th>Fecha</th>
        <th>Asesor</th>
        <th>Progreso</th>
        <th class="text-end">Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($ordenes as $o)
        @php
          $total = $o->revisiones->count();
          $completadas = $o->revisiones->whereNotNull('revision_1')->count();
          $porcentaje = $total ? round(($completadas/$total)*100) : 0;
        @endphp
        <tr>
          <td>{{ $o->numero_orden }}</td>
          <td>{{ $o->numero_chasis }}</td>
          <td>{{ $o->fecha }}</td>
          <td>{{ $o->asesor?->nombre }} {{ $o->asesor?->apellido }}</td>
          <td style="min-width:140px;">
            <div class="progress" style="height: 8px;">
              <div class="progress-bar bg-success" role="progressbar" style="width: {{ $porcentaje }}%;"></div>
            </div>
            <small>{{ $porcentaje }}%</small>
          </td>
          <td class="text-end" style="white-space:nowrap;">
            <a href="{{ route('ordenes.show',$o) }}" class="btn btn-sm btn-outline-primary">Abrir</a>
            <a href="{{ route('ordenes.edit',$o) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
            <form action="{{ route('ordenes.destroy',$o) }}" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar esta orden? Se eliminarán sus revisiones.');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="text-center text-muted">No se encontraron resultados.</td></tr>
      @endforelse
    </tbody>
  </table>

  <div class="mt-3">{{ $ordenes->links() }}</div>
</div>
@endsection
