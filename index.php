<?php
ob_start();
function __autoload($class_name)
{
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . strtolower($class_name) . '.class.php';
}

function _404() {
    header('', true, 404);
    //header("Location: /", true, 301);
    echo '404';
}

// BD Connection
$db = new DB(Config::$dbHost, Config::$dbUser, Config::$dbPass, Config::$dbBase);

$request = $_SERVER['REQUEST_URI'];

$queryParts = explode('?', $request);
$query = $queryParts[1];
$queryData = explode('&', $query);

$query = array();
foreach ($queryData as $item) {
    $item = explode('=', $item);
    $query[$item[0]] = $item[1];
}

$requestString = urldecode(trim($queryParts[0], '/'));
$request = explode('/', $requestString);

define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR);

$request[1] = $request[1] == '' ? 'index' : $request[1];
$file =  $request[1] . '.php';

switch ($request[0]) {
    case '':
        $title = 'Главная страница';
        if( file_exists( DIR . 'index-' . $file )) {
            require_once DIR . 'index-' . $file;
        }
        else {
            _404();
        }
        break;
    case 'view':
        $title = "Вклады";
        if( file_exists( DIR . 'view-' . $file )) {
            require_once DIR . 'view-' . $file;
        }
        else {
            _404();
        }
        break;

    case 'search':
        $title = "Поиск вкладов";
        if( file_exists( DIR . 'search-' .$file )) {
            require_once DIR . 'search-' . $file;
        }
        else {
            _404();
        }
        break;

    case 'deposit':
        $title = "Открытие вклада";
        if( file_exists( DIR . 'deposit-' .$file )) {
            require_once DIR . 'deposit-' . $file;
        }
        else {
            _404();
        }
        break;

    case 'client':
        $title = "Регистрация";
        if( file_exists( DIR . 'client-' .$file )) {
            require_once DIR . 'client-' . $file;
        }
        else {
            _404();
        }
        break;

    default:
        _404();
        break;
}
ob_get_contents();