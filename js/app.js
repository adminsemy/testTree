//Вешаем обработку события click на все ссылки Reply и при клике
// перемещаем форму для комментариев под ссылку
$(document).ready(function(){
    $('.card-link').click(function(event){
        event.preventDefault();
        $(this).after($('.form-answer'));
        $('.form-answer').show();
    });
});

//Обрабатываем click на кнопку Submit формы для комментариев,
//отправляем AJAX запрос на сервер и "рисуем" комментарий в нужном месте
$(document).ready(function(){
    $('#addComment').click(function(event){
        event.preventDefault();
        //формирует ID поста
        let postId = $.url('?id');
        //формируер ID комментария
        let commentId = $('#formAnswer').parent().parent().attr('id');
        //Формируем сообщение
        let message = $('#answer').val();
        $.ajax({
            type: 'POST',
            url: 'addComment.php',
            data: {
                postId: postId,
                commentId: commentId,
                message: message
            },
            success: function (data) {
                data = JSON.parse(data);
                if('Insert error' !== data) {
                    commentId === '0' ? parentComment(data, message): childComment(data, message, commentId);
                } else {
                    console.log('Insert error');
                }
            },
        });
    });
});

//Отключаем кнопку отправки Submit комментария, если поле пустое
$(document).ready(function(){
    $('#addComment').prop( "disabled", true);
    $('#answer').on('keyup',function(){
        let text = $(this).val();

        if(text.length >= 1){
            $('#addComment').prop( "disabled", false);
        }else {
            $('#addComment').prop( "disabled", true);
        }
    });
});

//Вставляем комментарий в тело родительского комментария
function childComment(data, message, commentId) {
    $('#answer').val('');
    $('.form-answer').hide();
    let card = $('#tempCard').clone(true);
    card.attr('id', data);
    card.find('.card-text').text(message).html();
    card.appendTo($(`#${commentId}`).children().filter(':last-child'));
    card.show();
}

//Вставляем комментарий в body так как этот комментарий на пост
function parentComment(data, message) {
    $('#answer').val('');
    $('.form-answer').hide();
    let card = $('#tempCard').clone(true);
    card.attr('id', data);
    card.find('.card-text').text(message).html();
    console.log(data);
    card.appendTo('body');
    card.show();
}