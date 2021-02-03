@php
    $random_str = \Str::random(5);
    $asset = \App\Models\Asset::where('parent_id', $parent_id)->where('module', $module)->first();
@endphp

<div class="input-group mb-3">
    <input type="text" name="{{ $name }}" class="form-control" value="{{ $asset->file ?? '' }}" placeholder="Upload een bestand">
    <a href="javascript:;" data-modal="modal_{{ $random_str }}"><span class="input-group-text" id="basic-addon2"><i class="bi bi-upload"></i></span></a>
</div>

<div class="modal modal_{{ $random_str }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Upload een afbeelding</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="dropzone" id="dropzone_{{ $random_str }}"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
        </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('[data-modal]').on('click', function(){
            $('.'+$(this).data('modal')).modal('show');
        });

        $("div#dropzone_{{ $random_str }}").dropzone({
            url: "{{ route('asset.upload') }}",
            maxFiles: 1,
            acceptedFiles: 'image/*',
            dictDefaultMessage: 'Sleep uw bestand hierin of klik om er één te uploaden.',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on("sending", function(file, xhr, formData){
                    formData.append('single', '1');
                    formData.append('width', '{{ $width ?? NULL }}');
                    formData.append('parent_id', '{{ $parent_id ?? NULL  }}');
                    formData.append('module', '{{ $module ?? NULL }}');
                    formData.append('file_data', '{{ $file_data ?? NULL }}');
                });
                this.on("success", function(file, response){
                    $('input[name="{{ $name }}"]').val(response);
                    $('.modal').modal('hide');
                });
                this.on("queuecomplete", function (file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                        console.log(file);
                        this.removeAllFiles(true);
                    }
                });
            }
        });
    });
</script>
