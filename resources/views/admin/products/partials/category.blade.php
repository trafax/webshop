@foreach ($options as $option)
    @php $selected = isset($parent) && in_array($option->id, ($parent->categories()->pluck('category_id')->toArray() ?? [])) ? 'selected' : '' @endphp
    <option {{ $selected }} value="{{ $option->id }}">{{ str_repeat(' - ', ($depth ?? 0)) }} {{ $option->title }}</option>
    @include('admin.products.partials.category', ['options' => $option->children, 'depth' => ($depth ?? 0) +1, 'parent' => ($parent ?? NULL)])
@endforeach
