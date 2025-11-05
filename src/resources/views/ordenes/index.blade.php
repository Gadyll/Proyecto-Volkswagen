@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Órdenes</h3>
  <a href="{{ route('ordenes.create') }}" class="btn btn-vw">Nueva orden</a>
</div>

<div class="card p-3">
  <table class="table table-hover m-0">
    <thead>
      <tr>
        <th># Orden</th><th>Chasis</th><th>Fecha</th><th>Asesor</th><th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($ordenes as $o)
        <tr>
          <td>{{ $o->numero_orden }}</td>
          <td>{{ $o->numero_chasis }}</td>
          <td>{{ $o->fecha }}</td>
          <td>{{ $o->asesor?->nombre }} {{ $o->asesor?->apellido }}</td>
          <td><a class="btn btn-sm btn-outline-secondary" href="{{ route('ordenes.show',$o) }}">Abrir</a></td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-3">{{ $ordenes->links() }}</div>
</div>
@endsection
