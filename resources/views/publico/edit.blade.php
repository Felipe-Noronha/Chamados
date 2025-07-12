@extends('layouts.app')

@section('content')
    <div class="pb-4 mb-4 border-bottom">
        <h2>Editar Chamado <span class="text-muted">#{{ $chamado->id }}</span></h2>
        <p>Altere as informações necessárias e clique em "Salvar Alterações".</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('suporte.update', ['chamado' => $chamado->id, 'token' => $chamado->secret_token]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto:</label>
                            <input type="text" id="assunto" name="assunto" class="form-control" value="{{ old('assunto', $chamado->assunto) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Descreva o problema:</label>
                            <textarea id="mensagem" name="mensagem" rows="6" class="form-control" required>{{ old('mensagem', $chamado->mensagem) }}</textarea>
                        </div>

                        <div class="d-flex gap-2">
                             <button type="submit" class="btn btn-warning">Salvar Alterações</button>
                            <a href="{{ route('suporte.show', ['chamado' => $chamado->id, 'token' => $chamado->secret_token]) }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection