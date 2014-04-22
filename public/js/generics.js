/**
 * Show/hide password field based on checkbox state
 */

$(document).ready(function() {
	var checkboxEl = $('#checkbox-password');
	var passwordEl = $('input[name=password]');
	checkboxEl.change(function() {
		if($(this).is(':checked')) {
			passwordEl.attr('required',true).show();
		} else {
			passwordEl.attr('required',false).hide();
		}
	})
});