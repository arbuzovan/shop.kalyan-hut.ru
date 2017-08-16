<?php

    define("CURRENT_WORKING_DIR", str_replace("\\", "/", $dirname = dirname(__FILE__)));
    define("CRON", (isset($_SERVER['HTTP_HOST'])?"HTTP":"CLI")); 
    require CURRENT_WORKING_DIR."/libs/root-src/standalone.php";
    
    $objectsCollection = umiObjectsCollection::getInstance();
    $moduleEmarket = cmsController::getInstance()->getModule("emarket");
    $moduleUsers = cmsController::getInstance()->getModule("users");
    $permissions = permissionsCollection::getInstance();

    $orders = new selector('objects');
    $orders->types('object-type')->name('emarket', 'order');
    $orders->where('name')->like('Заказ #%');                         // Заказы только с нового сайта
    $orders->limit(0,50);
    
    foreach ($orders as $orderObj){
        $orderNumber = $orderObj->number;
        $orderCustomer = $objectsCollection->getObject($orderObj->customer_id);
        if($orderCustomer instanceof umiObject){
            if(filter_var($orderCustomer->getValue('e-mail'),FILTER_VALIDATE_EMAIL)){
                $customerEmail = $orderCustomer->getValue('e-mail');
            } else {
                $customerEmail = 'Не указан';
            }
            $order = order::get($orderObj->id);
            $orderItems = array();
            foreach ($order->getItems() as $orderItem){
                if($orderItem->getItemElement()){
                    $orderItems[] = $orderItem->getItemElement()->getName();
                }else{
                    $orderItems[] = 'Товара больше нет на сайте';
                }
            }
            if($order->getValue('order_date')){
                $orderDate = $order->getValue('order_date')->getFormattedDate('d.m.Y');
            }else{
                $orderDate = 'Не указана';
            }
            $customerFname = $orderCustomer->fname;
            $customerLname = $orderCustomer->lname;
            $customerFatherName = $orderCustomer->father_name;
            echo $customerFatherName."\n";
        }
    }