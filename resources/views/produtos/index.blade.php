@extends('layouts.app')
@section('content')
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        onclick="Produto.add(event)">Novo</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">Exportar</button>
                </div>
            </div>
        </div>
        <h2>Produtos</h2>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Vazão Diária (m³/dia)</th>
                        <th>Vazão Horária Média (m³/h)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produtos as $produto)
                        <tr>
                            <td>{{ $produto->id }}</td>
                            <td>{{ $produto->nome }}</td>
                            <td>{{ $produto->vazao_diaria }}</td>
                            <td>{{ $produto->vazao_horaria_media }}</td>
                            <td>
                                <a href="javascript:;" onclick="Produto.edit(event)" data-src="{{ $produto }}"><i
                                        data-feather="edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('produtos.store') }}" method="post"  >
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Produto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nome">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    placeholder="Digite o nome" maxlength="50" required>
                            </div>
                            <div class="form-group my-2">
                                <label for="vazaoDiaria">Vazão Diária (m³/dia)</label>
                                <input step="0.10" type="number" class="form-control" id="vazaoDiaria"
                                    name="vazao_diaria" placeholder="Digite a vazão diária" required>
                            </div>
                            <div class="form-group">
                                <label for="vazaoHorariaMedia">Vazão Horária Média (m³/h)</label>
                                <input step="0.10" type="number" class="form-control" id="vazaoHorariaMedia"
                                    name="vazao_horaria_media" placeholder="Digite a vazão horária média" required>
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

        const Produto = {
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
