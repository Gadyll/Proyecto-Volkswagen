@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="m-0">Orden #{{ $orden->numero_orden }}</h3>
  <a href="{{ route('ordenes.index') }}" class="btn btn-outline-secondary btn-sm">⬅ Regresar</a>
</div>

<div class="card p-4 mb-4">
  <h5 class="text-primary mb-3">📋 Información general</h5>
  <div class="row">
    <div class="col-md-4">
      <strong>Asesor:</strong><br>{{ $orden->asesor?->nombre }} {{ $orden->asesor?->apellido }}
    </div>
    <div class="col-md-4">
      <strong>Chasis:</strong><br>{{ $orden->numero_chasis ?? '—' }}
    </div>
    <div class="col-md-4">
      <strong>Fecha:</strong><br>{{ $orden->fecha ?? '—' }}
    </div>
  </div>
  @if($orden->observaciones)
    <div class="mt-3">
      <strong>Observaciones:</strong><br>{{ $orden->observaciones }}
    </div>
  @endif
</div>

<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="text-primary m-0">✅ Checklist de revisión</h5>
    <button type="submit" form="checklistForm" class="btn btn-vw">💾 Guardar cambios</button>
  </div>

  <form id="checklistForm" method="post" action="{{ route('ordenes.revisiones.update', $orden) }}">
    @csrf
    @method('PUT')

    <table class="table table-bordered align-middle table-hover">
      <thead class="table-light text-center">
        <tr>
          <th style="width:50%">Rubro</th>
          <th>Revisión 1</th>
          <th>Revisión 2</th>
          <th>Revisión 3</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orden->revisiones as $r)
          <tr>
            <td>{{ $r->rubro }}</td>
            @foreach(['revision_1','revision_2','revision_3'] as $rev)
              <td class="text-center">
                <select name="revision[{{ $r->id }}][{{ $rev }}]" class="form-select form-select-sm text-center">
                  <option value="" {{ $r->$rev === null ? 'selected' : '' }}>—</option>
                  <option value="si" {{ $r->$rev === 'si' ? 'selected' : '' }}>SI</option>
                  <option value="no" {{ $r->$rev === 'no' ? 'selected' : '' }}>NO</option>
                  <option value="na" {{ $r->$rev === 'na' ? 'selected' : '' }}>N/A</option>
                </select>
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </form>
</div>
@endsection
