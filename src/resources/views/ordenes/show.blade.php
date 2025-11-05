@extends('layouts.app')

@section('content')
<h3 class="mb-3">Orden #{{ $orden->numero_orden }}</h3>

<div class="card p-3 mb-3">
  <div><strong>Asesor:</strong> {{ $orden->asesor?->nombre }} {{ $orden->asesor?->apellido }}</div>
  <div><strong>Chasis:</strong> {{ $orden->numero_chasis }} &nbsp; | &nbsp; <strong>Fecha:</strong> {{ $orden->fecha }}</div>
  @if($orden->observaciones)
    <div class="mt-1"><strong>Observaciones:</strong> {{ $orden->observaciones }}</div>
  @endif
</div>

<div class="card p-3">
  <table class="table table-bordered align-middle">
    <thead class="table-light">
      <tr>
        <th>Rubro</th>
        <th class="text-center">Fecha de revisión 1</th>
        <th class="text-center">Fecha de revisión 2</th>
        <th class="text-center">Fecha de revisión 3</th>
      </tr>
    </thead>
    <tbody>
      @foreach($orden->revisiones as $r)
        <tr>
          <td>{{ $r->rubro }}</td>
          <td class="text-center">{{ strtoupper($r->revision_1 ?? '-') }}</td>
          <td class="text-center">{{ strtoupper($r->revision_2 ?? '-') }}</td>
          <td class="text-center">{{ strtoupper($r->revision_3 ?? '-') }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endsection
