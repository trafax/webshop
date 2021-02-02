@foreach ($categories as $category)
    <tr id="{{ $category->id }}">
        <th scope="row" width="50"><input type="checkbox" class="form-check-input check" name="id[]" value="{{ $category->id }}"></th>
        <td>
            <a href="{{ route('category.edit', $category) }}">{{ str_repeat(' - ', ($depth ?? 0)) }} {{ $category->title ? $category->title : ' ... ' }}</a>
            <div class="text-muted small">Aantal producten: {{ $category->products()->count() }}</div>
        </td>
        <td class="text-end">
            <div class="dropdown me-1">
                <button type="button" class="btn btn-transparant dropdown-toggle" id="dropdownMenuOffset" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="10,20">
                    <i class="bi bi-gear"></i>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                    <li><a class="dropdown-item text-danger" data-delete="true" href="{{ route('category.destroy', $category) }}">Verwijder</a></li>
                </ul>
            </div>
        </td>
    </tr>
    @if (! request()->get('search'))
        @include ('admin.categories.partials.table', [
            'categories' => $category->children,
            'depth' => ($depth+1),
        ])
    @endif
@endforeach
