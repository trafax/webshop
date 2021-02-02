@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-journals"></i> Categorieën</h1>
        <a href="{{ route('category.create') }}" class="btn btn-primary">Categorie toevoegen</a>
    </div>

    <hr>

    <div class="card">
        <div class="card-body">
            <div class="row d-flex">
                <div class="col-auto align-self-center border-end pe-3 me-1">
                    <div class="form-check ps-1">
                        <input class="form-check-input d-none" type="checkbox" value="" id="check-all" role="button">
                        <label class="form-check-label" for="check-all" role="button">
                            Selecteer alles
                        </label>
                    </div>
                </div>
                <div class="col-auto">
                    <select class="form-select selected">
                        <option>Met geselecteerde</option>
                        <option value="{{ route('category.delete') }}">Verwijder</option>
                    </select>
                </div>
                <div class="col-auto ms-auto">
                    <form method="post" action="{{ route('category.search') }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Zoeken">
                            <div class="input-group-text" role="button" onclick="$(this).closest('form').submit()"><i class="bi bi-search"></i></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <table class="table mb-0">
                <tbody class="sortable" data-action="{{ route('category.sort') }}">
                    @include ('admin.categories.partials.table', [
                        'categories' => $categories,
                        'depth' => 0
                    ])
                </tbody>
            </table>
        </div>
    </div>

@endsection
