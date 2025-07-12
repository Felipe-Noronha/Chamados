<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChamadoController extends Controller
{
    public function index(Request $request)
{
    $valoresPermitidos = [5, 10, 25, 50];

    $porPagina = $request->query('por_pagina', 5);

    if (!in_array($porPagina, $valoresPermitidos)) {
        $porPagina = 5;
    }

    $chamados = Chamado::orderBy('created_at', 'desc')->paginate($porPagina);

    return view('publico.index', ['chamados' => $chamados]);
}

    public function create()
    {
        return view('publico.suporte-form');
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'nome_cliente' => 'required|string|max:255',
            'email_cliente' => 'required|email|max:255',
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        $dadosValidados['secret_token'] = Str::random(32);
        $chamado = Chamado::create($dadosValidados);

        return redirect()->route('suporte.show', [
            'chamado' => $chamado->id,
            'token' => $chamado->secret_token
        ])->with('success', 'Seu chamado foi criado!');
    }

    public function show(Chamado $chamado, $token)
    {
        if ($chamado->secret_token !== $token) {
            abort(404);
        }
        return view('publico.show', ['chamado' => $chamado]);
    }

    public function destroy(Chamado $chamado, $token)
    {
        if ($chamado->secret_token !== $token) {
            abort(404);
        }
        $chamado->delete();
        return redirect()->route('chamados.index')->with('success', 'Seu chamado foi removido com sucesso.');
    }

    public function edit(Chamado $chamado, $token)
    {
        if ($chamado->secret_token !== $token) {
            abort(404);
        }

        return view('publico.edit', ['chamado' => $chamado]);
    }

    public function update(Request $request, Chamado $chamado, $token)
    {
        if ($chamado->secret_token !== $token) {
            abort(404);
        }

        $dadosValidados = $request->validate([
            'assunto' => 'required|string|max:255',
            'mensagem' => 'required|string',
        ]);

        $chamado->update($dadosValidados);

        return redirect()->route('suporte.show', [
            'chamado' => $chamado->id,
            'token' => $chamado->secret_token
        ])->with('success', 'Seu chamado foi atualizado com sucesso!');
    }
}