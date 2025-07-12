@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h1>Abrir um Chamado de Suporte</h1>
                </div>
                <div class="card-body">
                    <p>Por favor, preencha o formulário abaixo e nossa equipe responderá o mais rápido possível.</p>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Ocorreram alguns erros:</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('suporte.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nome_cliente" class="form-label">Seu Nome:</label>
                            <input type="text" id="nome_cliente" name="nome_cliente" class="form-control" value="{{ old('nome_cliente') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email_cliente" class="form-label">Seu Email:</label>
                            <input type="email" id="email_cliente" name="email_cliente" class="form-control" value="{{ old('email_cliente') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="assunto" class="form-label">Assunto:</label>
                            <input type="text" id="assunto" name="assunto" class="form-control" value="{{ old('assunto') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="mensagem" class="form-label">Descreva o problema:</label>
                            <textarea id="mensagem" name="mensagem" rows="6" class="form-control" required>{{ old('mensagem') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Enviar Chamado</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection