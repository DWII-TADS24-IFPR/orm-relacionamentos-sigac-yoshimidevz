<?php

namespace App\Http\Controllers;

use App\Models\Comprovante;
use Illuminate\Http\Request;

class ComprovanterController extends Controller
{
 public function index()
 {
 $comprovantes = Comprovante::with(['aluno', 'categoria', 'user'])
 ->orderByDesc('created_at')
 ->paginate(10);

 return response()->json($comprovantes);
 }

 public function store(Request $request)
 {
 $request->validate([
 'horas' => 'required|numeric|min:0',
 'atividade' => 'required|string|max:255',
 'categoria_id' => 'required|exists:categories,id',
 'aluno_id' => 'required|exists:alunos,id',
 'user_id' => 'required|exists:users,id'
 ]);

 $comprovante = Comprovante::create($request->all());

 return response()->json($comprovante, 201);
 }

 public function show($id)
 {
 $comprovante = Comprovante::with(['aluno', 'categoria', 'user'])
 ->findOrFail($id);

 return response()->json($comprovante);
 }

 public function update(Request $request, $id)
 {
 $comprovante = Comprovante::findOrFail($id);

 $request->validate([
 'horas' => 'sometimes|```php
numeric|min:0',
 'atividade' => 'sometimes|string|max:255',
 'categoria_id' => 'sometimes|exists:categories,id'
 ]);

 $comprovante->update($request->all());

 return response()->json($comprovante);
 }

 public function destroy($id)
 {
 $comprovante = Comprovante::findOrFail($id);
 $comprovante->delete();

 return response()->json(null, 204);
 }

 public function restore($id)
 {
 $comprovante = Comprovante::withTrashed()->findOrFail($id);
 $comprovante->restore();

 return response()->json($comprovante);
 }

 public function porAluno($alunoId)
 {
 $comprovantes = Comprovante::where('aluno_id', $alunoId)
 ->with(['categoria'])
 ->orderByDesc('created_at')
 ->get();

 return response()->json($comprovantes);
 }
}