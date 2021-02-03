@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-bag"></i> Producten</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Producten</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product bewerken</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">

            <form method="post" action="{{ route('product.update', $product) }}">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start">
                    <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Algemeen</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#categories" role="tab" aria-controls="v-pills-home" aria-selected="true">Categorieën</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#images" role="tab" aria-controls="v-pills-home" aria-selected="true">Afbeeldingen</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#filters" role="tab" aria-controls="v-pills-home" aria-selected="true">Filters</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#seo" role="tab" aria-controls="v-pills-home" aria-selected="true">Zoekmachine</a>
                    </div>
                    <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                        @include('admin.partials.errors')

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Titel</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $product->title) }}">
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Artikelnummer</label>
                                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-3">
                                        <label>Prijs</label>
                                        <div class="input-group">
                                            <div class="input-group-text">€</div>
                                            <input type="text" name="price" class="form-control" value="{{ old('price', $product->price) }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label>Omschrijving</label>
                                <textarea name="description" class="form-control editor" rows="10">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label class="form-label">Koppel aan categorie</label>
                                <select name="category_id[]" multiple class="form-select" size="10">
                                    @include('admin.products.partials.category', ['options' => \App\Models\Category::where('parent_id', 0)->orderBy('sort')->get(), 'depth' => 0, 'parent' => $product])
                                </select>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            @include('admin.dropzone.multiple', [
                                'name' => 'image',
                                'parent_id' => $product->id,
                                'module' => 'product',
                                'assets' => $product->assets
                            ])
                        </div>

                        <div class="tab-pane fade" id="filters" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            @include('admin.products.partials.filters')
                        </div>

                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Pagina titel</label>
                                <input type="text" name="seo[title]" class="form-control" value="{{ old('seo.title', ($product->seo['title'] ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <label>Pagina zoekwoorden</label>
                                <input type="text" name="seo[keywords]" class="form-control" value="{{ old('seo.keywords', ($product->seo['keywords'] ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <label>Pagina omschrijving</label>
                                <textarea name="seo[description]" class="form-control">{{ old('seo.description', ($product->seo['description'] ?? '')) }}</textarea>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Opslaan">
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
