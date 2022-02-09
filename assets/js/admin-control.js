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

	$('.save-problem').bind('click', function (event) {
		event.preventDefault();

		var state = $('select[name="state"]').val();
		var params = new URLSearchParams(location.search);

		switch (state) {
			case 'solved':
				var obj = new FormData();

				if ($('.input-file')[0].files[0] == undefined) {
					$('.result').append(showMsg('danger', 'Ошибка', 'Выберите изображение с проблемой'));
					return false;
				}

				var File = $('.input-file')[0].files[0];
				if (File.type != 'image/png' && File.type != 'image/jpeg' && File.type != 'image/jpg') {
					$('.result').html('');
					$('.result').append(showMsg('danger', 'Ошибка', 'Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)'));
					return false;
				}

				obj.append('method', 'solved_problem');
				obj.append('id', params.get('id'));
				obj.append('file', File);

				sendPostWithFile(obj);

				obj.set('method', undefined);
				obj.set('id', undefined);
				obj.set('file', undefined);
				$('.input-file').val(null);
				$('.input-trigger').html('Выбрать файл');
			break;

			case 'declined':
				var object = {
					method: 'decline_problem',
					id: params.get("id"),
					reason: $('textarea[name="reason"]').val(),
					state: state
				};

				sendPost(object);
			break;

			default:
				alert('Выберите статус заявки');
			break;
		}
	});

	function sendPostWithFile (object) {
        $.ajax({
            url: "/app/admin.php",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
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

                if (result.save) {
                	setTimeout(function () {
                		location.href="/admin.php#applications";
                	}, 3000);
                }
            }
        });
    }

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

                if (result.save) {
                	setTimeout(function () {
                		location.href="/admin.php#applications";
                	}, 3000);
                }
            }
        });
    }
});