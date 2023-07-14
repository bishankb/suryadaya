var alertToggleDefaultSettings = {
  title: "Are you sure?",
  type: "warning",
  showCancelButton: true,
  confirmButtonColor: "#DD6B55",
  confirmButtonText: "Yes",
  cancelButtonText: "No",
  closeOnConfirm: true,
  closeOnCancel: true
};
/**
 * Method to generate sweet alert for delete case
 *
 * @param _this this instance
 */
function swalDeletePopup(_this) {
  swal({
      title: _this.data('title') ? _this.data('title') : "Confirm Delete ?",
      text: _this.data('text') ? _this.data('text') : "Are you sure you want to delete this item ?",
      type: _this.data('type') ? _this.data('type') : "warning",
      showCancelButton: true,
      confirmButtonClass: _this.data('confirm_button_class') ? _this.data('confirm_button_class') : "btn-danger",
      confirmButtonText: _this.data('confirm_button_text') ? _this.data('confirm_button_text') : "Yes, delete it!",
      closeOnConfirm: false
    },
    function() {
      let form;
      if (form = _this.data('form')) {
        let formAction = $(_this).data('action');
        let element = $('#' + form);
        if (formAction) {
          element.attr('action', formAction);
        }
        element.submit();
      }
      _this.closest('form').submit();
    });
}

function sweetAlertDelete() {
  $(document).on('click', '.mt-sweetalert-delete', function(e) {
    e.preventDefault();
    swalDeletePopup($(this));
  });
}

/**
 * Method to generate sweet alert for delete case
 *
 * @param _this this instance
 */
function swalForceDeletePopup(_this) {
  swal({
      title: _this.data('title') ? _this.data('title') : "Confirm Force Delete ?",
      text: _this.data('text') ? _this.data('text') : "Are you sure you want to delete this item permanently? You cannot rollback this item",
      type: _this.data('type') ? _this.data('type') : "warning",
      showCancelButton: true,
      confirmButtonClass: _this.data('confirm_button_class') ? _this.data('confirm_button_class') : "btn-danger",
      confirmButtonText: _this.data('confirm_button_text') ? _this.data('confirm_button_text') : "Yes, delete it!",
      closeOnConfirm: false
    },
    function() {
      let form;
      if (form = _this.data('form')) {
        let formAction = $(_this).data('action');
        let element = $('#' + form);
        if (formAction) {
          element.attr('action', formAction);
        }
        element.submit();
      }
      _this.closest('form').submit();
    });
}

function sweetAlertForceDelete() {
  $(document).on('click', '.mt-sweetalert-force-delete', function(e) {
    e.preventDefault();
    swalForceDeletePopup($(this));
  });
}

/**
 * Method to generate sweet alert for delete case
 *
 * @param _this this instance
 */
function swalRestorePopup(_this) {
  swal({
      title: _this.data('title') ? _this.data('title') : "Confirm Restore ?",
      text: _this.data('text') ? _this.data('text') : "Are you sure you want to restore this item ?",
      type: _this.data('type') ? _this.data('type') : "warning",
      showCancelButton: true,
      confirmButtonClass: _this.data('confirm_button_class') ? _this.data('confirm_button_class') : "btn-danger",
      confirmButtonText: _this.data('confirm_button_text') ? _this.data('confirm_button_text') : "Yes, restore it!",
      closeOnConfirm: false
    },
    function() {
      let form;
      if (form = _this.data('form')) {
        let formAction = $(_this).data('action');
        let element = $('#' + form);
        if (formAction) {
          element.attr('action', formAction);
        }
        element.submit();
      }
      _this.closest('form').submit();
    });
}

function sweetAlertRestore() {
  $(document).on('click', '.mt-sweetalert-restore', function(e) {
    e.preventDefault();
    swalRestorePopup($(this));
  });
}

function dataExport() {
  $(document).on('click', 'button.btn-export', function(e) {
    e.preventDefault();
    let form;
    if (form = $(this).data('form')) {
      let formAction = $(this).data('action');
      $('#' + form).attr('action', formAction);
      $('#' + form).submit();
    }
  });
}

// Restrict numeric number to accept only numeric characters
var numericFields = $('form').find('.numeric').attr('oninput', "this.value=this.value.replace(/[^0-9]/g,'')");
//Slug Generator
function convertToSlug(value) {
  value = value.replace(/^\s+|\s+$/g, ''); // trim
  value = value.toLowerCase();

  // remove accents, swap ñ for n, etc
  var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
  var to = "aaaaaeeeeeiiiiooooouuuunc------";
  for (var i = 0, l = from.length; i < l; i++) {
    value = value.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }

  value = value.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes

  return value;
}

$(document).ready(function() {
    $('.alert').not('.alert-important').delay(3000).fadeOut(1000);
    sweetAlertDelete();
    sweetAlertForceDelete();
    sweetAlertRestore();
});

