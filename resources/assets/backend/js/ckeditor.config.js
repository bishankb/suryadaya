CKEDITOR.editorConfig = function( config ) {
   config.filebrowserBrowseUrl = '/plugins/ckeditor/ckfinder/ckfinder.html';
   config.filebrowserImageBrowseUrl = '/plugins/ckeditor/ckfinder/ckfinder.html?type=Images';
   config.filebrowserFlashBrowseUrl = '/plugins/ckeditor/ckfinder/ckfinder.html?type=Flash';
   config.filebrowserUploadUrl = '/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
   config.filebrowserImageUploadUrl = '/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
   config.filebrowserFlashUploadUrl = '/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};