@extends('layouts.admin')

@section('content')

    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-journals"></i> Categorieën</h1>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categorieën</a></li>
            <li class="breadcrumb-item active" aria-current="page">Categorie bewerken</li>
        </ol>
    </nav>

    <hr>

    <div class="card mt-4">
        <div class="card-body">
            <form method="post" action="{{ route('category.update', $category) }}">
                @csrf
                @method('PUT')
                <div class="d-flex align-items-start">
                    <div class="nav flex-column col-2 nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" href="#home" role="tab" aria-controls="v-pills-home" aria-selected="true">Algemeen</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#media" role="tab" aria-controls="v-pills-home" aria-selected="true">Media</a>
                        <a class="nav-link" id="v-pills-home-tab" data-bs-toggle="pill" href="#seo" role="tab" aria-controls="v-pills-home" aria-selected="true">Zoekmachine</a>
                    </div>
                    <div class="tab-content col-9 ps-4" id="v-pills-tabContent">

                        @include('admin.partials.errors')

                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Titel</label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $category->title) }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Koppel categorie aan</label>
                                <select name="parent_id" class="form-select">
                                    <option value="0">Geen</option>
                                    @include ('admin.categories.partials.option', [
                                        'options' => \App\Models\Category::where('parent_id', 0)->where('id', '!=', $category->id)->orderBy('sort')->get(),
                                        'parent' => $category
                                    ])
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Omschrijving</label>
                                <textarea name="description" class="form-control editor" rows="10">{{ old('description', $category->description) }}</textarea>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label class="form-label">Afbeelding</label>
                                @include('admin.dropzone.modal_single_input', [
                                    'name' => 'image',
                                    'module' => 'category',
                                    'parent_id' => $category->id
                                ])
                            </div>
                        </div>

                        <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="mb-3">
                                <label>Pagina titel</label>
                                <input type="text" name="seo[title]" class="form-control" value="{{ old('seo.title', ($category->seo['title'] ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <label>Pagina zoekwoorden</label>
                                <input type="text" name="seo[keywords]" class="form-control" value="{{ old('seo.keywords', ($category->seo['keywords'] ?? '')) }}">
                            </div>
                            <div class="mb-3">
                                <label>Pagina omschrijving</label>
                                <textarea name="seo[description]" class="form-control">{{ old('seo.description', ($category->seo['description'] ?? '')) }}</textarea>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Opslaan">
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
