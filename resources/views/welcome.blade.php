@extends('layouts.master')

@section('styles')
@endsection

@section('content')
    <div class="container-fluid my-3 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <button type="button" data-type="Consultor" class="type-query btn btn-primary">Por Consultor</button>
                            <button type="button" data-type="Cliente" class="type-query btn btn-primary">Por Cliente</button>
                        </div>
                        <hr>
                        <div class="row d-flex flex-row justify-content-start align-items-center">
                            <button type="button" class="btn btn-primary col-4 col-md-2 col-lg-1 ">Periodo</button>
                            <div class="col-md-3">
                                <input type="date" class="form-control" value="2007-05-01" name="periodoInicio" id="periodoInicio">
                            </div>
                            a
                            <div class="col-md-3">
                                <input type="date" class="form-control col-md-3" value="2007-08-01" name="periodoFin" id="periodoFin">
                            </div>

                        </div>
                        <hr>
                        <div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                                        <div>
                                            <h3 id="type_rel">Consultor</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="p-0 col-5 ">
                                                <select class="form-control" name="search_list" multiple>

                                                </select>
                                            </div>
                                            <div class="col-2 flex-buttons">
                                                <button type="button" id="move-to" class="btn btn-primary">></button>
                                                <button type="button" id="remove-to" class="btn btn-primary"><</button>
                                            </div>
                                            <div class="p-0 col-5 ">
                                                <select class="form-control" name="search" multiple>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="flex-buttons">
                                            <button type="button" id="relatorio" class="btn btn-primary my-1">Relatorio</button>
                                            <button type="button" id="grafico" class="btn btn-primary my-1">Grafico</button>
                                            <button type="button" id="pizza" class="btn btn-primary my-1">Pizza</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 tables d-none">
            <div class="col-md-12" >
                <div class="card px-2" id="content-table">
                </div>
            </div>
        </div>
        <div class="row mt-3 d-none" id="chartPie">
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <canvas id="myPieChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 d-none" id="chartBar">
            <div class="col-12">
                <div class="card">
                    <div class="row">
                        <div class="col-6 offset-3 bg-w">
                            <canvas id="myMixedChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const queryTypes = document.querySelectorAll('.type-query');
        const baseUrl = "{{ url('/') }}";
        let type = 'Consultor';
        const moveTo = document.getElementById('move-to');
        const removeTo = document.getElementById('remove-to');
        const relatorio = document.getElementById('relatorio');
        const grafico = document.getElementById('grafico');
        const pizza = document.getElementById('pizza');
        let pizzaChart,myPieChart, myMixedChart, MixedChart

    </script>
@endsection
