<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DocumentoController extends Controller
{
    public function index()
    {
        $documentos = Documento::with(['categoria', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($documentos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'arquivo' => 'required|file|max:2048',
            'descricao' => 'required|string|max:500',
            'horas_in' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $path = $request->file('arquivo')->store('documentos');

        $documento = Documento::create([
            'url' => $path,
            'descricao' => $request->descricao,
            'horas_in' => $request->horas_in,
            'status' => 'pendente',
            'categoria_id' => $request->categoria_id,
            'user_id' => $request->user_id,
        ]);

        return response()->json($documento, 201);
    }

    public function show($id)
    {
        $documento = Documento::with(['categoria', 'user'])->findOrFail($id);

        return response()->json($documento);
    }

    public function update(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);

        $validated = $request->validate([
            'status' => 'sometimes|in:pendente,aprovado,reprovado',
            'horas_out' => 'nullable|numeric|min:0',
            'comentario' => 'nullable|string|max:500',
        ]);

        $documento->update($validated);

        return response()->json($documento);
    }

    public function destroy($id)
    {
        $documento = Documento::findOrFail($id);

        Storage::delete($documento->url);

        $documento->delete();

        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $documento = Documento::withTrashed()->findOrFail($id);
        $documento->restore();

        return response()->json($documento);
    }

    public function download($id)
    {
        $documento = Documento::findOrFail($id);

        return Storage::download($documento->url);
    }

    public function aprovar($id)
    {
        $documento = Documento::findOrFail($id);

        $documento->update([
            'status' => 'aprovado',
            'horas_out' => $documento->horas_out ?? $documento->horas_in
        ]);

        return response()->json($documento);
    }

    public function reprovar($id)
    {
        $documento = Documento::findOrFail($id);

        $documento->update([
            'status' => 'reprovado',
            'horas_out' => 0
        ]);

        return response()->json($documento);
    }
}