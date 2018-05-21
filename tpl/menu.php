<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Сбербанк</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Поиск вкладов <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/search/phone">По номеру телефона</a></li>
                        <li><a href="/search/client_number">По номеру лицевого счета</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Просмотр всех вкладов <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/view/all">Все</a></li>
                        <li><a href="/view/all?type=opened">Открытые</a></li>
                        <li><a href="/view/all?type=closed">Закрытые</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/deposit/new">Открыть новый вклад</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->

    </div>
</nav>