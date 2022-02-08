$(window).ready(function () {

    // Обработчик создания заявки
    $('button[data-type="register_thread"]').bind('click', function () {
        $('.result').html('');
        $('.result').fadeTo( "slow", 1);

        var data = new FormData();
        if ($('.input-file')[0].files[0] == undefined) {
            $('.result').append(showMsg('danger', 'Ошибка', 'Выберите изображение с проблемой'));
            return false;
        }

        var File = $('.input-file')[0].files[0];
        if (File.type != 'image/png' && File.type != 'image/jpeg' && File.type != 'image/jpg') {
            $('.result').append(showMsg('danger', 'Ошибка', 'Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)'));
            return false;
        }

        data.append('method', 'create_thread');
        data.append('title', $('input[name="local-title"]').val());
        data.append('description', $('textarea[name="local-description"]').val());
        data.append('category', $('select[name="local-category"]').val());
        data.append('problem', File);

        request(data);
        data.set("method", undefined);
        data.set("title", undefined);
        data.set("description", undefined);
        data.set("category", undefined);
        data.set("problem", undefined);
        $('.input-file').val(null);
    });

    $('.create-thread').bind('click', function () {
        $('.result').html('');
        $('.result').fadeTo( "slow", 1);
        $('.modal-content').css("display", "");
        $('.modal__btn').css("display", "");
    });

    // Отправка запроса
    function request (object) {
        $.ajax({
            url: "/app/request.php",
            type: "POST",
            cache: false,
            contentType: false,
            processData: false,
            data: object,
            dataType: 'json',
            success: function (result) {
                if (result.error) {
                    $('.input-trigger').html('Выбрать файл');
                    $('.result').append(showMsg('danger', 'Ошибка', result.message));
                }

                if (result.success) {
                    $('.modal-content').css("display", "none");
                    $('.modal__btn').css("display", "none");
                    $('.input-trigger').html('Выбрать файл');
                    $('.result').append(showMsg('success', 'Ошибка', result.message));
                }
            }
        });
    }

});