<?php

class emarket_custom extends emarket
{
    public function clearOrderDataBase($limit = 3000)
    {
        set_time_limit(0);
        //ini_set('memory_limit', '512M');
        $limit > 0 ? '' : $limit = 3000;
        
        $connection = ConnectionPool::getInstance()->getConnection();
        
        /* *** Получение параметров для выборки заказов начало *** */
        $query = 'Select ot.id From (Select * From cms3_hierarchy_types Where name = "emarket" and ext = "customer") ht, cms3_object_types ot
                 Where ot.guid = "emarket-customer" and ot.hierarchy_type_id = ht.id';
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $emarket_customer_id = $row[0];
        
        $query = 'Select id From cms3_object_types Where guid = "emarket-order"';
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $emarket_order_type_id = $row[0];
        
        $query = 'Select id From cms3_object_field_groups Where name = "order_props" and type_id = '.$emarket_order_type_id;
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $group_order_props_id = $row[0];
        
        $query = 'Select of_number.id as number  
                 From (Select field_id From cms3_fields_controller Where group_id = '.$group_order_props_id.') fc, cms3_object_fields of_number 
                 Where fc.field_id = of_number.id and of_number.name = "number"';
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $field_number = $row[0];

        $query = 'Select of_customer_id.id as customer_id 
                 From (Select field_id From cms3_fields_controller Where group_id = '.$group_order_props_id.') fc, cms3_object_fields of_customer_id 
                 Where fc.field_id = of_customer_id.id and of_customer_id.name = "customer_id"';
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $field_customer_id = $row[0];
        
        $query = 'Select of_customer_id.id as order_items 
                 From (Select field_id From cms3_fields_controller Where group_id = '.$group_order_props_id.') fc, cms3_object_fields of_customer_id 
                 Where fc.field_id = of_customer_id.id and of_customer_id.name = "order_items"';
        $result = $connection->queryResult($query);
        $result->setFetchType(IQueryResult::FETCH_ARRAY);
        $row = $result->fetch();
        $field_order_items_id = $row[0];
        /* *** Получение параметров для выборки заказов конец *** */
        
        //выборка гостевых заказов которые не оформлены
        $optimize = false;
        
        $query_user = '(Select coalesce(oc_user.rel_val, 0) as rel_id From cms3_object_content oc_user Where oc_user.field_id = '.$field_customer_id.' and oc_user.obj_id = oc_number.obj_id limit 0, 1)';
        $query = 'Select oc_number.obj_id, coalesce(o.name, "") as name, coalesce('.$query_user.', 0) as user_id 
                 From cms3_objects o, cms3_object_content oc_number 
                 Where oc_number.field_id = '.$field_number.' and oc_number.int_val is null and o.id = oc_number.obj_id 
                 order by oc_number.obj_id asc limit 0, '.$limit;
        $result = $connection->queryResult($query);
        
        if($result->length() > 0)
        {
            $result->setFetchType(IQueryResult::FETCH_ASSOC);
            $mas_order_ids = array(); $mas_user_ids = array(); $mas_item_ids = array();
            $result_item = $row_item = $query_count_order = $result_count_order = '';
            while($row = $result->fetch())
            {
                if($row['name'] != 'dummy')
                {
                    $mas_order_ids[] = $row['obj_id'];
                    if($row['user_id'] > 0)
                    {
                        $query_count_order = 'Select _oc.obj_id From cms3_object_content _oc Where _oc.field_id = '.$field_customer_id.' and _oc.rel_val = '.$row['user_id'];
                        $result_count_order = $connection->queryResult($query_count_order);
                        
                        if($result_count_order->length() <= 1)
                        {
                            $mas_user_ids[$row['user_id']] = $row['user_id'];
                        }
                    }
                    
                    $query = 'Select oc.rel_val From cms3_object_content oc 
                             Where oc.field_id = '.$field_order_items_id.' and oc.obj_id = '.$row['obj_id'];
                    $result_item = $connection->queryResult($query);
                    if($result_item->length() > 0)
                    {
                        $result_item->setFetchType(IQueryResult::FETCH_ASSOC);
                        while($row_item = $result_item->fetch())
                        {
                            $row_item['rel_val'] > 0 ? $mas_item_ids[] = $row_item['rel_val'] : '';
                        }
                    }
                }
            }
            
            if(sizeof($mas_user_ids) > 0 && $emarket_customer_id > 0)
            {
                foreach(array_chunk($mas_user_ids, 50) as $key=>$value)
                {
                    $query = 'Delete From cms3_objects Where id in('.implode(',', $value).') and type_id = '.$emarket_customer_id;
                    $connection->query($query);
                }
                unset($mas_user_ids);
            }

            if(sizeof($mas_item_ids) > 0)
            {
                foreach(array_chunk($mas_item_ids, 50) as $key=>$value)
                {
                    $query = 'Delete From cms3_objects Where id in('.implode(',', $value).')';
                    $connection->query($query);
                }
                unset($mas_item_ids);
            }

            if(sizeof($mas_order_ids) > 0)
            {
                foreach(array_chunk($mas_order_ids, 50) as $key=>$value)
                {
                    $query = 'Delete From cms3_objects Where id in('.implode(',', $value).')';
                    $connection->query($query);
                }
            }
        }
        
        $query = 'Select o_user.id, o_user.name From cms3_objects o_user Where o_user.type_id = '.$emarket_customer_id.' and 
                 (Select count(oc_number.obj_id) From cms3_objects o, cms3_object_content oc_number, cms3_object_content oc_user 
                 Where oc_number.field_id = '.$field_number.' and o.id = oc_number.obj_id and oc_number.obj_id = oc_user.obj_id and oc_user.field_id = '.$field_customer_id.' and o_user.id = oc_user.rel_val) = 0 order by o_user.id asc limit 0, '.$limit;
        $result = $connection->queryResult($query);
        if($result->length() > 0)
        {
            $result->setFetchType(IQueryResult::FETCH_ASSOC);
            $mas_user_ids = array();

            while($row = $result->fetch())
            {
                if($row['name'] != 'dummy')
                {
                    $row['id'] > 0 ? $mas_user_ids[] = $row['id'] : '';
                }
            }

            if(sizeof($mas_user_ids) > 0)
            {
                foreach(array_chunk($mas_user_ids, 50) as $key=>$value)
                {
                    $query = 'Delete From cms3_objects Where id in('.implode(',', $value).')';
                    $connection->query($query);
                }
            }
        }
        $connection->close();
        
        return 'Готово.';
    }
    
