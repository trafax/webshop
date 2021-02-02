@foreach ($options as $option)
    <option {{ $parent->parent_id == $option->id ? 'selected' : '' }} value="{{ $option->id }}">{{ str_repeat(' - ', ($depth ?? 0)) . $option->title }}</option>
    @include('admin.categories.partials.option', ['options' => $option->children->where('id', '!=', $parent->id), 'depth' => ($depth ?? 0) +1, 'parent' => $parent])
@endforeach
