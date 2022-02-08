$(window).ready(function () {
	$('.reason').css('display', 'none');
	$('.file').css('display', 'none');

	$('select[name="state"]').bind('change', function () {
		switch ($(this).val()) {
			case 'solved':
				$('.reason').css('display', 'none');
				$('.file').css('display', 'block');
			break;

			case 'declined':
				$('.reason').css('display', 'block');
				$('.file').css('display', 'none');
			break;

			default:
				alert('Что-то пошло не так.');
			break;
		}
	});
});