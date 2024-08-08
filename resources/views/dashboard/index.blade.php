@extends('layouts.app')

@section('content')
    <main class="content">
        <div class="container-fluid">
            <div class="header">
                <h1 class="header-title">
                    Salam, {{ auth()->user()->name }}!
                </h1>
            </div>

            <div class="row g-3">
                <!-- Chart Section -->
                <div class="col-12 mb-3">
                    <div class="card flex-fill w-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Başlıq</h5>
                        </div>
                        <div class="card-body d-flex w-100">
                            <div class="align-self-center chart chart-lg">
                                <canvas id="chartjs-dashboard-bar-alt"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </main>


@endsection

