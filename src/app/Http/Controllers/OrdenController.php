<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Asesor;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{
    // Rubros base del checklist (tu hoja)
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
        'CONTRATO DE ADHESION FIRMADO',
        'ORDEN DE REPARACIÓN FIRMADA',
        'TICKET DE BATERIA Y MENSAJE',
        'FORMATO DE HERRAMIENTAS',
        'FORMATO DE SALIDA DE REFACCIONES',
        'TARJETA VIAJERA LLENA',
        'POSICIONES DE TRABAJO',
        'COINCIDEN LAS UNIDADES DE TIEMPO',
        'PAGO POR JEFE DE TALLER',
        'CAMPAÑAS DE REVISION',
        'PREFACTURA',
        'VALE DE SALIDA',
    ];

    public function index()
    {
        $ordenes = Orden::with('asesor')->latest()->paginate(10);
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

        return redirect()->route('ordenes.index')->with('ok', 'Orden creada con checklist.');
    }

    public function show(Orden $orden)
    {
        $orden->load('asesor', 'revisiones');
        return view('ordenes.show', compact('orden'));
    }
}
