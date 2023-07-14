@extends('layouts.backend')

@section('title')
    Gallery
@endsection

@section('content')
    <div class="portlet-title">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <h1 class="page-title font-green sbold">
                    <i class="fa fa-television font-green"></i> Images
                    <small class="font-green sbold">Manage</small>
                    <h3><span style="font-size: 15px; color: red;">(Do not forget to press upload button after selecting a photo)</span></h3>
                </h1>
            </div>
        </div>
    </div>
    <div class="portlet-body">
        <div class="form-group">
            <div class="file-loading">
                <input id="multiple_input_image" type="file" name="gallery_image" multiple class="file" data-overwrite-initial="false" accept="image/*">
            </div>
        </div>
        <div class="portlet-footer">
            <a href="{{ route('galleries.index') }}" type="button" class="btn btn-info" style="margin-right: 5px;"><i class="fa fa-backward" aria-hidden="true"></i>
            Back</a>    
            <a href="{{ route('galleries.index') }}" class="btn btn-success">Finish</a>
        </div>
    </div>
@endsection

@section('backend-script')
    <script type="text/javascript">

        var galleryImagesUrls = {!! json_encode($galleryImagesUrls) !!};
        var galleryImagesInformations = {!! json_encode($galleryImagesInformations) !!};

        $("#multiple_input_image").fileinput({
            theme: 'fa',
            uploadUrl: "{{route('galleries.saveImages', $galleryId)}}",
            autoOrientImage: true,
            uploadAsync: false,
            uploadExtraData: function() {
                return {
                    _token: $("input[name='_token']").val(),
                };
            },
            allowedFileExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            overwriteInitial: false,
            maxFileSize:10240,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            },
            'showUpload': false,
            'showRemove': false,
            fileActionSettings: {
                showDrag: false
            },
            initialPreview:  galleryImagesUrls,
            initialPreviewConfig: galleryImagesInformations,
            initialPreviewAsData: true,
            deleteExtraData: {_token: $("[name='_token']").val()}
        })

        $("#multiple_input_image").on("filepredelete", function(jqXHR) {
            var abort = true;
            if (confirm("Are you sure you want to delete this image?")) {
                abort = false;
            }
            return abort;
        });
    </script>
@endsection
