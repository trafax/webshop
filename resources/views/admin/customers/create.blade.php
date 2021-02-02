@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-people"></i> Klanten</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('customer.index') }}">Klanten</a></li>
            <li class="breadcrumb-item active" aria-current="page">Klant toevoegen</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">
            <form method="post" action="{{ route('customer.store') }}">
                @csrf
                <div class="d-flex align-items-start">
                    <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Klantgegevens</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#invoice_address" role="tab" aria-controls="v-pills-settings" aria-selected="false">Factuur adres</a>
                        <a class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" href="#delivery_address" role="tab" aria-controls="v-pills-settings" aria-selected="false">Aflever adres</a>
                    </div>
                    <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                        @include('admin.partials.errors')

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label">Voornaam</label>
                                        <input type="text" name="firstname" class="form-control" value="{{ old('firstname') }}">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Tussenvoegsel</label>
                                        <input type="text" name="insertion" class="form-control" value="{{ old('insertion') }}">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Achternaam</label>
                                        <input type="text" name="lastname" class="form-control" value="{{ old('lastname') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefoonnummer</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                                    </div>
                                </div>
                            </div>
                            <h4>Account gegevens</h4>
                            <hr>
                            <div class="mb-3">
                                <label>E-mailadres</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                            </div>
                            <div class="mb-3">
                                <label>Wachtwoord</label>
                                @php $password = \Str::random(8) @endphp
                                <input type="password" name="password" class="form-control" value="{{ $password }}">
                                <div class="form-text">Wachtwoord: {{ $password }}</div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="invoice_address" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-label">Straatnaam</label>
                                        <input type="text" name="invoice_address[street]" class="form-control" value="{{ old('invoice_address.street') }}">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Huisnummer</label>
                                        <input type="text" name="invoice_address[nr]" class="form-control" value="{{ old('invoice_address.nr') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label">Postcode</label>
                                    <input type="text" name="invoice_address[zipcode]" class="form-control" value="{{ old('invoice_address.zipcode') }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">Woonplaats</label>
                                    <input type="text" name="invoice_address[city]" class="form-control" value="{{ old('invoice_address.city') }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">Land</label>
                                    <select name="invoice_address[country]" class="form-select">
                                        @foreach (\App\Models\Country::orderBy('sort')->get() as $country)
                                            <option value="{{ $country->id }}">{{ $country->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="delivery_address" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-8">
                                        <label class="form-label">Straatnaam</label>
                                        <input type="text" name="delivery_address[street]" class="form-control" value="{{ old('delivery_address.street') }}">
                                    </div>
                                    <div class="col">
                                        <label class="form-label">Huisnummer</label>
                                        <input type="text" name="delivery_address[nr]" class="form-control" value="{{ old('delivery_address.nr') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label">Postcode</label>
                                    <input type="text" name="delivery_address[zipcode]" class="form-control" value="{{ old('delivery_address.zipcode') }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">Woonplaats</label>
                                    <input type="text" name="delivery_address[city]" class="form-control" value="{{ old('delivery_address.city') }}">
                                </div>
                                <div class="col">
                                    <label class="form-label">Land</label>
                                    <select name="delivery_address[country]" class="form-select">
                                        @foreach (\App\Models\Country::orderBy('sort')->get() as $country)
                                            <option value="{{ $country->id }}">{{ $country->title }}</option>
                                        @endforeach
                                    </select>
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
