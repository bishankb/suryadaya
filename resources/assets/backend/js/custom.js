$(document).ready(function() {
    $('div.alert').not('.alert-important').delay(3000).fadeOut(1000);

    if (location.hash) {
        $("a[href='" + location.hash + "']").tab("show");
    }

    $(document.body).on("click", "a[data-toggle]", function(event) {
        location.hash = this.getAttribute("href");
    });

    $(window).on("popstate", function() {
        var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
        $("a[href='" + anchor + "']").tab("show");
    });

    $('.image-margin').hide();
    $('.cv-margin').hide();

    function readURLImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var fileType = input.files[0]["type"];
            reader.onload = function (e) {
                if(fileType == 'application/pdf') {
                    $('.selected-img').attr('src', '/images/pdf-logo.jpg');
                } else {                
                    $('.selected-img').attr('src', e.target.result);
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".input_image").change(function(event){
        var imageName = event.target.files[0].name;
        $("#image_filename").html(imageName);
        $('.selected-img').addClass('custom-thumbnail');
        $('.image-margin').show();
        $('.show-image').show();
        readURLImage(this);
    });

    function readURLCv(input) {
        if (input.files && input.files[0]) {
            $('.selected-cv').attr('src', '/images/pdf.jpg');
        }
    }

    $("#input_cv").change(function(event){
        var cvName = event.target.files[0].name;
        $("#cv_filename").html(cvName);
        $("#cv-href").removeAttr("href");
        $('.selected-cv').addClass('custom-thumbnail');
        $('.cv-margin').show();
        $('.show-cv').show();
        readURLCv(this);
    });

    $('.custom-select').select2({
        tags: false,
        placeholder: "Select an option",
        allowClear: true,
    });

    if (typeof (CKEDITOR) !== "undefined") {
        $('.custom-textarea').each(function() {
            CKEDITOR.replace(this.id, {
                removePlugins: 'sourcearea, forms, format, yyyy, anchor',
                extraPlugins : 'mathjax',
                mathJaxLib: '//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.0/MathJax.js?config=TeX-AMS_HTML',
                enterMode : CKEDITOR.ENTER_BR,
                customConfig: '/js/ckeditor.config.js'
            });
        });
    }

    $('.custom-date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
    });

    $('#custom-nepali-date').nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true,
        npdMonth: true,
        npdYear: true,
    });

    $('#from-nepali-date').nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true,
        npdMonth: true,
        npdYear: true,
    });

    $('#to-nepali-date').nepaliDatePicker({
        dateFormat: "%y-%m-%d",
        closeOnDateSelect: true,
        npdMonth: true,
        npdYear: true,
    });

    $('.custom-datetime').datetimepicker({
        format: 'yyyy-mm-dd hh:ii',
        autoclose: true,
    });

    $('.arrival-time').timepicker({
        defaultTime: '10:00 AM'
    });

    $('.departure-time').timepicker({
        defaultTime: '6:00 PM'        
    });

    $('.custom-time').timepicker({
        defaultTime: false
    });

    $('.year-picker').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years", 
        minViewMode: "years"
    });
});

function removeImage()
{
    if (confirm('Are you sure you want to delete the image?')) {
        $('#input_image').val('');
        $('.image-margin').hide();
    }
}

function removeFile()
{
    if (confirm('Are you sure you want to delete the file?')) {
        $('#input_cv').val('');
        $('.cv-margin').hide();
    }
}

$('.see-more').click(function(){
    if($(this).text() == 'See More »') {                
        $(this).text("See Less »");
    } else {
        $(this).text("See More »");
    }
});

