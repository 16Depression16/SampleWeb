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

	$('.create-task').bind('click', function () {
		var object = {
			method: 'create_category',
			title: $('input[name="category_title"]').val()
		};

		sendPost(object);
	});

	function sendPost (object) {
        $.ajax({
            url: "/app/admin.php",
            type: "POST",
            cache: false,
            data: object,
            dataType: 'json',
            success: function (result) {
            	$('.result').html('');
                if (result.error) {
                    $('.result').append(showMsg('danger', 'Ошибка', result.message));
                }

                if (result.success || result.category_created) {
                	setTimeout(function () { location.href="/admin.php#category"; }, 3000);
                    $('.result').append(showMsg('success', 'Успех', result.message));
                }
            }
        });
    }
});