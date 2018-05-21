<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'sberbank');
if($mysqli->connect_error)
    return;

for($i = 0; $i < 50; $i++) {
    echo "<br/>";
    $client = rand(1, 15);
    $type = rand(1, 4);
    $start_date = rand(1325376000, 1525132800);
    $diaps = [1*365*24*60*60, 2*365*24*60*60, 3*365*24*60*60, 4*365*24*60*60];
    $end_date = $start_date + $diaps[array_rand($diaps)];

    $start_date = date("Y-m-d H:i:s", $start_date);
    $end_date = date("Y-m-d H:i:s", $end_date);

    $sum = rand(1000, 9000) * 100;
    echo $mysqli->query("INSERT INTO `clients_deposits`(`Client_Number`, `Type`, `Start_Date`, `End_Date`, `Sum`)
    VALUES ($client, $type, '$start_date', '$end_date', $sum)");
}