    public function optimizeTable()
    {
        set_time_limit(0);
        
        $path_dir = CURRENT_WORKING_DIR.'/files/category_items';
        if(is_dir($path_dir))
        {
            foreach(array_diff(scandir($path_dir), array('..','.')) as $key=>$value)
            {
                if(is_file($path_dir.'/'.$value))
                {
                    unlink($path_dir.'/'.$value);
                }
            }
        }
        
        $path_dir = CURRENT_WORKING_DIR.'/files/show_special_option_items';
        if(is_dir($path_dir))
        {
            foreach(array_diff(scandir($path_dir), array('..','.')) as $key=>$value)
            {
                if(is_file($path_dir.'/'.$value))
                {
                    unlink($path_dir.'/'.$value);
                }
            }
        }
        
        $path_dir = CURRENT_WORKING_DIR.'/files/menu_items';
        if(is_dir($path_dir))
        {
            foreach(array_diff(scandir($path_dir), array('..','.')) as $key=>$value)
            {
                if(is_file($path_dir.'/'.$value))
                {
                    unlink($path_dir.'/'.$value);
                }
            }
        }
        
        $connection = ConnectionPool::getInstance()->getConnection();
        
        $query = "OPTIMIZE TABLE `cms3_object_content`";
        $connection->query($query);
        
        $query = "OPTIMIZE TABLE `cms3_objects`";
        $connection->query($query);
        
        $query = "OPTIMIZE TABLE `cms3_hierarchy`, `cms3_hierarchy_relations`";
        $connection->query($query);
        
        $connection->close();
    }
    
