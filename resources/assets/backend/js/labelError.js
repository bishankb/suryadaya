$('.error-message').each(function() {
  $(this).closest('div').parent('div').addClass('has-error');
});
