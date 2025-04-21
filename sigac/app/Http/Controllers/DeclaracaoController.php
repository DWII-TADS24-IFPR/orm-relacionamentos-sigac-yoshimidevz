<?php

namespace App\Http\Controllers;

use App\Models\Declaracao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeclaracaoController extends Controller
{
    public function index()
    {
        $declaracoes = Declaracao::with(['aluno', 'comprovante'])
            ->orderBy('data', 'desc')
            ->paginate(10);

        return response()->json($declaracoes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'aluno_id' => 'required|exists:alunos,id',
            'comprovante_id' => 'required|exists:comprovantes,id',
            'data' => 'required|date',
        ]);

        $validated['hash'] = bin2hex(random_bytes(32));

        $declaracao = DB::transaction(fn () => Declaracao::create($validated));

        return response()->json($declaracao, 201);
    }

    public function show($id)
    {
        $declaracao = Declaracao::with(['aluno', 'comprovante'])->findOrFail($id);

        return response()->json($declaracao);
    }

    public function update(Request $request, $id)
    {
        $declaracao = Declaracao::findOrFail($id);

        $validated = $request->validate([
            'data' => 'sometimes|date',
        ]);

        $declaracao->update($validated);

        return response()->json($declaracao);
    }

    public function destroy($id)
    {
        $declaracao = Declaracao::findOrFail($id);
        $declaracao->delete();

        return response()->json(null, 204);
    }

    public function restore($id)
    {
        $declaracao = Declaracao::withTrashed()->findOrFail($id);
        $declaracao->restore();

        return response()->json($declaracao);
    }

    public function search(Request $request)
    {
        $query = Declaracao::query();

        if ($request->has('hash')) {
            $query->where('hash', 'like', '%' . $request->hash . '%');
        }

        if ($request->has('aluno_id')) {
            $query->where('aluno_id', $request->aluno_id);
        }

        if ($request->has(['data_inicio', 'data_fim'])) {
            $query->whereBetween('data', [
                $request->data_inicio,
                $request->data_fim
            ]);
        }

        $resultados = $query->with(['aluno', 'comprovante'])->paginate(10);

        return response()->json($resultados);
    }
}