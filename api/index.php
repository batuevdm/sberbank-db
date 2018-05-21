<?php
ob_start();
function __autoload($class_name)
{
    require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . strtolower($class_name) . '.class.php';
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

$request = urldecode(trim($queryParts[0], '/'));
$request = explode('/', $request);

function _view($clients)
{
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>';
    echo "<table class=\"table table-hover\">";
    echo "<tr>";
    foreach ($clients[0] as $key => $value) {
        echo "<td>";
        echo $key;
        echo "</td>";
    }
    echo "</tr>";

    foreach ($clients as $client) {
        echo "<tr>";
        foreach ($client as $value) {
            echo "<td>";
            echo $value;
            echo "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
}

function addSum($arr)
{
    $db = new DB(Config::$dbHost, Config::$dbUser, Config::$dbPass, Config::$dbBase);
    $newArr = array();
    foreach ($arr as $item) {
        /*
         *  Ваш вклад в конце срока = (1 + П / 100)^N, где
         *  П – процент начисляемый за период, за который производится капитализация (месяц, квартал, год).
         *  N – количество таких периодов в общем сроке вклада.
         *  1-й месяц: 100000 х 0,12/12 = 1000 руб.
         *  2-й месяц: (100000+1000) х 0,12/12 = 1010 руб.
         *  3-й месяц: (100000+1000+1010) х 0,12/12 = 1020,1 руб.
         *  4-й месяц: (100000+1000+1010+1020,1) х 0,12/12 = 1030,3 руб.
         * */
        $res = $db->sql("SELECT `Percents_In_Year` FROM `deposits_types` WHERE `ID` = " . $item['Type']);
        $res = $res[0];

        $date = min(strtotime($item['End_Date']), time()) - strtotime($item['Start_Date']);

        $date /= 60 * 60 * 24 * 30;
        $date = floor($date);

        $sum = $item['Sum'];
        for ($i = 0; $i < $date; $i++) {
            $sum += $sum * ($res['Percents_In_Year'] / 100) / 12;
        }

        $val = '₽';
        $item['Res_Sum'] = number_format($sum, 2, ',', ' ') . ' ' . $val;
        $item['Sum'] = number_format($item['Sum'], 2, ',', ' ') . ' ' . $val;
        $newArr[] = $item;
    }
    return $newArr;
}

$data = array();

switch ($request[1]) {
    case 'clients':
        switch ($request[2]) {
            case 'all':
                $data['type'] = 'success';
                $data['data'] = $db->sql("SELECT * FROM `clients`");
                break;

            case 'get':
                $data['type'] = 'success';
                $data['data'] = $db->sql("SELECT * FROM `clients` WHERE `Number` = " . (int)$db->escape($request[3]));
                $data['data'] = $data['data'][0];
                break;

            case 'view':
                $clients = $db->sql("SELECT * FROM `clients`");
                _view($clients);
                exit;
                break;

            case 'reg':
                $q = array();
                foreach ($query as $key => $value) {
                    $q[$key] = $db->escape(htmlspecialchars(trim(urldecode($value))));
                }

                if (isset($q['First_Name']) &&
                    isset($q['Last_Name']) &&
                    isset($q['Middle_Name']) &&
                    isset($q['gender']) &&
                    isset($q['Passport_Serie']) &&
                    isset($q['Passport_Number']) &&
                    isset($q['Address']) &&
                    isset($q['Birthday']) &&
                    isset($q['Phone_Number'])
                ) {
                    if (strlen($q['First_Name']) > 1 && strlen($q['Last_Name']) > 1) {

                        if (strlen($q['Passport_Serie']) == 4 && strlen($q['Passport_Number']) == 6) {

                            if (strlen($q['Address']) > 5 && strlen($q['Birthday']) == 10) {

                                if (strlen($q['Phone_Number']) == 11) {

                                    $phone = $q['Phone_Number'];

                                    $res = $db->sql("SELECT COUNT(*) FROM `clients` WHERE `Phone_Number` = '$phone'");

                                    if ($res[0]['COUNT(*)'] < 1) {

                                        $serie = $q['Passport_Serie'];
                                        $number = $q['Passport_Number'];

                                        $res = $db->sql("SELECT COUNT(*) FROM `clients` WHERE `Passport_Serie` = $serie AND `Passport_Number` = $number");

                                        if ($res[0]['COUNT(*)'] < 1) {

                                            extract($q);
                                            $res = $db->sql("INSERT INTO `clients`(`First_Name`, `Last_Name`, `Middle_Name`, `gender`, `Passport_Serie`, `Passport_Number`, `Address`, `Birthday`, `Phone_Number`)
                                              VALUES  ('$First_Name', '$Last_Name', '$Middle_Name', $gender, $Passport_Serie, $Passport_Number, '$Address', '$Birthday', '$Phone_Number')");
                                            if ($res) {
                                                $data['type'] = 'success';
                                                $data['data'] = $db->sql("SELECT * FROM `clients` WHERE `Phone_Number` = '$Phone_Number'");
                                                $data['data'] = $data['data'][0];
                                            } else {
                                                $data['type'] = 'error';
                                                $data['desc'] = 'Ошибка записи в БД';
                                            }

                                        } else {
                                            $data['type'] = 'error';
                                            $data['desc'] = 'Клиент с такими паспортными данными уже зарегистрирован';
                                        }

                                    } else {
                                        $data['type'] = 'error';
                                        $data['desc'] = 'Клиент с таким номером телефона уже зарегистрирован';
                                    }

                                } else {
                                    $data['type'] = 'error';
                                    $data['desc'] = 'Номер телефона должен содержать 11 символов';
                                }

                            } else {
                                $data['type'] = 'error';
                                $data['desc'] = 'Введите адрес и дату рождения';
                            }

                        } else {
                            $data['type'] = 'error';
                            $data['desc'] = 'Неверно заполнены серия или номер паспорта';
                        }
                    } else {
                        $data['type'] = 'error';
                        $data['desc'] = 'Введите фамилию, имя';
                    }
                } else {
                    $data['type'] = 'error';
                    $data['desc'] = 'Empty Fields';
                }
                break;
        }
        break;

    case 'deposits':
        switch ($request[2]) {
            case 'all':
                $data['type'] = 'success';
                $data['data'] = addSum($db->sql("SELECT * FROM `clients_deposits`"));
                break;

            case 'get':
                $data['type'] = 'success';
                $data['data'] = addSum($db->sql("SELECT * FROM `clients_deposits` WHERE `ID` = " . (int)$db->escape($request[3])));
                $data['data'] = $data['data'][0];
                break;

            case 'phone':
                $data['type'] = 'success';
                $clientId = $db->sql("SELECT `Number` FROM `clients` WHERE `Phone_Number` = '" . $db->escape($request[3]) . "';");
                if ($clientId) {
                    $clientId = $clientId[0]['Number'];
                    $data['data'] = addSum($db->sql("SELECT * FROM `clients_deposits` WHERE `Client_Number` = " . $clientId . ";"));
                } else {
                    $data['type'] = 'error';
                    $data['desc'] = 'Клиента с таким номером телефона не существует';
                }
                break;

            case 'ls':
                $data['type'] = 'success';
                $clientId = $db->sql("SELECT `Number` FROM `clients` WHERE `Number` = '" . $db->escape($request[3]) . "';");
                if ($clientId) {
                    $clientId = (int)$db->escape($request[3]);
                    $data['data'] = addSum($db->sql("SELECT * FROM `clients_deposits` WHERE `Client_Number` = " . $clientId . ";"));
                } else {
                    $data['type'] = 'error';
                    $data['desc'] = 'Клиента с таким номером счета не существует';
                }
                break;

            case 'open':
                $q = array();
                foreach ($query as $key => $value) {
                    $q[$key] = $db->escape(htmlspecialchars(trim(urldecode($value))));
                }

                $sum = (float)$q['Sum'];

                if (isset($q['Client_Number']) &&
                    isset($q['Sum']) &&
                    isset($q['Type']) &&
                    isset($q['Date'])
                ) {
                    $type = $db->sql("SELECT * FROM `deposits_types` WHERE `id` = " . $q['Type']);
                    if ($type) {
                        $type = $type[0];

                        if ($sum >= $type['Min_Sum'] && $sum <= $type['Max_Sum']) {
                            if (in_array($q['Date'], [1, 2, 3, 4])) {

                                $startDate = time();
                                $endDate = $startDate + $q['Date'] * 12 * 30 * 24 * 60 * 60;
                                $startDate = date('Y-m-d H:i:s', $startDate);
                                $endDate = date('Y-m-d H:i:s', $endDate);

                                $sql = "INSERT INTO `clients_deposits` (`Client_Number`, `Type`, `Start_Date`, `End_Date`, `Sum`)
                                  VALUES ({$q['Client_Number']}, {$q['Type']}, '$startDate', '$endDate', {$sum})";

                                //var_dump($sql);

                                $res = $db->sql($sql);
                                if ($res) {
                                    $data['type'] = 'success';
                                } else {
                                    $data['type'] = 'error';
                                    $data['desc'] = 'Ошибка записи в БД';
                                }


                            } else {
                                $data['type'] = 'error';
                                $data['desc'] = 'Недопустимый срок';
                            }
                        } else {
                            $data['type'] = 'error';
                            $data['desc'] = 'Недопустимая сумма для этого типа вклада';
                        }
                    } else {
                        $data['type'] = 'error';
                        $data['desc'] = 'Type not found';
                    }
                } else {
                    $data['type'] = 'error';
                    $data['desc'] = 'Empty Fields';
                }

                break;

            case 'view':
                $clients = $db->sql("SELECT * FROM `clients_deposits`");
                _view($clients);
                exit;
        }
        break;

    case 'deposits_types':
        switch ($request[2]) {
            case 'all':
                $data['type'] = 'success';
                $data['data'] = $db->sql("SELECT * FROM `deposits_types`");
                break;

            case 'get':
                $data['type'] = 'success';
                $data['data'] = $db->sql("SELECT * FROM `deposits_types` WHERE `ID` = " . (int)$db->escape($request[3]));
                $data['data'] = $data['data'][0];
                break;

            case 'view':
                $clients = $db->sql("SELECT * FROM `deposits_types`");
                _view($clients);
                exit;
        }
        break;

    default:
        $data['type'] = 'error';
        $data['desc'] = 'Bad Request';
}

header('Content-type: application/json');
echo json_encode($data);
ob_get_contents();