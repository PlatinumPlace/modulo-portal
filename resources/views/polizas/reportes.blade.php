@extends('portal')

@section('title', 'Generar reporte de emisiones')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@yield('title')</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if (session('alerta'))
                <div class="alert alert-danger text-center" role="alert">
                    <h6 class="alert-heading">
                        session("alerta")
                    </h6>
                </div>
            @endif

            <form enctype="multipart/form-data" method="POST" action="{{ route('reportes.store') }}">
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Desde</label>
                                <input type="date" class="form-control" name="desde" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Hasta</label>
                                <input type="date" class="form-control" name="hasta" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Plan</label>
                                <select name="plan" class="form-control">
                                    <option value="Auto" selected>Auto</option>
                                    <option value="Vida">Vida/desempleo</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Aseguradora</label>
                                <select name="aseguradoraid" class="form-control">
                                    <option value="" selected>Todas</option>
                                    @foreach ($planes as $plan)
                                        <option value="{{ $plan->getFieldValue('Vendor_Name')->getEntityId() }}">
                                            {{ $plan->getFieldValue('Vendor_Name')->getLookupLabel() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success" value="csv">Exportar a excel</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
