<?php

namespace App\Http\Controllers;

use App\Models\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    public function index()
    {
        $asesores = Asesor::latest()->paginate(10);
        return view('asesores.index', compact('asesores'));
    }

    public function create()
    {
        return view('asesores.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:120',
            'apellido' => 'nullable|string|max:120',
            'correo' => 'nullable|email',
            'telefono' => 'nullable|string|max:30',
            'fecha_registro' => 'nullable|date'
        ]);

        Asesor::create($data);
        return redirect()->route('asesores.index')->with('ok', 'Asesor creado.');
    }
}
