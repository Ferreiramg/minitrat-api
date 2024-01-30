@extends('layouts.app')
@section('content')
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                        onclick="Usuario.add(event)">Novo</button>
                </div>
            </div>
        </div>
        <h2>Usuários</h2>
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
                                <button onclick="Usuario.sendMail(event)" data-email="{{ $user->email }}"
                                    class="btn btn-outline-primary btn-sm">Enviar redefinição de senha</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <form class="needs-validation" novalidate>
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Register') }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>

                                <span class="invalid-feedback" role="alert">
                                    <strong>Nome e requerido</strong>
                                </span>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                <span class="invalid-feedback" role="alert">
                                    <strong>Email e requerido</strong>
                                </span>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="pass" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="pass" type="password" class="form-control" name="password" required
                                    autocomplete="new-password">
                                <span class="invalid-feedback" role="alert">
                                    <strong>Informe uma senha valida</strong>
                                </span>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="button" onclick="Usuario.store(event)" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="modal fade" id="reset-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <form class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="id">
                    <input type="hidden" name="email">
                    <input type="hidden" name="token">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nova Senha</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="row mb-3 pt-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required
                                    autocomplete="new-password">
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
                            <button type="button" onclick="Usuario.restPass(event)" class="btn btn-primary">
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
        var modal_reset = null;
        var modal_novo = null;

        const url_forgt_pass = "{{ route('password.email') }}";
        const url_reset_pass = "{{ route('usuarios.reset.password') }}";
        const url_store = "{{ route('usuarios.store') }}";

        document.addEventListener('DOMContentLoaded', function() {
            modal_reset = new bootstrap.Modal('#reset-modal', {
                keyboard: false,
                backdrop: 'static'
            });
            modal_novo = new bootstrap.Modal('#create-modal', {
                keyboard: false,
                backdrop: 'static'
            });
        });

        const Usuario = {
            add(e) {
                e.preventDefault();

                modal_novo.show();

                const fomulario = document.querySelector('#create-modal form');

                const inputs = fomulario.querySelectorAll('input');
            },
            store(event) {
                const fomulario = event.currentTarget.closest('form');

                if (!fomulario.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();

                } else {
                    axios.post(url_store, new FormData(fomulario))
                        .then((response) => {
                            window.location.reload();
                        })
                        .catch((error) => {
                            handlerFormErrors(error.response.data.error || {}, fomulario);
                        })
                }

                fomulario.classList.add('was-validated');

            },
            restPass(event) {
                const fomulario = event.currentTarget.closest('form');

                if (!fomulario.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();

                } else {
                    axios.post(url_reset_pass, new FormData(fomulario))
                        .then((response) => {
                            alert(response.data?.status);
                            window.location.reload();
                        })
                        .catch((error) => {

                            console.log(error.response.data.error);

                            handlerFormErrors(error.response.data.error || {}, fomulario);
                        })
                }
                fomulario.classList.add('was-validated');

            },
            sendMail(event) {
                const {
                    email
                } = event.currentTarget.dataset;

                const btn = event.currentTarget;

                btn.disabled = true;

                btn.innerHTML = 'Enviando...';

                axios.post(url_forgt_pass, {
                    email
                }).then((response) => {
                    if (response.data?.status) {
                        btn.innerHTML = 'Enviar redefinição de senha';
                        alert(response.data?.status);
                        return null;
                    }
                    alert(response.data?.email);
                    return response;
                }).catch((error) => {
                    btn.disabled = false;
                }).finally(() => {
                    btn.innerHTML = 'Enviar redefinição de senha';
                });
            },
            reset(event) {

                modal_reset.show();

                const data = JSON.parse(event.currentTarget.dataset.src);

                const fomulario = document.querySelector('#reset-modal form');

                const inputs = fomulario.querySelectorAll('input');

                inputs[1].value = data.id;
                inputs[2].value = data.email;
                inputs[3].value = data.token;
            },
        };
    </script>
@endsection
