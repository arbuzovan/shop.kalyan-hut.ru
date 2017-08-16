<?php
$permissions = array(
    'purchasing' => array('clearOrderDataBase', 'optimizeTable', 'getUserLastOrderId', 'getUserEmail_ClearBasket_SS', 'getOrderInfo', 'test')
);


$permissions['purchasing'][] = 'sendSayAuth';
$permissions['purchasing'][] = 'sendSayLogout';
$permissions['purchasing'][] = 'sendSayRequest';
$permissions['purchasing'][] = 'sendSayUserExists';
$permissions['purchasing'][] = 'sendSayAddUser';
$permissions['purchasing'][] = 'sendSayGetUser';
$permissions['purchasing'][] = 'sendSayImportOrders';

$permissions['purchasing'][] = 'getPasswordMS';
$permissions['purchasing'][] = 'getRequestMS';
$permissions['purchasing'][] = 'getUrlRequestMS';
$permissions['purchasing'][] = 'getListOrdersMS';