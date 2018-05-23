<?php require_once 'header.php' ?>

<div class="container">
    <div class="row">
        <h1>Поиск вкладов</h1>
    </div>
    <div class="row">
        <label for="ls-number">Номер лицевого счета</label>
        <input type="text" class="form-control" placeholder="12345..." id="ls-number">
        <span class="help-block">Введите свой номер счета для просмотра Ваших вкладов</span>
    </div>
    <div class="row">
        <label for="ls-password">Пароль</label>
        <input type="password" class="form-control" placeholder="" id="ls-password">
    </div>
    <div class="row" style="margin-top: 20px;">
        <button class="btn btn-default" onclick="viewDepositsByLs()">Поиск</button>
    </div>
</div>
<div class="container" id="table-container" style="display: none;">
    <div class="row">
        <table class="table table-striped">
            <thead>
            <tr>
                <td>#</td>
                <td>Клиент</td>
                <td>Тип вклада</td>
                <td>Сумма вклада при открытии</td>
                <td>Сумма вклада на данный момент</td>
                <td>Дата открытия</td>
                <td>Дата закрытия</td>
            </tr>
            </thead>
            <tbody id="deposits">

            </tbody>
        </table>
    </div>
</div>

<?php if(isset($query['number'])): ?>
    <script>
        window.onload = function () {
            $("#ls-number").val('<?php echo $query['number']; ?>');
            //viewDepositsByLs();
            $("#ls-password").focus();
        };
    </script>
<?php endif; ?>

<?php require_once 'footer.php' ?>
