@extends('layouts.app')
@section('content')
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        onclick="Produto.add(event)">Novo</button>
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
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button onclick="Usuario.reset(event)" data-src="{{ $user }}"
                                    class="btn btn-outline-secondary btn-sm">Redefinir Senha</button>
                                <button onclick="Usuario.sendMail(event)" data-id="{{ $user->id }}"
                                    class="btn btn-outline-primary btn-sm">Enviar redefinição de senha</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="reset-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <form method="POST" action="{{ route('password.update') }}">
                    <input type="hidden" name="id">
                    <input type="hidden" name="email">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nova Senha</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="row mb-3 pt-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                    name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">
                                {{ __('Reset Password') }}
                            </button>
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
            modal_produto = new bootstrap.Modal('#reset-modal', {
                keyboard: false,
                backdrop: 'static'
            });
        });

        const Usuario = {
            sendMail(event) {},
            reset(event) {

                modal_produto.show();

                const data = JSON.parse(event.currentTarget.dataset.src);

                const fomulario = document.querySelector('#reset-modal form');

                const inputs = fomulario.querySelectorAll('input');

                inputs[0].value = data.id;
                inputs[1].value = data.email;
            },
        };
    </script>
@endsection
