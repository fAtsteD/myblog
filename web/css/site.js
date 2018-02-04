// Data downloads through AJAX
$(function () {
	$(document).on('click', '.toggleButtonForModalWithAJAX', function () {
		if ($($(this).attr('href')).data('bs.modal').isShown) {
			$($(this).attr('href') + '-data').load($($(this).attr('href') + '-data').data('link-for-ajax'));
		} else {
			$(($(this).attr('href')).modal('show'));
			$($(this).attr('href') + '-data').load($($(this).attr('href') + '-data').data('link-for-ajax'));
		}
	});
});