$(window).ready(function () {
	var hash = location.hash;
	if ($("a[href='" + hash + "']").html() != undefined) {
		$('a').removeClass('active-cat');
		$("a[href='" + hash + "']").addClass('active-cat');
	} else {
		location.hash = "#category";
	}

	$('a[data-button="choose"]').bind('click', function () {
		if ($(this).is(".active-cat")) {
			return false;
		}

		$('a').removeClass('active-cat');
		$(this).addClass("active-cat");
	});
});