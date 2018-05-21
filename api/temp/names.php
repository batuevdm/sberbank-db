<?php

$mysqli = new mysqli('127.0.0.1', 'root', '', 'sberbank');
if($mysqli->connect_error)
    return;

for($i = 0; $i < 15; $i++) {
    $person = file_get_contents('https://randus.org/api.php');
    if(!$person)
        return;

    $person = json_decode($person);

    $gender = $person->gender == "w" ? 1 : 0;

    $date = explode(' ', $person->date);

    $date = sprintf("%d-%'.02d-%'.02d", $date[2], rand(1, 12), $date[0]);

    $phone = str_replace('-', '', $person->phone);

    $ser = rand(1000, 9999);
    $num = rand(100000, 999999);

    $address = sprintf("%s, г. %s, ул. %s, дом %s, кв. %s", $person->postcode, $person->city, $person->street, $person->house, $person->apartment);
    echo $mysqli->query("INSERT INTO `clients`(`First_Name`, `Last_Name`, `Middle_Name`, `gender`, `Passport_Serie`, `Passport_Number`, `Address`, `Birthday`, `Phone_Number`)
  VALUES ('$person->lname', '$person->fname', '$person->patronymic', '$gender', '$ser', '$num', '$address', '$date', '$phone');");
}