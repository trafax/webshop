<script type="text/javascript">
$(function(){
   $("div#dropzone_{{ $name }}").dropzone({
        url: '{{ route('asset.upload') }}',
        acceptedFiles: 'image/*',
        dictDefaultMessage: '<p class="lead">Sleep uw bestanden hierin om deze te uploaden</p><p class="small fw-lighter">Deze afbeeldingen worden automatisch verkleind.</p>',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function() {
            this.on("sending", function(file, xhr, formData){
                formData.append('width', '{{ $width ?? NULL }}');
                formData.append('parent_id', '{{ $parent_id ?? NULL }}');
                formData.append('module', '{{ $module ?? NULL }}');
                formData.append('file_data', '{{ $file_data ?? NULL }}');
            });
            this.on("queuecomplete", function (file) {
                if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                    $("#{{ $name }}_assets").load("{{ url()->current() }} .{{ $name }}_assets", function(){
                        window.sort();
                    });
                    //$("#{{ $name }}").addClass('d-none');
                    this.removeAllFiles(true);
                }
            });
        }
    });
})

    delete_file = function(id)
    {
        $.get('/admin/asset/'+id+'/destroy', function(){
            $("#{{ $name }}_assets").load("{{ url()->current() }} .{{ $name }}_assets", function(){
                window.sort();
            });
        });
    }
    </script>

    <div class="dropzone mb-3" id="dropzone_{{ $name }}"></div>

    <div id="{{ $name }}_assets">
        @if ($assets->count() > 0)
            <div class="{{ $name }}_assets mb-3">
                <h2 class="h4 mt-4">Geuploade bestanden</h2>
                <hr>
                <div class="row row-cols-1 row-cols-md-3 g-4 sortable" data-action="{{ route('asset.sort') }}">
                    @foreach ($assets as $asset)
                        <div class="col" id="{{ $asset->id }}">
                            <div class="card mb-3 h-100">
                                <div class="row g-0">
                                    <div class="col">
                                        <img src="{{ asset('storage/'.$asset->file) }}" width="100%" height="200" style="object-fit: cover;">
                                        <div class="card-body">
                                            <p class="lead user-select-all"><small>{{ $asset->file }}</small></p>
                                            <p class="card-text">
                                                <small class="text-muted">Geupload op: {{ $asset->created_at->format('d-m-Y H:i') }}</small>
                                                <a href="javascript:;" onclick="delete_file({{ $asset->id }})" class="d-block">Verwijder afbeelding</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
