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

        sendPost(data);
        data.set("method", undefined);
        data.set("title", undefined);
        data.set("description", undefined);
        data.set("category", undefined);
        data.set("problem", undefined);
        $('.input-file').val(null);
    });

    $('.create-thread').bind('click', function () {
        $('input[name="local-title"]').val("");
        $('textarea[name="local-description"]').val("");

        $('.result').html('');
        $('.result').fadeTo( "slow", 1);
        $('.modal-content').css("display", "");
        $('.modal__btn').css("display", "");
    });

    if (location.pathname.includes('cabinet')) {
        sendGet({ method: 'problems_requests' });

        setInterval(() => {
            sendGet({ method: 'problems_requests' });
        }, 5000);
    }

    // Отправка запроса
    function sendPost (object) {
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
                   $('input[name="local-title"]').val("");
                   $('textarea[name="local-description"]').val("");

                    $('.modal-content').css("display", "none");
                    $('.modal__btn').css("display", "none");
                    $('.input-trigger').html('Выбрать файл');
                    $('.result').append(showMsg('success', 'Ошибка', result.message));
                }
            }
        });
    }

    function sendGet (object) {
        $.ajax({
            url: "/app/statistic.php",
            type: "GET",
            cache: false,
            data: object,
            dataType: 'json',
            success: function (result) {
                $('tbody').html('');

                if (result.error) {
                    if (result.table == null) {
                        $('table').css('display', 'none');
                        $('.response').html(showMsg('danger', 'Пусто', 'Вы не создавали ни одной заявки с проблемой воспользуйтесь кнопкой выше.'));
                    }
                }

                if (result.success) {
                    $('table').css('display', '');
                    $('.response').html('');
                    
                    result.table.forEach(value => {
                        $('tbody').prepend(raw(value.date, value.title, value.description, value.category_id, value.state));
                    });
                }
            }
        });
    }

    function showMsg (state, title, message) {
        return '<div class="ot-alert ot-alert--'+state+'">' +
        '<h3 class="ot-alert__title">'+title+'</h3>' +
        '<p>'+message+'</p>'
        '</div>'
    }

    function raw (date, title, description, category, state) {
        return '<tr>' +
            '<td>'+date+'</td>' +
            '<td>'+title+'</td>' +
            '<td>'+description+'</td>' +
            '<td>'+category+'</td>' +
            '<td>'+state+'</td>' +
        '</tr>';
    }


});