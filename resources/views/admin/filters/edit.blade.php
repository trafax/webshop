@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-filter-square"></i> Filters</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('filter.index') }}">Filters</a></li>
            <li class="breadcrumb-item active" aria-current="page">Filter bewerken</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">
            <form method="post" action="{{ route('filter.update', $filter) }}">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start">
                    <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Algemeen</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#options" role="tab" aria-controls="v-pills-home" aria-selected="true">Variaties</a>
                    </div>
                    <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                        @include('admin.partials.errors')

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Titel</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $filter->title) }}">
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="selectable" value="1" {{ $filter->selectable == 1 ? 'checked' : '' }} type="checkbox" id="selectable" role="button">
                                        <label class="form-check-label ms-2" for="selectable" role="button">Bevat kiesbare opties</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="required" value="1" {{ $filter->required == 1 ? 'checked' : '' }} type="checkbox" id="required" role="button">
                                        <label class="form-check-label ms-2" for="required" role="button">Verplichte keuze</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" name="multiple" value="1" {{ $filter->multiple == 1 ? 'checked' : '' }} type="checkbox" id="multiple" role="button">
                                        <label class="form-check-label ms-2" for="multiple" role="button">Meerdere keuzes</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade show" id="options" role="tabpanel" aria-labelledby="v-pills-home-tab">

                        </div>

                        <input type="submit" class="btn btn-primary" value="Opslaan">

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
