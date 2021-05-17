jQuery(document).ready(function ($) {

    // Номер комментария в разделе блог
    $('.commentlist li').each(function (i) {
        $(this).find('div.commentNumber').text('#' + (i + 1));
    });
st
    // кнопка отправить комментарий
    $('#commentform').on('click', '#submit', function (e) {
        e.preventDefault();

        var comParent = $(this); // кнопка отправки комментария
        $('.wrap_result').css('color', 'green').text('Сохранение комментария').fadeIn(500, function () {
                var data = $('#commentform').serializeArray();
                // alert(data);
                $.ajax({
                    url: $('#commentform').attr('action'),
                    data: data,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type: 'POST',
                    datatype: 'JSON',

                    // Успешное завершение ajax-запроса
                    success: function(html) {
                        if(html.error) {
                            $('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>' + html.error.join('<br />'));
                            $('.wrap_result').delay(2000).fadeOut(500);
                        }
                        else if(html.success) {

                            // ответ на родительский комментарий
                            $('.wrap_result')
                                .append('<br /><strong>Сохранено!</strong>')
                                .delay(2000)
                                .fadeOut(500,function() {
                                    if(html.data.parent_id > 0) {
                                        comParent.parents('div#respond').prev().after('<ul class="children">' + html.comment + '</ul>');
                                    }
                                    else {
                                        if($.contains('#comments','ol.commentlist')) {
                                            $('ol.commentlist').append(html.comment);
                                        }
                                        else {

                                            $('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');

                                        }
                                    }

                                    $('#cancel-comment-reply-link').click();
                                })

                        }
                    },

                    // не удачный запрос
                    error:function() {
                        $('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>');
                        $('.wrap_result').delay(2000).fadeOut(500, function() {
                            $('#cancel-comment-reply-link').click();
                        });

                    }
                });
            });
    });
});
