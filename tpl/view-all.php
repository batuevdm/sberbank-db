<?php require_once 'header.php' ?>

    <div class="container">
        <div class="row">
            <h1>Все вклады</h1>
        </div>
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
                <!--<tr>-->
                <!--<td colspan="6">-->
                <!--<img src="/img/loader.gif" alt="Load..." />-->
                <!--</td>-->
                <!--</tr>-->
                </tbody>
            </table>
        </div>
    </div>

<?php require_once 'footer.php' ?>

<script>allDeposits()</script>
