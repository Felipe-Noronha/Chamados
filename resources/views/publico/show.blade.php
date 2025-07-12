@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="pb-4 mb-4 border-bottom">
        <h2>Detalhes do Chamado <span class="text-muted">#{{ $chamado->id }}</span></h2>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ $chamado->assunto }}</h5>
            
            @php
                $statusClass = match($chamado->status) {
                    'Aberto' => 'bg-warning text-dark',
                    'Em Andamento' => 'bg-info text-dark',
                    'Fechado' => 'bg-success',
                    default => 'bg-secondary',
                };
            @endphp
            <p><strong>Status:</strong> <span class="badge {{ $statusClass }}">{{ $chamado->status }}</span></p>
            
            <p class="card-text" style="white-space: pre-wrap;">{{ $chamado->mensagem }}</p>
            <hr>

            <div class="d-flex gap-2">
                <a href="{{ route('suporte.edit', ['chamado' => $chamado->id, 'token' => $chamado->secret_token]) }}" class="btn btn-warning">
                    Editar meu Chamado
                </a>

                <form action="{{ route('suporte.destroy', ['chamado' => $chamado->id, 'token' => $chamado->secret_token]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar este chamado? Esta ação não pode ser desfeita.')">
                        Apagar meu Chamado
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection