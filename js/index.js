let i = 0;
let titleval = ''; // Переменная для хранения title
let bool = 0; // 1 - отправка завершена
let iteration = 0;// стадия работы прогрессбара анимация
let id = 0; // идентификаторы таймеров

function change() {
    document.images['generation'].src = 'scripts/generation_of_pic.php?b=' + i;
    i++;
}

// Обновляем стили progressBar---
function CSSProgessBar(style) {
    if (style === 'WidthAuto') {
        jQuery(function ($) {
            $('#progressBar').css({
                'width': 'auto',
                'max-width': '300px',
                'height': 'auto',
                'padding': '30px 5px'
            });
        })
    }
    else {
        jQuery(function ($) {
            $('#progressBar').css({
                'width': '150px',
                'height': 'auto',
                'padding': '30px 5px'
            });
        })
    }
}

function SubmitDownAjax() {
    titleval = window.document.title;
    window.document.title = 'Отправка...';

    bool = 0;
    id = setInterval('doAnimation()', 400);
    document.getElementById('progressBar').innerHTML = 'отправка';
    CSSProgessBar();

    jQuery(function ($) {
        $('#progressBar').css({
            'visibility': 'visible',
            'opacity': '0'
        }).fadeTo(300, 1);
        $('#div').css({
            'visibility': 'visible',
            'opacity': '0'
        }).fadeTo(300, 0.5);
    })

    const name = document.getElementById('name').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const user = {
        'name': name, 'phone': phone, 'email': email, 'password': password,
    };
    const url = 'scripts/feedback.php';

    if (window.FormData === undefined) {
        alert('В вашем браузере FormData не поддерживается');
    } else {
        const formData = new FormData();

        $('input:file').each(function (index) {
            $.each($('input:file')[index].files, function (key, input) {
                formData.append('file[]', input);
            });
        });
        // Логирование файлов в formData. Для загрузки в Linux нужны права!!!
        for (const value of formData.values()) {
            console.log(value);
        }

        $.each(user, function (key, input) {
            formData.append(key, input);
        });

        $.ajax({
            type: 'POST',
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                SubmitDownAjax_callBack(data);
            }
        });
    }
}
function SubmitDownAjax_callBack(responseText) {
    bool = 1;
    window.document.title = titleval;

    document.getElementById('progressBar').innerHTML = responseText;
    CSSProgessBar('WidthAuto');
}

function addFileInput(el) {
    if (el.value) {
        const fileId = el.id;
        let r = /\d+/;
        let count = fileId.match(r);
        count++;
        let name = el.name.replace(/\d+/, '');
        const input = document.createElement('input');
        let br = document.createElement('br');
        $(input).attr({ 'name': name + count, 'type': 'file', 'multiple': 'multiple', 'id': name + count, 'onChange': 'addFileInput(this)' });
        el.after(br);
        br.after(input);
    }
}

function doAnimation() {
    if (bool === 1) {
        clearInterval(id);
        return;
    }
    if (iteration === 0) {
        document.getElementById('progressBar').innerHTML = '&nbsp;отправка.';
        iteration++;
        return;
    }
    if (iteration === 1) {
        document.getElementById('progressBar').innerHTML = '&nbsp;&nbsp;отправка..';
        iteration++;
        return;
    }
    if (iteration === 2) {
        document.getElementById('progressBar').innerHTML = '&nbsp;&nbsp;&nbsp;отправка...';
        iteration++;
        return;
    }
    if (iteration === 3) {
        document.getElementById('progressBar').innerHTML = 'отправка';
        iteration = 0;
    }
}

function focusDiv() {
    if (bool === 1) {
        jQuery(function ($) {
            $('#progressBar').fadeOut(300);
            $('#div').fadeOut(300);
        });
    }
}
function focusPbDouble() {
    if (bool === 1) {
        jQuery(function ($) {
            $('#progressBar').fadeOut(300);
            $('#div').fadeOut(300);
        });
    }
}
