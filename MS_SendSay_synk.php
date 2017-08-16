<?php

header('Content-Type: text/html; charset=utf-8');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//$sendsay_calladress = 'https://api.sendsay.ru/';
//$sendsay_login = 'di-zi77@yandex.ru';
//$sendsay_sublogin = 'apiuser';
//$sendsay_password = 'exu3Kaj';
//
//$data = array('apiversion' => '100', 'json' => '1', 'action' => 'login', 'login' => $sendsay_login, 'sublogin'=>$sendsay_sublogin, 'passwd'=>$sendsay_password);
////$data = array('apiversion' => '100', 'request.id'=>'100500', 'json' => 1, 'action'=>'ping');
//
////Инициализирует сеанс
//$connection = curl_init();
////Устанавливаем адрес для подключения
//curl_setopt($connection, CURLOPT_URL, $sendsay_calladress);
////Указываем, что мы будем вызывать методом POST
//curl_setopt($connection, CURLOPT_POST, 1);
////Передаем параметры методом POST
//curl_setopt($connection, CURLOPT_POSTFIELDS, json_encode($data));
//
////Говорим, что нам необходим результат
//curl_setopt($connection, CURLOPT_RETURNTRANSFER, 1);
////Выполняем запрос с сохранением результата в переменную
//$result = curl_exec($connection);
////Завершает сеанс
//curl_close($connection);
////Выводим на экран

/*
Соединение с МС
*/

$MOYSKLAD_API_ADRESS = 'https://online.moysklad.ru/api/remap/1.1';

$MOYSKLAD_USERNAME = 'admin@kh';
$MOYSKLAD_PASSWORD = 'indoor';
$MOYSKLAD_GET_COUNTERPARTY = '/entity/counterparty/?limit=1&offset=25';

$connection = curl_init();
curl_setopt($connection, CURLOPT_USERPWD, "$MOYSKLAD_USERNAME:$MOYSKLAD_PASSWORD");
curl_setopt($connection, CURLOPT_URL, $MOYSKLAD_API_ADRESS.$MOYSKLAD_GET_COUNTERPARTY);
curl_setopt($connection, CURLOPT_RETURNTRANSFER , 1);

$result = json_decode(curl_exec($connection));
echo '<pre>';
var_dump($result->rows);
echo '</pre>';