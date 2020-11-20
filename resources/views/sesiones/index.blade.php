@extends('layouts.base')

@section('title', 'Iniciar Sesión')

@section('content')

    @if (session()->get('alerta'))
        <div class="alert alert-danger" role="alert">{{ session()->get('alerta') }}</div>
    @endif

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header text-center">
                                        <img src="{{ asset('img/logo.png') }}" width="150" height="150">
                                    </div>

                                    <div class="card-body">
                                        <form method="POST" action="{{ url('ingresar') }}">
                                            @csrf

                                            <div class="form-group">
                                                <label class="small mb-1">Email</label>
                                                <input class="form-control py-4" type="email" name="email" required />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1">Contraseña</label>
                                                <input class="form-control py-4" type="password" name="contrase_a"
                                                    required />
                                            </div>

                                            <button class="btn btn-success btn-user btn-block" type="submit">
                                                Ingresar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Grupo Nobe {{ date('Y') }}</div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>

@endsection
