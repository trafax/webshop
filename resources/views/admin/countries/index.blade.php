@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-globe"></i> Landen</h1>
        <a href="{{ route('country.create') }}" class="btn btn-primary">Land toevoegen</a>
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
                        <option value="{{ route('country.delete') }}">Verwijder</option>
                    </select>
                </div>
                <div class="col-auto ms-auto">
                    <form method="post" action="{{ route('country.search') }}">
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
                <tbody class="sortable" data-action="{{ route('country.sort') }}">
                    @forelse ($countries as $country)
                        <tr id="{{ $country->id }}">
                            <th scope="row" width="50"><input type="checkbox" class="form-check-input check" name="id[]" value="{{ $country->id }}"></th>
                            <td>
                                <a href="{{ route('country.edit', $country) }}">{{ $country->title }}</a>
                                <div class="text-muted">{{ $country->eu ? 'Europa / ' : '' }} {{ $country->iso }}</div>
                            </td>
                            <td class="text-end">
                                <div class="dropdown me-1">
                                    <button type="button" class="btn btn-transparant dropdown-toggle" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <li><a class="dropdown-item text-danger" data-delete="true" href="{{ route('country.destroy', $country) }}">Verwijder</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3">Er zijn nog geen resultaten.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
