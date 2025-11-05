@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Asesores</h3>
  <a href="{{ route('asesores.create') }}" class="btn btn-vw">Nuevo asesor</a>
</div>

<div class="card p-3">
  <table class="table table-hover m-0">
    <thead>
      <tr>
        <th>Nombre</th><th>Correo</th><th>Teléfono</th><th>Registro</th>
      </tr>
    </thead>
    <tbody>
      @foreach($asesores as $a)
        <tr>
          <td>{{ $a->nombre }} {{ $a->apellido }}</td>
          <td>{{ $a->correo }}</td>
          <td>{{ $a->telefono }}</td>
          <td>{{ $a->fecha_registro }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-3">{{ $asesores->links() }}</div>
</div>
@endsection
