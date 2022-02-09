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

	$('.delete').bind('click', function () {
		var number = $(this).attr("data-number");
		var conf = confirm("Вы дейсвительно хотите удалить категорию под номером: " + number + "?");

		if (conf) {
			location.href = $(this).attr("data-link");
		} else {
			$('.result').html('');
			$('.result').html(showMsg('danger', 'Ошибка', 'Действие отменено.'));
		}
	});


	if (location.href.includes("delete")) {
		setTimeout(function () {
			$('.result').html('')
		}, 3000);	
	}


});