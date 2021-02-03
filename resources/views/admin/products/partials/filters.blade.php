<div class="row row-cols-1 row-cols-md-2 g-4 mb-3">
    @foreach (\App\Models\Filter::orderBy('sort')->get() as $filter)

        @php
            $count = 0;
            $pivots = [];
            if (isset($product)) {
                $pivots = $product->filters()->where('filters.id', $filter->id)->get()->collect('pivot');
                $count = $pivots->count();
            }
        @endphp

        <script>
            var key_{{ $filter->id }} = {{ $count }};

            addFilterRow_{{ $filter->id }} = function(id){

                key = key_{{ $filter->id }}++;
                $('#{{ $filter->id }} .new-row:first').clone().html(function(i, html){
                    return html.replaceAll('[0]', '['+(key_{{ $filter->id }})+']');
                }).insertAfter(id + ' .new-row:last').find('input').val('');
            }
        </script>
        <div class="col" id="{{ $filter->id }}">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        {{ $filter->title }}
                        <a href="javascript:;" onclick="addFilterRow_{{ $filter->id }}('#{{ $filter->id }}')"><i class="bi bi-plus-square-dotted"></i></a>
                    </div>

                    @foreach($pivots as $pivot)
                        <div class="row mb-3">
                            <div class="col">
                                <input type="text" name="filter[{{ $filter->id }}][{{ $pivot->pivot->id }}][title]" value="{{ $pivot->pivot->title }}" class="form-control" placeholder="Titel">
                            </div>
                            @if ($filter->selectable == 1 || $filter->multiple == 1)
                                <div class="col-3">
                                    <input type="text" name="filter[{{ $filter->id }}][{{ $pivot->pivot->id }}][price]" value="{{ $pivot->pivot->price }}" class="form-control" placeholder="Vaste prijs">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="filter[{{ $filter->id }}][{{ $pivot->pivot->id }}][price_extra]" value="{{ $pivot->pivot->price_extra }}" class="form-control" placeholder="Meerprijs">
                                </div>
                            @endif
                            <div class="col-auto align-self-center">
                                <a href="javascript:;" onclick="$(this).closest('.row').css('display', 'none'); $(this).closest('.row').find('input').val('');"><i class="bi bi-dash-square-dotted"></i></a>
                            </div>
                        </div>
                    @endforeach

                    <div class="row new-row mb-3">
                        <div class="col">
                            <input type="text" name="new_filter[{{ $filter->id }}][{{ $count }}][title]" value="" class="form-control" placeholder="Titel">
                        </div>
                        @if ($filter->selectable == 1 || $filter->multiple == 1)
                            <div class="col-3">
                                <input type="text" name="new_filter[{{ $filter->id }}][{{ $count }}][price]" value="" class="form-control" placeholder="Vaste prijs">
                            </div>
                            <div class="col-3">
                                <input type="text" name="new_filter[{{ $filter->id }}][{{ $count }}][price_extra]" value="" class="form-control" placeholder="Meerprijs">
                            </div>
                        @endif
                        <div class="col-auto align-self-center">
                            <a href="javascript:;" onclick="$(this).closest('.row').remove();"><i class="bi bi-dash-square-dotted"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
</div>
