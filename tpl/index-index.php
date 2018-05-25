<?php require_once 'header.php' ?>

    <div class="container">
        <div class="row">
            <h3>Вклады</h3>
        </div>
        <div class="row">
            <a href="/search/phone" class="btn btn-success">Найти по номеру телефона</a>
            <a href="/search/client_number" class="btn btn-success">Найти по номеру счета</a>
        </div>
        <!--<div class="row" style="margin-top: 20px;">
            <a href="/view/all" class="btn btn-primary">Просмотр всех вкладов</a>
        </div>-->
        <div class="row" style="margin-top: 20px;">
            <a href="/deposit/new" class="btn btn-lg btn-danger">Открыть новый вклад</a>
        </div>
    </div>

<?php require_once 'footer.php' ?>