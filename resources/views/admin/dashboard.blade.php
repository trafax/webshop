@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-speedometer2"></i> Dashboard</h1>
    </div>

    <hr>

    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-header"><strong><i class="bi bi-cpu"></i> Versie</strong></div>
                <div class="card-body">
                    Versie: <strong>{{ \Config::get('app.version') }}</strong><br>
                    Voor het laatst bijgewerkt op {{ \Config::get('app.updated') }}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header"><strong><i class="bi bi-people"></i> Aantal klanten</strong></div>
                <div class="card-body">
                    Op dit moment zijn er {{ \App\Models\User::where('role', 'customer')->count() }} actieve klanten in de webshop.
                </div>
            </div>
        </div>
    </div>

@endsection
