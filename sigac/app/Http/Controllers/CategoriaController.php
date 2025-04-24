<?php

namespace App\Http\Controllers;

use App\Models\Aluno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AlunoController extends Controller
{
 public function index(){
  $alunos = Aluno::with(['curso', 'turma'])
  ->orderBy('nome')
  ->paginate(10);

  return response()->json($alunos);
 }

 public function store(Request $request){
  $request->validate([
  'nome' => 'required|string|max:150',
  'cpf' => 'required|string|size:11|unique:alunos',
  'email' => 'required|email|unique:alunos',
  'senha' => 'required|string|min:6',
  'curso_id' => 'required|exists:cursos,id',
  'turma_id' => 'required|exists:turmas,id',
  'user_id' => 'required|exists:users,id'
  ]);

  $dados = $request->all();
  $dados['senha'] = Hash::make($request->senha);

  $aluno = Aluno::create($dados);

  return response()->json($aluno, 201);
 }

 public function show($id){
  $aluno = Aluno::with(['curso', 'turma', 'user'])
  ->findOrFail($id);

  return response()->json($aluno);
 }

 public function update(Request $request, $id){
  $aluno = Aluno::findOrFail($id);

  $request->validate([
  'nome' => 'sometimes|string|max:150',
  'cpf' => 'sometimes|string|size:11|unique:alunos,cpf,' . $aluno->id,
  'email' => 'sometimes|email|unique:alunos,email,' . $aluno->id,
  'senha' => 'sometimes|string|min:6',
  'curso_id' => 'sometimes|exists:cursos,id',
  'turma_id' => 'sometimes|exists:turmas,id'
  ]);

  $aluno->update($request->all());

  return response()->json($aluno);
 }

 public function destroy($id){
  $aluno = Aluno::findOrFail($id);
  $aluno->delete();

  return response()->json(null, 204);
 }

 public function restore($id){
  $aluno = Aluno::withTrashed()->findOrFail($id);
  $aluno->restore();

  return response()->json($aluno);
 }

 public function search(Request $request){
  $query = Aluno::query();

  if ($request->nome) {
  $query->where('nome', 'like', '%' . $request->nome . '%');
  }

  if ($request->cpf) {
  $query->where('cpf', $request->cpf);
  }

  if ($request->email) {
  $query->where('email', $request->email);
  }

  $alunos = $query->with(['curso', 'turma'])
  ->paginate(10);

  return response()->json($alunos);
 }
}