<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Asesor;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrdenController extends Controller
{
    private array $rubros = [
        'FACTURA',
        'FORMATO DE INSPECCIÓN',
        'FORMATO DE CONTROLISTA',
        'PROTOCOLO',
        'AVISO DE ADICIONALES Y PRECIO',
        'COINCIDE EN PRECIO INICIAL VS EL PRECIO FINAL',
        'NOMBRE Y FIRMA DEL ASESOR Y EL TÉCNICO EN ORDEN DE REPARACIÓN',
        'RELOJ CHECADOR',
        'FIRMA DEL CONTROLISTA',
        'AVISO DE PRIVACIDAD',
        'CONTRATO DE ADHESIÓN FIRMADO',
        'ORDEN DE REPARACIÓN FIRMADA',
        'TICKET DE BATERÍA Y MENSAJE',
        'FORMATO DE HERRAMIENTAS',
        'FORMATO DE SALIDA DE REFACCIONES',
        'TARJETA VIAJERA LLENA',
        'POSICIONES DE TRABAJO',
        'COINCIDEN LAS UNIDADES DE TIEMPO',
        'PAGO POR JEFE DE TALLER',
        'CAMPAÑAS DE REVISIÓN',
        'PREFACTURA',
        'VALE DE SALIDA',
    ];

    public function index(Request $request)
    {
        $query = Orden::with('asesor', 'revisiones')->orderByDesc('fecha');

        if ($request->filled('asesor_id')) {
            $query->where('asesor_id', $request->asesor_id);
        }

        if ($request->filled('desde')) {
            $query->whereDate('fecha', '>=', $request->desde);
        }

        if ($request->filled('hasta')) {
            $query->whereDate('fecha', '<=', $request->hasta);
        }

        $ordenes = $query->paginate(10)->appends($request->query());
        return view('ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        $asesores = Asesor::orderBy('nombre')->get();
        return view('ordenes.create', compact('asesores'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero_orden'  => 'required|string|max:50|unique:ordenes,numero_orden',
            'numero_chasis' => 'nullable|string|max:100',
            'fecha'         => 'nullable|date',
            'observaciones' => 'nullable|string',
            'asesor_id'     => 'required|exists:asesores,id',
        ]);

        DB::transaction(function () use ($data) {
            $orden = Orden::create($data);
            foreach ($this->rubros as $rubro) {
                Revision::create([
                    'orden_id'   => $orden->id,
                    'rubro'      => $rubro,
                    'revision_1' => null,
                    'revision_2' => null,
                    'revision_3' => null,
                ]);
            }
        });

        return redirect()->route('ordenes.index')->with('ok', 'Orden creada con checklist correctamente.');
    }

    public function edit(Orden $orden)
    {
        $asesores = Asesor::orderBy('nombre')->get();
        return view('ordenes.edit', compact('orden', 'asesores'));
    }

    public function update(Request $request, Orden $orden)
    {
        $data = $request->validate([
            'numero_orden'  => ['required','string','max:50', Rule::unique('ordenes','numero_orden')->ignore($orden->id)],
            'numero_chasis' => 'nullable|string|max:100',
            'fecha'         => 'nullable|date',
            'observaciones' => 'nullable|string',
            'asesor_id'     => 'required|exists:asesores,id',
        ]);

        $orden->update($data);
        return redirect()->route('ordenes.index')->with('ok', 'Orden actualizada correctamente.');
    }

    public function destroy(Orden $orden)
    {
        DB::transaction(function () use ($orden) {
            $orden->revisiones()->delete();
            $orden->delete();
        });

        return redirect()->route('ordenes.index')->with('ok', 'Orden eliminada correctamente.');
    }

    public function show(Orden $orden)
    {
        $orden->load('asesor', 'revisiones');
        return view('ordenes.show', compact('orden'));
    }

    public function updateRevisiones(Request $request, Orden $orden)
    {
        $data = $request->input('revision', []);

        foreach ($data as $revisionId => $vals) {
            $r1 = $vals['revision_1'] ?? null;
            $r2 = $vals['revision_2'] ?? null;
            $r3 = $vals['revision_3'] ?? null;

            foreach ([$r1, $r2, $r3] as $v) {
                if ($v !== null && !in_array($v, ['si', 'no', 'na'], true)) {
                    return back()->withErrors('Valor inválido en checklist.')->withInput();
                }
            }

            $revision = $orden->revisiones()->where('id', $revisionId)->first();
            if ($revision) {
                $revision->update([
                    'revision_1' => $r1,
                    'revision_2' => $r2,
                    'revision_3' => $r3,
                ]);
            }
        }

        return redirect()->route('ordenes.show', $orden)->with('ok', 'Checklist actualizado correctamente.');
    }
}



