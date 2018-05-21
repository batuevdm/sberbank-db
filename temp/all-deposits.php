<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!--<link rel="stylesheet" href="/css/style.css">-->
    <title>Все вклады - Сбербанк</title>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

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

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-title">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modal-title">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-text">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/app.js"></script>
<script>allDeposits();</script>
</body>
</html>