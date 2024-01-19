@extends('layouts.app')
@section('content')
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        onclick="Config.add(event)">Novo</button>
                </div>
            </div>
        </div>
        <h2>Configurações</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>PDF</th>
                        <th>Padrão Alto</th>
                        <th>Padrão Médio</th>
                        <th>Padrão Baixo</th>
                        <th>Funcionário Operação</th>
                        <th>Funcionário Admin</th>
                        <th>Refeição</th>
                        <th>Visita</th>
                        <th>Taxa de Infiltração</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($configuracao as $config)
                        <tr>
                            <td>{{ $config->id }}</td>
                            <td>
                                <a href="{{$config->pdf}}" target="_blank" rel="noopener noreferrer">Ver PDF</a>
                            </td>
                            <td>{{ $config->padrao_alto }}</td>
                            <td>{{ $config->padrao_medio }}</td>
                            <td>{{ $config->padrao_baixo }}</td>
                            <td>{{ $config->funcionario_operacao }}</td>
                            <td>{{ $config->funcionario_admin }}</td>
                            <td>{{ $config->refeicao }}</td>
                            <td>{{ $config->visita }}</td>
                            <td>{{ $config->taxa_infiltracao }}</td>
                            <td>
                                <a href="javascript:;" onclick="Config.edit(event)" data-src="{{ $config }}">
                                    <i data-feather="edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('config.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Produto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="pdf">PDF:</label>
                                <input type="file" class="form-control" id="pdf" name="file">
                            </div>

                            <div class="form-group">
                                <label for="padrao_alto">Padrão Alto:</label>
                                <input type="text" class="form-control" placeholder="l/un.dia" id="padrao_alto" required
                                    name="padrao_alto">
                            </div>

                            <div class="form-group">
                                <label for="padrao_medio">Padrão Médio:</label>
                                <input type="text" class="form-control" id="padrao_medio" placeholder="l/un.dia" required
                                    name="padrao_medio">
                            </div>

                            <div class="form-group">
                                <label for="padrao_baixo">Padrão Baixo:</label>
                                <input type="text" class="form-control" id="padrao_baixo" placeholder="l/un.dia" required
                                    name="padrao_baixo">
                            </div>

                            <div class="form-group">
                                <label for="funcionario_operacao">Funcionário Operação:</label>
                                <input type="number" step="1" class="form-control" id="funcionario_operacao" required
                                    name="funcionario_operacao">
                            </div>

                            <div class="form-group">
                                <label for="funcionario_admin">Funcionário Admin:</label>
                                <input type="number" step="1" class="form-control" id="funcionario_admin" required
                                    name="funcionario_admin">
                            </div>

                            <div class="form-group">
                                <label for="refeicao">Refeição:</label>
                                <input type="number" step="1" class="form-control" id="refeicao" required
                                    name="refeicao">
                            </div>

                            <div class="form-group">
                                <label for="visita">Visita:</label>
                                <input type="number" step="1" class="form-control" id="visita" required
                                    name="visita">
                            </div>

                            <div class="form-group">
                                <label for="taxa_infiltracao">Taxa de Infiltração:</label>
                                <input type="text" pattern="[0-9]+(\.[0-9]+)?" class="form-control" required id="taxa_infiltracao"
                                    name="taxa_infiltracao">
                            </div>
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var modal_produto = null;

        document.addEventListener('DOMContentLoaded', function() {
            modal_produto = new bootstrap.Modal('#create-modal', {
                keyboard: false,
                backdrop: 'static'
            });
        });

        const Config = {
            add(e) {
                e.preventDefault();

                modal_produto.show();

                const fomulario = document.querySelector('#create-modal form');

                const inputs = fomulario.querySelectorAll('input');

                inputs[1].value = '';
                inputs[2].value = '';
                inputs[3].value = '';
                inputs[4].value = '';
            },
            edit(event) {

                modal_produto.show();

                const data = JSON.parse(event.currentTarget.dataset.src);

                const fomulario = document.querySelector('#create-modal form');

                const inputs = fomulario.querySelectorAll('input');

                inputs[1].value = data.nome;
                inputs[2].value = data.vazao_diaria;
                inputs[3].value = data.vazao_horaria_media;
                inputs[4].value = data.id;
            },
        };
    </script>
@endsection
