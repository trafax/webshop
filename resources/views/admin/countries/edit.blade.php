@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-globe"></i> Landen</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('country.index') }}">Landen</a></li>
            <li class="breadcrumb-item active" aria-current="page">Land bewerken</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">
            <form method="post" action="{{ route('country.update', $country) }}">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start">
                    <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Algemeen</a>
                    </div>
                    <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                        @include('admin.partials.errors')


                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Titel</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $country->title) }}">
                            </div>
                            <div class="mb-3">
                                <label>ISO code</label>
                                <input type="text" name="iso" class="form-control" value="{{ old('iso', $country->iso) }}">
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="eu" value="1" type="checkbox" id="eu" role="button" {{ $country->eu == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="eu" role="button">Behoort tot de EU</label>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Opslaan">

                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
