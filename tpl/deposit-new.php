<?php require_once 'header.php' ?>

<div class="container">
    <div class="row">
        <h1>Открыть вклад</h1>
    </div>
</div>
<div class="container" id="q-form">
    <div class="row">
        <h3>Вы уже являетесь клиентом этого банка?</h3>
        <div class="radio">
            <label>
                <input type="radio" id="is-client-yes" value="yes" name="is-client"/>
                Да
            </label>
        </div>
        <div class="radio">
            <label>
                <input type="radio" id="is-client-no" value="no" name="is-client"/>
                Нет
            </label>
        </div>

    </div>
</div>
<div class="container hidden" id="login-form">
    <div class="row">
        <h3>Вход</h3>
        <div class="form-group">
            <label for="ls-number" class="control-label">Номер лицевого счета</label>
            <input type="number" class="form-control" id="ls-number" placeholder="12345...">
        </div>
        <div class="form-group">
            <div>
                <button type="button" id="next-btn" class="btn btn-default">Далее</button>
            </div>
        </div>
    </div>
</div>
<div class="container hidden" id="reg-form">
    <div class="row">
        <h3>Регистрация</h3>
        <div class="form-group">
            <label for="Last_Name" class="control-label">Фамилия</label>
            <input type="text" class="form-control" id="Last_Name" placeholder="">
        </div>
        <div class="form-group">
            <label for="First_Name" class="control-label">Имя</label>
            <input type="text" class="form-control" id="First_Name" placeholder="">
        </div>
        <div class="form-group">
            <label for="Middle_Name" class="control-label">Отчество</label>
            <input type="text" class="form-control" id="Middle_Name" placeholder="">
        </div>
        <div class="form-group">
            <label for="gender" class="control-label">Пол</label>
            <select class="form-control" id="gender">
                <option value="0">Мужской</option>
                <option value="1">Женский</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Passport_Serie" class="control-label">Серия паспорта</label>
            <input type="text" class="form-control" id="Passport_Serie" placeholder="4 цифры">
        </div>
        <div class="form-group">
            <label for="Passport_Number" class="control-label">Номер паспорта</label>
            <input type="text" class="form-control" id="Passport_Number" placeholder="6 цифр">
        </div>
        <div class="form-group">
            <label for="Address" class="control-label">Домашний адрес</label>
            <input type="text" class="form-control" id="Address" placeholder="Индекс, город, улица, дом, квавртира">
        </div>
        <div class="form-group">
            <label for="Birthday" class="control-label">Дата рождения</label>
            <input type="date" class="form-control" id="Birthday" placeholder="">
        </div>
        <div class="form-group">
            <label for="Phone_Number" class="control-label">Номер телефона</label>
            <input type="text" class="form-control" id="Phone_Number" placeholder="89XXXXXXXXX">
        </div>
        <div class="form-group">
            <button class="btn btn-default" style="margin-top: 10px" onclick="registration()" id="reg-button">Далее</button>
        </div>
    </div>
</div>
<div class="container hidden" id="deposit-form">
    <div class="row">
        <h3>Открытие вклада</h3>
        <div class="form-group">
            <label for="ls-number-d" class="control-label">Номер лицевого счета</label>
            <input type="text" class="form-control" id="ls-number-d" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="fio" class="control-label">ФИО</label>
            <input type="text" class="form-control" id="fio" readonly="readonly">
        </div>
        <div class="form-group">
            <label for="sum" class="control-label">Сумма вклада (в рублях)</label>
            <input type="text" class="form-control" id="sum">
        </div>
        <div class="form-group">
            <label for="type" class="control-label">Тип вклада</label>
            <select class="form-control" id="type">

            </select>
        </div>
        <div class="alert alert-success" id="type-information">

        </div>
        <div class="form-group">
            <label for="date" class="control-label">Срок</label>
            <select class="form-control" id="date">
                <option value="1">1 год</option>
                <option value="2">2 года</option>
                <option value="3">3 года</option>
                <option value="4">4 года</option>
            </select>
        </div>
        <div class="form-group">
            <div>
                <button id="open-deposit" class="btn btn-default">Открыть</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php' ?>
