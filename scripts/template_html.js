function form_test(form) {
	form_test_reset();
	var test = 0;
	$(form).find('.integer').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_integer($(this));
		}
	});
	$(form).find('.numeric').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_numeric($(this));
		}
	});
	$(form).find('.valid_email').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_valid_email($(this));
		}
	});
	$(form).find('input[maxlength]').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_maxlength($(this));
		}
	});
	$(form).find('input[data-minlength]').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_minlength($(this));
		}
	});
	$(form).find('input[data-exactlength]').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_exactlength($(this));
		}
	});
	$(form).find('.required').each(function(index) {
		if($(this).is(':visible')) {
			test = test + form_test_required($(this));
		}
	});
	return test;
}
function form_test_integer(ref) {
	var test = 0;
	var id = $(this).attr('id');
	var name = $(this).attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	if(value != '' && value != parseInt(value)) {
		form_test_ko(ref);
		test++;
	}
	return test;
}
function form_test_numeric(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	if(value != '' && value != parseFloat(value)) {
		form_test_ko(ref);
		test++;
	}
	return test;
}
function form_test_valid_email(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	if(value != '') {
		var str = new String(value);
		if(!str.match('^[-_\.0-9a-zA-Z]{1,}@[-_\.0-9a-zA-Z]{1,}[\.][0-9a-zA-Z]{2,}$')) {
			form_test_ko(ref);
			test++;
			$(ref).parents('form').find('.message_ko').append('<li>' + lang['form_test_valid_email'] + '</li>');
		}
	}
	return test;
}
function form_test_maxlength(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	var maxlength = ref.attr('maxlength');
	if(value != '' && value.length > 0 && value.length > maxlength) {
		form_test_ko(ref);
		test++;
	}
	return test;
}
function form_test_minlength(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	var minlength = ref.attr('data-minlength');
	if(value != '' && value.length < minlength) {
		form_test_ko(ref);
		test++;
		$(ref).parents('form').find('.message_ko').append('<li>Please fill exact length (' + exactlength + ')</li>');
	}
	return test;
}
function form_test_exactlength(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	var exactlength = ref.attr('data-exactlength');
	if(value != '' && value.length != exactlength) {
		form_test_ko(ref);
		$(ref).parents('form').find('.message_ko').append('<li>' + $('label[for=' + id + ']').text() + ' ' + exactlength + ' caractères</li>');
		test++;
	}
	return test;
}
function form_test_required(ref) {
	var test = 0;
	var id = ref.attr('id');
	var name = ref.attr('name');
	var type = ref.attr('type');
	if(ref.val() == ref.data('placeholder')) {
		var value = '';
	} else {
		var value = ref.val();
	}
	if(type == 'radio') {
		if($('input[name=' + name + ']:checked').length == 0) {
			form_test_ko(ref);
			test++;
		}
	} else if(type == 'checkbox') {
		if(!ref.is(':checked')) {
			form_test_ko(ref);
			test++;
		}
	} else {
		if(value == '') {
			form_test_ko(ref);
			test++;
		}
	}
	if(test > 0) {
		$(ref).parents('form').find('.message_ko').html('<li>' + lang['form_test_required'] + '</li>');
	}
	return test;
}
function form_test_ko(ref) {
	var id = ref.attr('id');
	var name = ref.attr('name');
	$('#label-' + name).addClass('label_ko');
	$('label[for=' + id + ']').addClass('label_ko');
	ref.addClass('field_ko');
}
function form_test_reset() {
	$('form .message_ko').html('');
	$('div').removeClass('container_ko');
	$('label').removeClass('label_ko');
	$('input, select, textarea').removeClass('field_ko');
}
function debug(data) {
	if(debug_enabled) {
		if(window.console && console.debug) {
			console.debug(data);
		} else if(window.console && console.log) {
			console.log(data);
		}
	}
}
function set_positions() {
	_window_height = $(window).height();

	_offset = $('main > section').offset();
	_height = _window_height - _offset.top;
	$('main > section').css({ 'height': _height});

	if($('aside').length > 0) {
		_offset = $('aside').offset();
		_height = _window_height - _offset.top;
		$('aside').css({ 'height': _height});
	}
}
function toggle_sidebar() {
	if($('aside').is(':visible')) {
		$('aside').hide();
	} else {
		$('aside').show();
	}
	set_positions();
}
$(document).ready(function() {
	$(document).find('input[data-placeholder], textarea[data-placeholder]').each(function(index) {
		if($(this).val() == '') {
			$(this).addClass('placeholder');
			$(this).val($(this).data('placeholder'));
		}
	});
	$(document).on('focus', 'input[data-placeholder], textarea[data-placeholder]', function(event) {
		if($(this).val() == $(this).data('placeholder')) {
			$(this).removeClass('placeholder');
			$(this).val('');
		}
	});
	$(document).on('blur', 'input[data-placeholder], textarea[data-placeholder]', function(event) {
		if($(this).val() == '') {
			$(this).addClass('placeholder');
			$(this).val($(this).data('placeholder'));
		}
	});
	$(document).on('submit', 'form', function(event) {
		var ref = $(this);
		var form_test_result = form_test(ref);
		if(form_test_result == 0) {
		} else {
			//event.preventDefault();
		}
	});
	set_positions();
	$(window).bind('resize', function(event) {
		set_positions();
	});
	if($('aside').length == 0) {
		$('#toggle-sidebar').parent().remove();
	}
	$('#toggle-sidebar').bind('click', function(event) {
		event.preventDefault();
		toggle_sidebar();
	});
	$('.tabs a').bind('click', function(event) {
		event.preventDefault();
		$('.tabs a').removeClass('active');
		$(this).addClass('active');
		$('.tab').hide();
		$($(this).attr('href')).show();
	});
	$('li.expand a').bind('click', function(event) {
		event.preventDefault();
		var href = $(this).attr('href');
		$(href + '-expand').removeClass('enabled');
		$(href + '-collapse').addClass('enabled');
		$(href).show();
		$.cookie(href.substring(1), 'expand', { expires: 30, path: '/' });
	});
	$('li.collapse a').bind('click', function(event) {
		event.preventDefault();
		var href = $(this).attr('href');
		$(href + '-collapse').removeClass('enabled');
		$(href + '-expand').addClass('enabled');
		$(href).hide();
		$.cookie(href.substring(1), 'collapse', { expires: 30, path: '/' });
	});
});
