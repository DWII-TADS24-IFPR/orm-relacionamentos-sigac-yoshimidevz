<?php

namespace App\Http\Controllers;

use App\Models\Nivel;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index()
    {
        $niveis = Nivel::orderBy('nome')->paginate(10);

        return response()->json($niveis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:100|unique:nivels'
        ]);

        $nivel = Nivel::create($request->all());

        return response()->json($nivel, 201);
    }

    public function show($id)
    {
        $nivel = Nivel::findOrFail($id);

        return response()->json($nivel);
    }

    public function update(Request $request, $id)
    {
        $nivel = Nivel::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:100|unique:nivels,nome,' . $id
        ]);

        $nivel->update($request->all());

        return response()->json($nivel);
    }

    public function destroy($id)
    {
        $nivel = Nivel::findOrFail($id);
        $nivel->delete();

        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $nivel = Nivel::withTrashed()->findOrFail($id);
        $nivel->restore();

        return response()->json($nivel);
    }
}