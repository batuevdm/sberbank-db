function client(id) {
    var c = $.ajax({
        url: '/api/clients/get/' + id,
        async: false
    }).responseText;
    c = JSON.parse(c);
    return c['data'];
}

function login(number, password) {
    var c = $.ajax({
        url: '/api/clients/login',
        data: {
            Number: number,
            Password: password
        },
        async: false
    }).responseText;
    c = JSON.parse(c);
    console.log(c);
    return c;
}

function dType(id) {
    var c = $.ajax({
        url: '/api/deposits_types/get/' + id,
        async: false
    }).responseText;
    c = JSON.parse(c);
    return c['data'];
}

function getTypes() {
    var c = $.ajax({
        url: '/api/deposits_types/all',
        async: false
    }).responseText;
    c = JSON.parse(c);
    return c['data'];
}

function modalClient(id) {
    var c = client(id);
    var gender = c['gender'] == 0 ? 'мужской' : 'женский';
    $('#modal-title').text('Данные клиента');
    $('#modal-text')
        .text('')
        .append('Номер лицевого счета: ' + c['Number'] + '<br/>')
        .append('Фамилия: ' + c['Last_Name'] + '<br/>')
        .append('Имя: ' + c['First_Name'] + '<br/>')
        .append('Отчество: ' + c['Middle_Name'] + '<br/>')
        .append('Пол: ' + gender + '<br/>')
        .append('Серия паспорта: ' + c['Passport_Serie'] + '<br/>')
        .append('Номер паспорта: ' + c['Passport_Number'] + '<br/>')
        .append('Дата рождения: ' + c['Birthday'] + '<br/>')
        .append('Адрес регистрации: ' + c['Address'] + '<br/>')
        .append('Номер телефона: ' + c['Phone_Number'] + '<br/>');
    $('#modal').modal('show');
}

function modalType(id) {
    var t = dType(id);
    var isAdd = t['Is_Add'] == 0 ? 'Нет' : 'Да';
    var isSubstract = t['Is_Substract'] == 0 ? 'Нет' : 'Да';
    $('#modal-title').text(t['Name']);
    $('#modal-text')
        .text('')
        .append('Проценты в год: ' + t['Percents_In_Year'] + '%<br/>')
        .append('Минимальная сумма: ' + t['Min_Sum'] + ' ₽<br/>')
        .append('Максимальная сумма: ' + t['Max_Sum'] + ' ₽<br/>')
        .append('Возможность пополнения: ' + isAdd + '<br/>')
        .append('Возможность снятия: ' + isSubstract + '<br/>');
    $('#modal').modal('show');
}

function printDeposits(data) {
    $('#deposits').text('');
    for (var i = 0; i < data['data'].length; i++) {
        var c = client(data['data'][i]['Client_Number']);
        var t = dType(data['data'][i]['Type']);
        $('#deposits').append('<tr>' +
            '<td>' + data['data'][i]['ID'] + '</td>' +
            '<td><a href="javascript:void(0)" onclick="modalClient(' + c['Number'] + ')">' + c['Last_Name'] + ' ' + c['First_Name'] + ' ' + c['Middle_Name'] + '</a></td>' +
            '<td><a href="javascript:void(0)" onclick="modalType(' + t['ID'] + ')">' + t['Name'] + '</a></td>' +
            '<td>' + data['data'][i]['Sum'] + '</td>' +
            '<td>' + data['data'][i]['Res_Sum'] + '</td>' +
            '<td>' + data['data'][i]['Start_Date'] + '</td>' +
            '<td>' + data['data'][i]['End_Date'] + '</td>' +
            '</tr>');
    }
    if (data['data'].length == 0) {
        $('#deposits').text('Нет вкладов');
    }
}

function allDeposits() {
    $('#deposits').text('Загрузка...');
    $.ajax('/api/deposits/all')
        .done(function (data) {
            if (data['type'] == 'error') {
                alert(data['desc']);
                $('#deposits').text('');
                return;
            }
            printDeposits(data);
        })
        .fail(function () {
            alert('Ошибка получения данных');
        });
}

function viewDepositsByPhone() {
    $('#deposits').text('Загрузка...');
    var phone = $("#phone-number").val();
    var password = $("#ls-password").val();
    phone = phone.trim();
    if (phone == "" || phone == undefined || phone == null) {
        alert('Введите номер телефона!');
        $("#phone-number").focus();
        return;
    }
    $("#table-container").css('display', 'block');
    $.ajax('/api/deposits/phone/' + parseInt(phone) + '/' + encodeURIComponent(password))
        .done(function (data) {
            if (data['type'] == 'error') {
                alert(data['desc']);
                $('#deposits').text('');
                return;
            }
            printDeposits(data);
        })
        .fail(function () {
            alert('Ошибка получения данных');
        });
}

function viewDepositsByLs() {
    $('#deposits').text('Загрузка...');
    var ls = $("#ls-number").val();
    var password = $("#ls-password").val();
    ls = ls.trim();
    if (ls == "" || ls == undefined || ls == null) {
        alert('Введите номер счета!');
        $("#ls-number").focus();
        return;
    }
    $("#table-container").css('display', 'block');
    $.ajax('/api/deposits/ls/' + parseInt(ls) + '/' + encodeURIComponent(password))
        .done(function (data) {
            if (data['type'] == 'error') {
                alert(data['desc']);
                $('#deposits').text('');
                return;
            }
            printDeposits(data);
        })
        .fail(function () {
            alert('Ошибка получения данных');
        });
}

