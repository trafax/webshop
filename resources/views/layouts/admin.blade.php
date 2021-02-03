<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="{{ mix('js/admin.js') }}"></script>
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ mix('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="main-side-bar col-lg-2 col-md-4 col-sm-12 bg-primary h-100">
                <ul class="list-group list-group-flush mt-3">
                    <a class="list-group-item d-flex justify-content-between align-items-center" href="{{ route('dashboard') }}"><span><i class="bi bi-speedometer2"></i> Dashboard</span></a>
                </ul>

                <ul class="list-group list-group-flush mt-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center text-white"><span>Webshop</span></div>
                    <a class="list-group-item d-flex justify-content-between align-items-center" href="{{ route('category.index') }}"><span><i class="bi bi-journals"></i> Categorieën</span></a>
                    <a class="list-group-item d-flex justify-content-between align-items-center" href="{{ route('product.index') }}"><span><i class="bi bi-bag"></i> Producten</span></a>
                    <div class="w-100 list-group-item d-flex justify-content-between align-items-center p-0 ps-1">
                        <a class="btn btn-transparant d-block w-100 text-start" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i> Overige
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="{{ route('customer.index') }}"><i class="bi bi-people"></i> Klanten</a></li>
                            <li><a class="dropdown-item" href="{{ route('filter.index') }}"><i class="bi bi-filter-square"></i> Filters</a></li>
                            <li><a class="dropdown-item" href="{{ route('country.index') }}"><i class="bi bi-globe"></i> Landen</a></li>
                            <li><a class="dropdown-item" href="{{ route('import.index') }}"><i class="bi bi-upload"></i> Importeren</a></li>
                        </ul>
                    </div>
                </ul>

                <ul class="list-group list-group-flush mt-4">
                    <div class="list-group-item d-flex justify-content-between align-items-center text-white"><span>Instellingen</span></div>
                    <a class="list-group-item d-flex justify-content-between align-items-center" href="{{ route('language.index') }}"><span><i class="bi bi-flag"></i> Talen</span></a>
                </ul>
            </div>
            <div class="col main-col">
                <div class="container-fluid pt-3">
                    <div class="row border-bottom pb-3">
                        <div class="col-auto align-self-center ">
                            U bevindt zich in de taal:
                        </div>
                        <div class="col-2">
                            <select onchange="window.location.href = '/admin/language/'+ $(this).val() +'/set';" class="form-select">
                                @foreach (\App\Models\Language::orderBy('default', 'DESC')->orderBy('sort')->get() as $language)
                                    <option {{ Config::get('app.locale') == $language->iso ? 'selected' : '' }} value="{{ $language->id }}">{{ $language->title }} {{ $language->default == 1 ? '(standaard)' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="p-3 pt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
