<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    @notifyCss
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Scripts -->

    <script src="{{ url('js/app.js') }}" defer></script>
    <link href="{{ url('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div id="app">
        <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ url('/') }}">

                {{ config('app.name', 'Laravel') }}

            </a>
            <button class="navbar-toggler position-absolute d-md-none collapsed" type="button"
                data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
           
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <a class="nav-link px-3" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </header>
        <div class="container-fluid">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item border-bottom">
                                <a class="nav-link d-flex {{ request()->is('home') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('home') }}">
                                    <span data-feather="home" class="align-text-bottom"></span>
                                    Home
                                </a>
                            </li>
                            <li class="nav-item border-bottom">
                                <a class="nav-link d-flex {{ request()->is('solicitacoes') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('solicitacoes') }}">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    Solicitações Enviadas
                                </a>
                            </li>
                            <li class="nav-item border-bottom">
                                <a class="nav-link d-flex {{ request()->is('produtos') ? 'active' : '' }}"
                                    aria-current="page" href="{{ route('produtos') }}">
                                    <span data-feather="file" class="align-text-bottom"></span>
                                    Produtos
                                </a>
                            </li>
                            <li class="nav-item border-bottom">
                                <a class="nav-link d-flex {{ request()->is('configuracoes') ? 'active' : '' }}"
                                    href="{{ route('config') }}">
                                    <span data-feather="settings" class="align-text-bottom"></span>
                                    Configurações
                                </a>
                            </li>
                            <li class="nav-item border-bottom">
                                <a class="nav-link d-flex {{ request()->is('usuarios') ? 'active' : '' }}"
                                    href="{{ route('usuarios') }}">
                                    <span data-feather="user" class="align-text-bottom"></span>
                                    Usuários
                                </a>
                            </li>
                        </ul>

                        {{--   <h6
                    class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
                    <span>Saved reports</span>
                    <a class="link-secondary" href="#" aria-label="Add a new report">
                        <span data-feather="plus-circle" class="align-text-bottom"></span>
                    </a>
                </h6> --}}

                    </div>
                </nav>

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
        integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous">
    </script>

    <script>
        function handlerFormErrors(erros, containerElement = null) {
            // Iterar sobre as chaves (nomes dos campos) no objeto de erros

            const container = containerElement || document;

            Object.keys(erros).forEach((campo) => {
                // Encontrar o elemento de input correspondente pelo atributo 'name'
                const inputElement = container.querySelector(`[name="${campo}"]`);

                console.log(inputElement);
                if (inputElement) {
                    // Limpar mensagens de erro existentes, se houver
                    const mensagemErroElement = inputElement.nextElementSibling;
                    if (mensagemErroElement) {
                        mensagemErroElement.remove();
                    }

                    const novaMensagemErro = document.createElement('span');

                    novaMensagemErro.classList.add('invalid-feedback');

                    novaMensagemErro.textContent = erros[campo][0];

                    inputElement.parentNode.insertBefore(novaMensagemErro, inputElement.nextSibling);

                    inputElement.setCustomValidity(erros[campo][0]);

                    // remove message if event key press
                    inputElement.addEventListener('keypress', function() {
                        inputElement.setCustomValidity("");
                    });

                    // remove message if event change
                    inputElement.addEventListener('change', function() {
                        inputElement.setCustomValidity("");
                    });
                }
            });
        }

        (() => {
            "use strict";
            feather.replace({
                "aria-hidden": "true"
            });

            // Obtém todos os formulários na página
            const forms = document.querySelectorAll('form');

            forms.forEach(function(form) {
                form.addEventListener('submit', function(event) {

                    const btn = event.target.querySelector('button[type="submit"]');

                    btn.disabled = true;
                    btn.innerHTML = 'Aguarde...';

                    this.submit();

                    event.preventDefault();
                });
            });

        })();
    </script>
    @notifyJs

    @yield('scripts')
</body>

</html>