    public function getUserLastOrderId()
    {
        $order_id = 0;
        $order = $this->getBasketOrder(false);
        $user_id = $order->getValue('customer_id');
        
        if($user_id > 0)
        {
            $connection = ConnectionPool::getInstance()->getConnection();
            $query = 'Select oc.obj_id From cms3_object_content oc Where oc.field_id = 60 and oc.rel_val = '.$user_id.' order by oc.obj_id desc limit 0, 2';
            $result = $connection->queryResult($query);
            
            if($result->length() > 0)
            {
                $result->setFetchType(IQueryResult::FETCH_ASSOC);
                While($row = $result->fetch())
                {
                    $order_id = $row['obj_id'];
                }
            }
            
            $connection->close();
        }
        
        return $order_id;
    }
    
    public function getUserEmail_ClearBasket_SS()
    {
        $email = '';
        $order_id = (int)getRequest('order_id');
        
        if($order_id > 0)
        {
            $order = order::get($order_id);
            if(is_object($order) && $order instanceof order)
            {
                $user_id = $order->getValue('customer_id');
                $obj_user = umiObjectsCollection::getInstance()->getObject($user_id);
                $email = $obj_user->getValue('e-mail');
                $email != '' ? '' : $email = $obj_user->getValue('email');
            }
        }
        
        return array('email'=>$email, 'order_id'=>$order_id);
    }
    
    public function getOrderInfo()
    {
        $mas = array();
        $order_id = (int)getRequest('order_id');
        $order = '';
        
        if($order_id > 0)
        {
            $order = order::get($order_id);
        }
        else
        {
            $order = $this->getBasketOrder(false);
            $order_id = $order->getId();
        }
        
        if(is_object($order) && $order instanceof order)
        {
            $orderItems = $order->getItems();
            if(sizeof($orderItems) > 0)
            {
                $element = '';
                $tmp_mas = array();
                
                $user_id = $order->getValue('customer_id');
                $obj_user = umiObjectsCollection::getInstance()->getObject($user_id);
                $email = $phone = '';
                
                if(is_object($obj_user) && $obj_user instanceof umiObject)
                {
                    $email = $obj_user->getValue('e-mail');
                    $email != '' ? '' : $email = $obj_user->getValue('email');
                    $phone = $obj_user->getValue('phone');
                }
                
                foreach($orderItems as $orderItem)
                {
                    if($orderItem instanceof orderItem)
                    {
                        $element = $orderItem->getItemElement();
                        $tmp_mas[] = array('id'=>$element->getId(), 'name'=>$element->getName(), 'count'=>$orderItem->getAmount(), 'price'=>(float)$orderItem->getItemPrice());
                    }
                }
                
                $mas['items'] = $tmp_mas;
                $mas['email'] = $email;
                $mas['phone'] = $phone;
                $mas['order_id'] = $order_id;
                
                //setcookie('sndsy_basket_'.$order_id, 1, time() + (3600 * 24 * 30), '/');
            }
        }
        
        return $mas;
    }
    
    public function sendSayAuth()
    {
        $mas = array();
        $mas[] = 'apiversion=100';
        $mas[] = 'json=1';
        $mas[] = 'request='.urlencode(json_encode(array('action'=>'login', 'login'=>'di-zi77@yandex.ru', 'sublogin'=>'', 'passwd'=>'exu3Kaj')));
        
        $response = $this->sendSayRequest($mas);
        
        return $response['session'];
    }
    
    public function sendSayLogout($session = '')
    {
        if($session != '')
        {
            $mas = array();
            $mas[] = 'apiversion=100';
            $mas[] = 'json=1';
            $mas[] = 'request='.urlencode(json_encode(array('action'=>'logout', 'session'=>$session)));
            $this->sendSayRequest($mas);
        }
    }
    
