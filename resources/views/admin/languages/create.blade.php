@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-flag"></i> Talen</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('language.index') }}">Talen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Taal toevoegen</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">
            <div class="d-flex align-items-start">
                <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Algemeen</a>
                </div>
                <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                    @include('admin.partials.errors')

                    <form method="post" action="{{ route('language.store') }}">
                        @csrf
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Taal</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}">
                            </div>
                            <div class="mb-3">
                                <label>ISO code</label>
                                <input type="text" name="iso" class="form-control" value="{{ old('iso') }}">
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="default" value="1" type="checkbox" id="default" role="button">
                                    <label class="form-check-label" for="default" role="button">Standaard taal</label>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Opslaan">
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
