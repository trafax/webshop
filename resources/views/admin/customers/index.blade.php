@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-people"></i> Klanten</h1>
        <a href="{{ route('customer.create') }}" class="btn btn-primary">Klant toevoegen</a>
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
                        <option value="{{ route('customer.delete') }}">Verwijder</option>
                    </select>
                </div>
                <div class="col-auto ms-auto">
                    <form method="post" action="{{ route('customer.search') }}">
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
                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <th scope="row" width="50"><input type="checkbox" class="form-check-input check" name="id[]" value="{{ $customer->id }}"></th>
                            <td><a href="{{ route('customer.edit', $customer) }}">{{ $customer->firstname }} {{ $customer->insertion }} {{ $customer->lastname }}</a></td>
                            <td>{{ $customer->email }}</td>
                            <td class="text-end">
                                <div class="dropdown me-1">
                                    <button type="button" class="btn btn-transparant dropdown-toggle" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                                        <i class="bi bi-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                                        <li><a class="dropdown-item text-danger" data-delete="true" href="{{ route('customer.destroy', $customer) }}">Verwijder</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Er zijn nog geen resultaten.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
