$(window).ready(function () {

    // Обработчик создания заявки

    // Отправка запроса
    function request (object) {
        $.ajax({
            url: "/app/request.php",
            type: "POST",
            cache: false,
            data: object,
            dataType: 'json',
            success: function (result) {
                console.log(result);
            }
        });
    }

});