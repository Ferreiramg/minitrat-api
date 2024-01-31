@extends('layouts.app')
@section('content')
    <div>
        <h2>Solicitações</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>E-mail</th>
                        <th>Cidade/UF</th>
                        <th>Tipo Empreendimento</th>
                        <th>Fase Empreendimento</th>
                        <th>Enviado Em</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($solicitacoes as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nome }}</td>
                            <td>{{ $item->telefone }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->cidade }}/{{ $item->uf }}</td>
                            <td>{{ $item->TipoEmpreendimento }}</td>
                            <td>{{ $item->FaseEmpreendimento }}</td>
                            <td>{{ Helpers::ParaDateTimeBr($item->created_at) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection