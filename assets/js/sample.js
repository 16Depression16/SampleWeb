function isCorrectFIO(fio) {
    if (!fio) {
        return false;
    }

    var fioA = fio.split(' ');

    if (fioA.length !== 3) {
        return false;
    }

    for (var i = 0; i < 3; i++) {
        if (/[^-А-Я\x27а-я]/.test(fioA[i])) {
            return false;
        }
    }

    return true;
}

function validateEmail(email) {
  var emailReg = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return emailReg.test( email );
}

function showMsg (state, title, message) {
    return '<div class="ot-alert ot-alert--'+state+'">' +
      '<h3 class="ot-alert__title">'+title+'</h3>' +
      '<p>'+message+'</p>'
    '</div>'
}


$(window).ready(function () {

    $('button[data-type="register"]').bind('click', function () {
        $('.result-register').html('');
        $('.result-register').fadeTo( "slow", 1);
        var fio = $('input[name="register_fio"]').val();
        var email = $('input[name="register_email"]').val();

        if (!isCorrectFIO(fio)) {
            $('.result-register').fadeTo( "slow" , 0.75).append(showMsg('danger', 'Ошибка!', 'Некорректно заполнено поле ФИО.'));
            return;
        }

        if (!validateEmail(email)) {
            $('.result-register').fadeTo( "slow" , 0.75).append(showMsg('danger', 'Ошибка!', 'Некорректно заполнено поле Email.'));
            return;
        }

        var object = {
            method: 'register',
            fio: fio,
            login: $('input[name="register_login"]').val(),
            email: email,
            password: $('input[name="register_password"]').val(),
            password_repeat: $('input[name="register_password_repeat"]').val(),
            has_accept: $('input[type="checkbox"]').is(":checked")
        };

        request(object);
    });

    $('button[data-type="login"]').bind('click', function () {
        $('.result-login').html('');
        $('.result-login').fadeTo( "slow", 1);

        var object = {
            method: 'login',
            login: $('input[name="login"]').val(),
            password: $('input[name="password"]').val()
        };

        request(object);
    });

    $('.tallback-send').bind('click', function (event) {
        event.preventDefault();
        var name = $('input[name="tallback-name"]').val();
        var email = $('input[name="tallback-email"]').val();
        var reason = $('textarea[name="tallback-reason"]').val();

        if (!isCorrectFIO(name)) {
            alert('Некорректно указано имя отправителя');
            return;
        }

        if (!validateEmail(email)) {
            alert('Некорректно указана почта');
            return;
        }

        alert(name + " ваше письмо с содержанием: \n" + reason + "\n отправлено успешно, ответ прийдёт на почту: " + email);
    });

    if (location.pathname == "/") {
        requestGet({ method: 'solved' });

        setInterval(() => {
            requestGet({ method: 'solved' });
        }, 5000);
    }

    // Отправка запроса на сервер - object наши данные для обработки
    function request (object) {
        $.ajax({
            url: "/app/request.php",
            type: "POST",
            cache: false,
            data: object,
            dataType: 'json',
            success: function (result) {
                if (result.error) {
                    $('.result-' + object.method).fadeTo( "slow" , 0.75).append(showMsg('danger', 'Ошибка!', result.message));
                }

                if (result.success) {
                    $('.result-' + object.method).fadeTo( "slow" , 0.75).append(showMsg('success', 'Успех!', result.message));

                    if (result.register) {
                        setTimeout(() => { location.href = "#goto"; }, 3000);
                    }

                    if (result.login) {
                        setTimeout(() => { location.href = "/cabinet.php"; }, 3000);
                    }
                }
            }
        });
    }

    function requestGet (object) {
        $.ajax({
            url: "/app/statistic.php",
            type: "GET",
            cache: false,
            data: object,
            dataType: 'json',
            success: function (result) {
                if (result.success) {
                    $('.counter-solved').html(result.count);
                }
            }
        });
    }

    $(".problem-image").hover(
        function() {
            $( this ).fadeIn( 500 );
            $(this).attr("src", $(this).attr("data-to"));
        }, 

        function() {
            $( this ).fadeIn( 500 );
           $(this).attr("src", $(this).attr("data-from"));
        }
    );

    // Работа с полем для фалйов вывод имени выбранного файла.
    $('.input-file').on('change', () => {
        var Photo = $('.input-file')[0].files[0];
        $('.input-trigger').html("Выбран файл " + Photo.name);
    });
});