function registration() {
    $("#reg-button").addClass('disabled');
    var fn = $("#First_Name").val();
    var ln = $("#Last_Name").val();
    var mn = $("#Middle_Name").val();
    var g = $("#gender").val();
    var ps = $("#Passport_Serie").val();
    var pn = $("#Passport_Number").val();
    var a = $("#Address").val();
    var b = $("#Birthday").val();
    var p = $("#Phone_Number").val();
    var pw = $("#Password").val();

    $.ajax({
        url: '/api/clients/reg',
        data: {
            First_Name: fn,
            Last_Name: ln,
            Middle_Name: mn,
            gender: g,
            Passport_Serie: ps,
            Passport_Number: pn,
            Address: a,
            Birthday: b,
            Phone_Number: p,
            Password: pw
        },
        success: function (data) {
            if (data['type'] == 'error') {
                alert(data['desc']);
                $("#reg-button").removeClass('disabled');
                return;
            }

            var c = data['data'];

            var gender = c['gender'] == 0 ? 'мужской' : 'женский';

            $('#modal-title').text('Успешная регистрация');
            $('#modal-text')
                .html('Вы успешно зарегистрировались!<br/>Запомните номер Вашего лицевого счета, он понадобится для открытия новых вкладов<br><br/>')
                .append('Номер лицевого счета: ' + c['Number'] + '<br/>')
                .append('Фамилия: ' + c['Last_Name'] + '<br/>')
                .append('Имя: ' + c['First_Name'] + '<br/>')
                .append('Отчество: ' + c['Middle_Name'] + '<br/>')
                .append('Пол: ' + gender + '<br/>')
                .append('Серия паспорта: ' + c['Passport_Serie'] + '<br/>')
                .append('Номер паспорта: ' + c['Passport_Number'] + '<br/>')
                .append('Дата рождения: ' + c['Birthday'] + '<br/>')
                .append('Адрес регистрации: ' + c['Address'] + '<br/>')
                .append('Номер телефона: ' + c['Phone_Number'] + '<br/>');
            $('#modal').modal('show');
            $('#is-client-yes')
                .click()
                .click();
            $('#ls-number').val(c['Number']);
        },
        fail: function (data) {
            alert('Ошибка');
        }
    });
}

$('#is-client-no').on('click', function () {
    if ($('#is-client-no').prop('checked')) {
        $('#login-form').addClass('hidden');
        $('#reg-form').removeClass('hidden');
    }
});

$('#is-client-yes').on('click', function () {
    if ($('#is-client-yes').prop('checked')) {
        $('#reg-form').addClass('hidden');
        $('#login-form').removeClass('hidden');
    }
});

$("#next-btn").on('click', function () {
    var types = getTypes();
    var c = login($('#ls-number').val(), $('#ls-password').val());
    if (c['type'] == 'error') {
        alert(c['desc']);
        return;
    }
    c = c['data'];
    $("#fio").val(c['Last_Name'] + ' ' + c['First_Name'] + ' ' + c['Middle_Name']);
    $("#ls-password-d").val(c['Password']);
    $('#type').text('');
    for (var i = 0; i < types.length; i++) {
        $("#type")
            .append('<option value="' + types[i]['ID'] + '">' + types[i]['Name'] + '</option>');
    }
    $('#ls-number-d').val($('#ls-number').val());
    $('#login-form').addClass('hidden');
    $('#q-form').addClass('hidden');
    $('#deposit-form').removeClass('hidden');
    typeInformation(1);
});

$('#open-deposit').on('click', function () {
    $.ajax({
        url: '/api/deposits/open',
        data: {
            Client_Number: $("#ls-number-d").val(),
            Sum: $("#sum").val(),
            Type: $("#type").val(),
            Date: $("#date").val(),
            Password: $("#ls-password-d").val()
        },
        success: function (data) {
            if (data['type'] == 'error') {
                alert(data['desc']);
                $("#reg-button").removeClass('disabled');
                return;
            }

            console.log(data);

            alert('Вклад успешно открыт!\nСейчас произойдет перенаправление к списку Ваших вкладов');
            location.href = '/search/client_number?number=' + $("#ls-number-d").val();
        },
        fail: function (data) {
            alert('Ошибка');
        }
    });
});

function typeInformation(id) {
    var t = dType(id);
    var isAdd = t['Is_Add'] == 0 ? 'Нет' : 'Да';
    var isSubstract = t['Is_Substract'] == 0 ? 'Нет' : 'Да';
    $('#type-information')
        .text('')
        .append('Проценты в год: ' + t['Percents_In_Year'] + '%<br/>')
        .append('Минимальная сумма: ' + t['Min_Sum'] + ' ₽<br/>')
        .append('Максимальная сумма: ' + t['Max_Sum'] + ' ₽<br/>')
        .append('Возможность пополнения: ' + isAdd + '<br/>')
        .append('Возможность снятия: ' + isSubstract + '<br/>');
}

$('#type').on('change', function () {
    typeInformation($(this).val());
});

$(document).ready(function () {

});
