$(document).ready(function() {
	$('.datefield').datepicker({
		dateFormat: "yy-mm-dd",
		changeMonth: true,
		changeYear: true,
		showButtonPanel: true,
		showWeek: true,
		numberOfMonths: 2,
		firstDay: 1
	});
});