    public function sendSayRequest($mas = array())
    {
        $url = 'https://api.sendsay.ru';
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $mas));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept'=>'application/x-www-form-urlencoded', 'Accept-Charset' => 'utf-8'));
        
        $result = curl_exec($ch);
        
        curl_close($ch);
        $response = json_decode($result, TRUE);
        
        if(isset($response['REDIRECT']))
        {
            $new_url = $url.$response['REDIRECT'];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $new_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, implode('&', $mas));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept'=>'application/x-www-form-urlencoded', 'Accept-Charset' => 'utf-8'));
            
            $result = curl_exec($ch);
            
            curl_close($ch);
            $response = json_decode($result, TRUE);
        }
        
        return $response;
    }
    
    public function sendSayUserExists($email = '')
    {
        $is_exists = FALSE;
        
        $session = $this->sendSayAuth();
        $mas = array();
        $mas[] = 'apiversion=100';
        $mas[] = 'json=1';
        $mas[] = 'request='.urlencode(json_encode(array('action'=>'member.exists', 'email'=>$email, 'addr_type'=>'email', 'session'=>$session)));
        
        $result = $this->sendSayRequest($mas);
        if(isset($result['list']))
        {
            foreach($result['list'] as $key=>$value)
            {
                if($value == 1)
                {
                    $is_exists = TRUE;
                }
            }
        }
        $this->sendSayLogout($session);
        
        return $is_exists;
    }
    
    public function sendSayAddUser($email = '', $user_orders = array(), $new = 0)
    {
        $result = array();
        
        if($email != '')
        {
            $datakey = array(array('customer', 'set', $user_orders));
            $phone = $user_name = '';
            
            foreach($user_orders as $key=>$value)
            {
                $user_name = $value['Контрагент: Имя'];
                if($user_name != '')
                {
                    break;
                }
            }
            foreach($user_orders as $key=>$value)
            {
                $phone = preg_replace("/[^0-9]/", '', $value['Телефон']);
                if($phone != '')
                {
                    break;
                }
            }
            
            $obj = array('a68'=>array('q297'=>$user_orders['customer.orders']['Сумма заказов'], 'q952'=>$user_orders['customer.orders']['Количество заказов'], 'q850'=>$user_name, 'q446'=>$phone));
            if($new == 1)
            {
                $datakey = array(array('customer', 'set', $user_orders), array('-group.p189', 'set', 1));
            }
            
            $session = $this->sendSayAuth();
            $mas = array();
            $mas[] = 'apiversion=100';
            $mas[] = 'json=1';
            $mas[] = 'request='.urlencode(json_encode(array('action'=>'member.set', 'email'=>$email, 'addr_type'=>'email', 'datakey'=>$datakey, 'newbie.confirm'=>0, 'session'=>$session)));
            $result = $this->sendSayRequest($mas);
            
            $mas = array();
            $mas[] = 'apiversion=100';
            $mas[] = 'json=1';
            $mas[] = 'request='.urlencode(json_encode(array('action'=>'member.set', 'email'=>$email, 'addr_type'=>'email', 'obj'=>$obj, 'newbie.confirm'=>0, 'session'=>$session)));
            $result = $this->sendSayRequest($mas);
            
            $this->sendSayLogout($session);
        }
        
        return $result;
    }
    
    public function sendSayGetUser($email = '')
    {
        $result = array();
        
        if($email != '')
        {
            $session = $this->sendSayAuth();
            $mas = array();
            $mas[] = 'apiversion=100';
            $mas[] = 'json=1';
            $mas[] = 'request='.urlencode(json_encode(array('action'=>'member.get', 'email'=>$email, 'addr_type'=>'email', 'datakey'=>'customer', 'session'=>$session)));
            
            $result = $this->sendSayRequest($mas);
            $this->sendSayLogout($session);
        }
        
        return $result;
    }
    
    public function sendSayImportOrders()
    {
        set_time_limit(0);
        
        $mas_orders = $this->getListOrdersMS();
        $list_email = array();
        
        if(sizeof($mas_orders) > 0)
        {
            $mas = array();
            $user_mas = array();
            $customer_orders = array();
            $count_orders = $sum_orders = 0;
            
            foreach($mas_orders as $key=>$ms_orders)
            {
                $list_email[] = $key;
                $count_orders = $sum_orders = 0;
                $mas = array();
                $user_mas = array();
                $customer_orders = array();
                
                if(!$this->sendSayUserExists($key))
                {
                    foreach($ms_orders as $_key=>$_value)
                    {
                        ++$count_orders;
                        $sum_orders += $_value['Сумма заказа'];
                    }
                    
                    $mas = $mas_orders[$key];
                    $customer_orders['customer.orders']['Сумма заказов'] = $sum_orders;
                    $customer_orders['customer.orders']['Количество заказов'] = $count_orders;
                    $mas = array_merge($customer_orders, $mas);
                    
                    $this->sendSayAddUser($key, $mas, 1);
                    
                }
                else
                {
                    $user_mas = $this->sendSayGetUser($key);
                    if(isset($user_mas['datakey']) && sizeof($user_mas['datakey']) == 0)
                    {
                        foreach($ms_orders as $_key=>$_value)
                        {
                            ++$count_orders;
                            $sum_orders += $_value['Сумма заказа'];
                        }
                        
                        $mas = $mas_orders[$key];
                        $customer_orders['customer.orders']['Сумма заказов'] = $sum_orders;
                        $customer_orders['customer.orders']['Количество заказов'] = $count_orders;
                        $mas = array_merge($customer_orders, $mas);
                    }
                    else
                    {
                        if(isset($user_mas['datakey']['customer.orders']))
                        {
                            unset($user_mas['datakey']['customer.orders']);
                        }
                        
                        foreach($ms_orders as $_key=>$_value)
                        {
                            if(!isset($user_mas['datakey'][$_key]))
                            {
                                $mas[$_key] = $_value;
                            }
                        }
                        foreach($user_mas['datakey'] as $_key=>$_value)
                        {
                            $mas[$_key] = (isset($ms_orders[$_key])) ?  $ms_orders[$_key] : $_value;
                        }
                        
                        foreach($mas as $_key=>$_value)
                        {
                            ++$count_orders;
                            $sum_orders += $_value['Сумма заказа'];
                        }
                        
                        $customer_orders['customer.orders']['Сумма заказов'] = $sum_orders;
                        $customer_orders['customer.orders']['Количество заказов'] = $count_orders;
                        $mas = array_merge($customer_orders, $mas);
                    }
                    
                    $this->sendSayAddUser($key, $mas);
                }
                
                unset($mas);
                unset($user_mas);
                unset($customer_orders);
                gc_collect_cycles();
            }
        }
        
        file_put_contents(CURRENT_WORKING_DIR.'/files/ss_emails.txt', json_encode($list_email)."\r\n\r\n", FILE_APPEND);
        echo '<pre>';
        print_r($list_email);
        echo '</pre>';
        die;
    }
    
    
    public function getPasswordMS()
    {
        return 'zapad@kh:indoor';
    }
    
    public function getRequestMS($url = '', $context = '')
    {
        $response = '';
        if($url == '')
        {
            return $response;
        }
        
        if($context == '')
        {
            $_pas = $this->getPasswordMS();
            $pas = base64_encode($_pas);
            
            $context = stream_context_create(array(
                'http' => array('header' => "Authorization: Basic ".$pas)
            ));
        }
        
        $query_ms = 'https://online.moysklad.ru/api/remap/1.1/entity/'.$url;
        $response = file_get_contents($query_ms, false, $context);
        $load_json = json_decode($response, TRUE);
        
        if(!isset($load_json['meta']['size']))
        {
            $response = file_get_contents($query_ms, false, $context);
            $load_json = json_decode($response, TRUE);
            if(!isset($load_json['meta']['size']))
            {
                $response = file_get_contents($query_ms, false, $context);
                $load_json = json_decode($response, TRUE);
                if(!isset($load_json['meta']['size']))
                {
                    $response = file_get_contents($query_ms, false, $context);
                    $load_json = json_decode($response, TRUE);
                    if(!isset($load_json['meta']['size']))
                    {
                        $response = file_get_contents($query_ms, false, $context);
                        $load_json = json_decode($response, TRUE);
                    }
                }
            }
        }
        
        return $load_json;
    }
    
    public function getUrlRequestMS($query_ms = '', $context = '')
    {
        $response = '';
        if($query_ms == '')
        {
            return $response;
        }
        
        if($context == '')
        {
            $_pas = $this->getPasswordMS();
            $pas = base64_encode($_pas);
            
            $context = stream_context_create(array(
                'http' => array('header' => "Authorization: Basic ".$pas)
            ));
        }
        
        $response = file_get_contents($query_ms, false, $context);
        $load_json = json_decode($response, TRUE);
        
        if(!isset($load_json['id']))
        {
            $response = file_get_contents($query_ms, false, $context);
            $load_json = json_decode($response, TRUE);
            if(!isset($load_json['id']))
            {
                $response = file_get_contents($query_ms, false, $context);
                $load_json = json_decode($response, TRUE);
                if(!isset($load_json['id']))
                {
                    $response = file_get_contents($query_ms, false, $context);
                    $load_json = json_decode($response, TRUE);
                    if(!isset($load_json['id']))
                    {
                        $response = file_get_contents($query_ms, false, $context);
                        $load_json = json_decode($response, TRUE);
                    }
                }
            }
        }
        
        return $load_json;
    }
    
    public function getListOrdersMS()
    {
        $mas = array();
        $_pas = $this->getPasswordMS();
        $pas = base64_encode($_pas);
        $context = stream_context_create(array(
            'http' => array('header' => "Authorization: Basic ".$pas)
        ));
        
        $time = time();
        $_time = mktime(date('H', $time)-2, date('i', $time), date('s', $time), date('m', $time), date('d', $time), date('Y', $time));
        $time_start = date('Y-m-d H:i:s', $_time);
        $time_end = date('Y-m-d H:i:s', $time);
        
        $param = 'moment>='.$time_start.';moment<='.$time_end.';updated>='.$time_start.';updated<='.$time_end.';';
        $url = 'customerorder?expand=positions&offset=0&limit=100&filter='.urlencode($param);
        $ms_response = $this->getRequestMS($url, $context);
        
        if(isset($ms_response['rows']) && $ms_response['meta']['size'] > 0)
        {
            $user_info = array();
            $goods_info = array();
            $order_info = array();
            $status_info = array();
            $tmp_mas = array();
            $address = $email = $str_index = $customer_name = '';
            
            foreach($ms_response['rows'] as $key=>$value)
            {
                $address = $email = '';
                $tmp_mas = $this->getUrlRequestMS($value['agent']['meta']['href'], $context);
                
                if(!isset($tmp_mas['id']))
                {
                    $tmp_mas = $this->getUrlRequestMS($value['agent']['meta']['href'], $context);
                }
                
                foreach($value['attributes'] as $_key=>$_value)
                {
                    if($_value['name'] == 'Адрес')
                    {
                        $address = $_value['value'];
                    }
                    elseif($_value['name'] == 'Почта')
                    {
                        $email = $_value['value'];
                    }
                }
                
                if($address == '' && isset($tmp_mas['actualAddress']) && $tmp_mas['actualAddress'] != '')
                {
                    $address = $tmp_mas['actualAddress'];
                }
                if($email == '' && isset($tmp_mas['email']) && $tmp_mas['email'] != '')
                {
                    $email = $tmp_mas['email'];
                }
                
                if($email == '')
                {
                    continue;
                }
                
                $order_info['Контрагент: Имя'] = $tmp_mas['name'];
                $order_info['Телефон'] = isset($tmp_mas['phone']) ? $tmp_mas['phone'] : '';
                $order_info['Почта'] = $email;
                $order_info['Адрес'] = $address;
                
                $status_info = $this->getUrlRequestMS($value['state']['meta']['href'], $context);
                if(!isset($status_info['id']))
                {
                    $status_info = $this->getUrlRequestMS($value['state']['meta']['href'], $context);
                }
                
                $order_info['Номер заказа'] = $value['name'];
                $order_info['Id заказа'] = $value['externalCode'];
                $order_info['Дата заказа'] = $value['moment'];
                $order_info['Сумма заказа'] = ($value['sum'] / 100);
                $order_info['Статус заказа'] = $status_info['name'];
                
                $tmp_mas = array();
                foreach($value['positions']['rows'] as $_key=>$_value)
                {
                    $tmp_mas = $this->getUrlRequestMS($_value['assortment']['meta']['href'], $context);
                    $str_index = $_value['assortment']['meta']['type'] == 'service' ? 'Услуга' : 'Товар';
                    $goods_info[] = array($str_index.($_key + 1)=>$tmp_mas['name'], 'Количество'=>$_value['quantity'], 'Цена'=>($_value['price'] / 100));
                }
                $order_info['Заказанные товары'] = $goods_info;
                
                $customer_name = str_replace('(', '_', $value['name']);
                $customer_name = str_replace('-', '_', $customer_name);
                $mas[$email]['customer.'.(translit($customer_name))] = $order_info;
                $goods_info = array();
                $order_info = array();
                $tmp_mas = array();
            }
        }
        
        return $mas;
    }
        
}