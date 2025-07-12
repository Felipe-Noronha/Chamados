@extends('layouts.app')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Bem-vindo ao nosso Canal de Suporte</h1>
            <p class="col-md-8 fs-4">Aqui você pode acompanhar os chamados recentes ou abrir um novo ticket para nossa equipe.</p>
            <a href="{{ route('suporte.create') }}" class="btn btn-dark btn-lg">Abrir Novo Chamado</a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Chamados Recentes</h2>

    <div class="d-flex justify-content-between align-items-center my-3">
        <form action="{{ route('chamados.index') }}" method="GET" class="d-flex align-items-center gap-2">
            <label for="por_pagina" class="form-label mb-0 text-nowrap">Mostrar:</label>
            <select name="por_pagina" id="por_pagina" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="5" {{ request('por_pagina', 5) == 5 ? 'selected' : '' }}>5</option>
                <option value="10" {{ request('por_pagina') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('por_pagina') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('por_pagina') == 50 ? 'selected' : '' }}>50</option>
            </select>
            <span class="text-muted">itens por página</span>
        </form>

        <div>
            {{ $chamados->withQueryString()->links() }}
        </div>
    </div>
    
    <div class="list-group">
        @forelse ($chamados as $chamado)
            <a href="{{ route('suporte.show', ['chamado' => $chamado->id, 'token' => $chamado->secret_token]) }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{ $chamado->assunto }}</h5>
                    <small class="text-body-secondary">{{ $chamado->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1 text-dark">Enviado por: {{ $chamado->nome_cliente }}</p>
                
                @php
                    $statusClass = match($chamado->status) {
                        'Aberto' => 'bg-warning text-dark',
                        'Em Andamento' => 'bg-info text-dark',
                        'Fechado' => 'bg-success',
                        default => 'bg-secondary',
                    };
                @endphp
                <small>Status: <span class="badge {{ $statusClass }}">{{ $chamado->status }}</span></small>
            </a>
        @empty
            <div class="list-group-item">
                <p class="text-muted mb-0">Nenhum chamado registrado ainda.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            Mostrando de {{ $chamados->firstItem() }} a {{ $chamados->lastItem() }} de {{ $chamados->total() }} resultados.
        </div>
        <div>
            {{ $chamados->withQueryString()->links() }}
        </div>
    </div>
@endsection