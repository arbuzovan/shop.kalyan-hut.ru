<?php
	abstract class __emarket_custom {
		public function deliveryAddressesList($template = 'default'){
		    $order = $this->getBasketOrder(false);
		    list($tpl_block, $tpl_item) = def_module::loadTemplates("./templates/shop/tpls/emarket/delivery/{$template}.tpl",
						'delivery_address_block', 'delivery_address_item');

					$customer  = customer::get();
					$addresses = $customer->delivery_addresses;
					$items_arr = array();
					$currentDeliveryId = $order->getValue('delivery_address');

					$collection = umiObjectsCollection::getInstance();

					if(is_array($addresses)) foreach($addresses as $address) {
						$addressObject = $collection->getObject($address);

						$item_arr = array(
							'attribute:id'		=> $address,
							'attribute:name'	=> $addressObject->name
						);

						if($address == $currentDeliveryId) $item_arr['attribute:active'] = 'active';

						$items_arr[] = def_module::parseTemplate($tpl_item, $item_arr, false, $address);
					}

					$types  = umiObjectTypesCollection::getInstance();
					$typeId = $types->getBaseType("emarket", "delivery_address");

					if($tpl_block) {
						return def_module::parseTemplate($tpl_block, array('items' => $items_arr, 'type_id' => $typeId));
					}
		}

		public function deliveryList($template = 'default') {
		  $order = $this->getBasketOrder(false);
		  list($tpl_block, $tpl_item_free, $tpl_item_priced) = def_module::loadTemplates("./templates/shop/tpls/emarket/delivery/{$template}.tpl",
		  'delivery_block', 'delivery_item_free', 'delivery_item_priced');

		  if(!isset($_SESSION['emarket'])) $_SESSION['emarket'] = array();
		  if(!isset($_SESSION['emarket']['delivery'])) $_SESSION['emarket']['delivery'] = array();

		  $deliveryIds = delivery::getList();
		  $deliveryIdsOrdered = array();
		  foreach($deliveryIds as $delivery) {
			$delivery_obj = delivery::get($delivery);
			$deliveryObject = $delivery_obj->getObject();
				$deliveryIdsOrdered[$deliveryObject->show_order] = $delivery;
		  }

		  ksort($deliveryIdsOrdered);
		  $deliveryIds = array();

			foreach($deliveryIdsOrdered as $delivery) {
				$deliveryIds[] = $delivery;
			}

		  $items_arr = array();
		  $currentDeliveryId = $order->getValue('delivery_id');

		  foreach($deliveryIds as $delivery) {
			  $delivery = delivery::get($delivery);
			  if($delivery->validate($order) == false) {
				continue;
			  }

				if($delivery->domain && $delivery->domain != ''){
					$domain_name_arr = explode(",", $delivery->domain);
					if(!in_array($_SERVER["HTTP_HOST"], $domain_name_arr)){
						continue;
					}
				}
			  $deliveryObject = $delivery->getObject();
			  $deliveryPrice  = $delivery->getDeliveryPrice($order);
			  $_SESSION['emarket']['delivery'][$delivery->id] = (float)$deliveryPrice;
			  $item_arr = array(
			  'attribute:id'		=> $deliveryObject->id,
			  'attribute:name'	=> $deliveryObject->name,
			  'attribute:price'	=> $deliveryPrice.'',
			  'xlink:href'		=> $deliveryObject->xlink
			  );

			  if($delivery->id == $currentDeliveryId) $item_arr['attribute:active'] = 'active';

			  $tpl_item = $deliveryPrice ? $tpl_item_priced : $tpl_item_free;
			  $items_arr[] = def_module::parseTemplate($tpl_item, $item_arr, false, $deliveryObject->id);
		  }

		  if($tpl_block) {
		  return def_module::parseTemplate($tpl_block, array('items' => $items_arr));
		  } else {
		  return array('items' => array('nodes:item'	=> $items_arr));
		  }

		}

		public function paymentsList($template = 'default') {
		  $order = $this->getBasketOrder(false);
		  list($tpl_block, $tpl_item) = def_module::loadTemplates("./templates/shop/tpls/emarket/payment/{$template}.tpl", 'payment_block', 'payment_item');

		  $payementIds = payment::getList();
		  $items_arr = array();
		  $currentPaymentId = $order->getValue('payment_id');

		  $single_variant = false;
		  $checked = '';
		  $input_type = 'radio';
		  $hidden_title = '';
		  $payment_name = false;

		  if(count($payementIds) == 1){
			$single_variant = true;
			$checked = 'checked';
			$input_type = 'hidden';
			$hidden_title = 'display: none;';
			$payment_name = '';

		  }

			foreach($payementIds as $paymentId) {
				$payment = payment::get($paymentId);
				if($payment->validate($order) == false) continue;
				$paymentObject = $payment->getObject();
				$paymentTypeId = $paymentObject->getValue('payment_type_id');
				$paymentTypeName = umiObjectsCollection::getInstance()->getObject($paymentTypeId)->getValue('class_name');

				if($payment_name){
					$payment_name = $paymentObject->name;
				}

				if( $paymentTypeName == 'social') continue;

				$item_arr = array(
					'attribute:id'			=> $paymentObject->id,
					'attribute:name'		=> $payment_name,
					'attribute:checked'		=> $checked,
					'attribute:type-name'	=> $paymentTypeName,
					'attribute:input-type'	=> $input_type,
					'xlink:href'			=> $paymentObject->xlink
				);

			  if($paymentId == $currentPaymentId) {
				$item_arr['attribute:active'] = 'active';
			  }

			  $items_arr[] = def_module::parseTemplate($tpl_item, $item_arr, false, $paymentObject->id);
		  }

		  if($tpl_block) {
			return def_module::parseTemplate($tpl_block, array('items' => $items_arr, 'hidden-title'=> $hidden_title));
		  } else {
			return array('items' => array('nodes:item'	=> $items_arr), 'hidden-title'=> $hidden_title);
		  }

		}

		public function personalInfo($template = 'default') {
		  if (!permissionsCollection::getInstance()->isAuth()){
		    $customerId = customer::get()->id;
		    $cmsController = cmsController::getInstance();
		    $data = $cmsController->getModule('data');
                    
		    return $data->getEditForm($customerId, $template);
		  }else return '';
		}

		public function saveinfo(){
			$order = $this->getBasketOrder(false);
			//сохранение регистрационных данных
			$cmsController = cmsController::getInstance();
			$data = $cmsController->getModule('data');
			$data->saveEditedObject(customer::get()->id, false, true);

                        /* В форме заказа добавлено невидимое для пользователя поле
                         * Если заказ оформляет робот, то он его "увидит" и заполнит.
                        */
                        if(trim(getRequest('fname_')) != ''){
                            return;
                        }
                        
			//сохранение способа доставки
			$deliveryId = getRequest('delivery-id');
			if($deliveryId){
				$delivery = delivery::get($deliveryId);
				$deliveryPrice = (float) $delivery->getDeliveryPrice($order);
				$order->setValue('delivery_id', $deliveryId);
				$order->setValue('delivery_price', $deliveryPrice);
			}
			//сохранение адреса доставки
			$addressId = getRequest('delivery-address');
                        
                        // Массив ID доставок самовывозом
                        $selfTakeArray = array();
                        $selfTakeArray[] = 53976;
                        $selfTakeArray[] = 273231;
                        $selfTakeArray[] = 1543284;
                        $selfTakeArray[] = 1801333;
                        
                        // Кривой хак. Для добавления отметки что заказ на самовывоз. Нужно для писем о новом заказе
                        if(in_array($deliveryId, $selfTakeArray)){
                            $addressId = 'new';
                        }
                        
			if($addressId == 'new') {
				$collection = umiObjectsCollection::getInstance();
				$types      = umiObjectTypesCollection::getInstance();
				$typeId     = $types->getBaseType("emarket", "delivery_address");
				$customer   = customer::get();
				$addressId  = $collection->addObject("Address for customer #".$customer->id, $typeId);
				$dataModule = $cmsController->getModule("data");
				if($dataModule) {
					$dataModule->saveEditedObject($addressId, true, true);
				}
				$customer->delivery_addresses = array_merge( $customer->delivery_addresses, array($addressId) );
			}

                        
                        /* Если адрес способ доставки - не самовывоз */
                        if(!in_array($deliveryId, $selfTakeArray)){
			//if($deliveryId != 53976){
			    if(!$addressId) {
				$this->errorNewMessage('Пожалуйста, выберите адрес доставки');
				$this->errorPanic();
			    }
			}

			$order->delivery_address = $addressId;

			//сохранение способа оплаты и редирект на итоговую страницу
			$order->setValue('payment_id', getRequest('payment-id'));

			$order->refresh();

			$paymentId = getRequest('payment-id');
			if(!$paymentId) {
				$this->errorNewMessage(getLabel('error-emarket-choose-payment'));
				$this->errorPanic();
			}
			$payment = payment::get($paymentId);

			if($payment instanceof payment) {
				$paymentName = $payment->getCodeName();
				$url = "{$this->pre_lang}/".cmsController::getInstance()->getUrlPrefix()."emarket/purchase/payment/{$paymentName}/";
			} else {
				$url = "{$this->pre_lang}/".cmsController::getInstance()->getUrlPrefix()."emarket/cart/";
			}


			//*************************
			if( !isset($_COOKIE['gift_on']) ){
				$presentObjects = umiHierarchy::getInstance()->getElement(11223);
				//если подарок включен
				if( $presentObjects->getIsActive() ){
					setcookie("gift_on", '1', time() + (365 * 24 * 60 * 60), '/');
				}
			}
			//*************************


			$this->redirect($url);
		}

//    public function getOrderInfo($orderId = 3395){
//
//            $full_order = umiObjectsCollection::getInstance()->getObject(3395);
//            $delivery_address_id = $full_order->delivery_addresses;
//    }

		/**
                    * TODO: Write documentation
                    *
                    * All these cases renders full basket order:
                    * /udata/emarket/basket/ - do nothing
                    * /udata/emarket/basket/add/element/9 - add element 9 into the basket
                    * /udata/emarket/basket/add/element/9?amount=5 - add element 9 into the basket + amount
                    * /udata/emarket/basket/add/element/9?option[option_name_1]=1&option=2&option[option_name_2]=3 - add element 9 using options
                    * /udata/emarket/basket/modify/element/9?option[option_name_1]=1&option=2&option[option_name_2]=3 - add element 9 using options
                    * /udata/emarket/basket/modify/item/9?option[option_name_1]=1&option=2&option[option_name_2]=3 - add element 9 using options
                    * /udata/emarket/basket/remove/element/9 - remove element 9 from the basket
                    * /udata/emarket/basket/remove/item/111 - remove orderItem 111 from the basket
                    * /udata/emarket/basket/remove_all/ - remove all orderItems from basket
		*/
		public function cust_basket($mode = false, $itemType = false, $itemId = false) {
                    $mode = $mode ? $mode : getRequest('param0');
                    $order = $this->getBasketOrder(!in_array($mode, array('put', 'remove')));
                    $itemType = $itemType ? $itemType : getRequest('param1');
                    $itemId = (int) ($itemId ? $itemId : getRequest('param2'));
                    $amount = (int) getRequest('amount');
                    $options = getRequest('options');

                    $order->refresh();

                    if($mode == 'modify') {
                        $orderItem = ($itemType == 'element') ? $this->getBasketItem($itemId) : $order->getItem($itemId);

                        if (!$orderItem) {
                            throw new publicException("Order item is not defined");
                        }

                        $amount = $amount ? $amount : ($orderItem->getAmount());
                        $orderItem->setAmount($amount ? $amount : 1);
                        $orderItem->refresh();

                        if($itemType == 'element') {
                            $order->appendItem($orderItem);
                        }
                        $order->refresh();
                    }

                    if($mode == 'put') {
                        $orderItem = ($itemType == 'element') ? $this->getBasketItem($itemId) : $order->getItem($itemId);

                        if (!$orderItem) {
                            throw new publicException("Order item is not defined");
                        }

                        if(is_array($options)) {
                            if($itemType != 'element') {
                                throw new publicException("Put basket method required element id of optionedOrderItem");
                            }

                            // Get all orderItems
                            $orderItems = $order->getItems();

                            foreach($orderItems as $tOrderItem) {

                                $itemOptions = $tOrderItem->getOptions();

                                if(sizeof($itemOptions) != sizeof($options)) {
                                    $itemOptions = null;
                                    $tOrderItem = null;
                                    continue;
                                }

                                if($tOrderItem->getItemElement()->id != $orderItem->getItemElement()->id) {
                                    $itemOptions = null;
                                    $tOrderItem = null;
                                    continue;
                                }


                                // Compare each tOrderItem with options list
                                foreach($options as $optionName => $optionId) {
                                    $itemOption = getArrayKey($itemOptions, $optionName);

                                    if(getArrayKey($itemOption, 'option-id') != $optionId) {
                                        $tOrderItem = null;
                                        continue 2;		// If does not match, create new item using options specified
                                    }
                                }

                                break;	// If matches, stop loop and continue to amount change
                            }

                            if(!isset($tOrderItem) || is_null($tOrderItem)) {
                                $tOrderItem = orderItem::create($itemId);
                                $order->appendItem($tOrderItem);
                            }

                            if($tOrderItem instanceof optionedOrderItem) {
                                foreach($options as $optionName => $optionId) {
                                    if($optionId) {
                                        $tOrderItem->appendOption($optionName, $optionId);
                                    } else {
                                        $tOrderItem->removeOption($optionName);
                                    }
                                }
                            }

                            if($tOrderItem) {
                                $orderItem = $tOrderItem;
                            }
                        }

                        $amount = $amount ? $orderItem->getAmount()+$amount : ($orderItem->getAmount() + 1);
                        $orderItem->setAmount($amount ? $amount : 1);
                        $orderItem->refresh();

                        if($itemType == 'element') {
                            $order->appendItem($orderItem);
                        }
                        $order->refresh();
                    }

                    if($mode == 'remove') {
                        $orderItem = ($itemType == 'element') ? $this->getBasketItem($itemId, false) : orderItem::get($itemId);
                        if($orderItem instanceof orderItem) {
                                $order->removeItem($orderItem);
                                $order->refresh();
                        }
                    }

                    if ($mode == 'remove_all') {
                        foreach ($order->getItems() as $orderItem) {
                                $order->removeItem($orderItem);
                        }
                        $order->refresh();
                    }

                    $referer = getServer('HTTP_REFERER');
                    $noRedirect = getRequest('no-redirect');

                    if($redirectUri = getRequest('redirect-uri')) {
                            $this->redirect($redirectUri);
                    } else if (!defined('VIA_HTTP_SCHEME') && !$noRedirect && $referer) {
                        $current = $_SERVER['REQUEST_URI'];
                        if(substr($referer, -strlen($current)) == $current) {
                            if($itemType == 'element') {
                                    $referer = umiHierarchy::getInstance()->getPathById($itemId);
                            } else {
                                    $referer = "/";
                            }
                        }
                        //$this->redirect($referer);
                    }

                    $order->refresh();
                    return $this->order($order->getId());
		}

		public function basket_popup(){
			list($order_block_popup, $order_block_popup_item) = def_module::loadTemplates("./templates/shop/tpls/emarket/basket.tpl", 'order_block_popup', 'order_block_popup_item');
			$order = $this->getBasketOrder();
			$orderItems = $order->getItems();
			$hierarchy = umiHierarchy::getInstance();


			$block_arr = array();
			$items = array();

			foreach($orderItems as $item){
				$items_arr = array();
				$items_arr['attribute:name'] = $item->getName();
				$items_arr['attribute:link'] = $hierarchy->getPathById($item->getItemElement()->id);
				$items_arr['attribute:amount'] = $item->getAmount();
				$items_arr['attribute:price'] = $item->getItemPrice()*$item->getAmount();
				$items[] = $this::parseTemplate($order_block_popup_item, $items_arr, $item->id);
			}

			$block_arr['attribute:totalPrice'] = $order->getActualPrice();
			$block_arr['subnodes:items'] = $items;

			echo def_module::parseTemplate($order_block_popup, $block_arr);
			exit;
		}

		public function basketSmallAddLink($pageId = false){
                    $hierarchy = umiHierarchy::getInstance();
                    $element = $hierarchy->getElement($pageId);
                    $unaviable = $element->getValue('unaviable');
                    if(true == $unaviable){
                        $input_block = '<div class="reminder_block">E-mail:<br /> <input type="text" rel="'.$pageId.'" class="unaviable_reminder" placeholder="Уведомить при поступлении" /><a class="reminder_ok" href="#">OK</a></div>';
                        $unaviableBtn = '<a class="unaviable" href="#" rel="'.$pageId.'">Временно недоступен</a>';
                        return $unaviableBtn.$input_block;
                    }else{
                        if(is_null($element->getValue('common_quantity'))){
                            return '%emarket basketAddLink(%id%)%';
                        }

                        if(trim($element->getValue('common_quantity')) == ''){
                            return '%emarket basketAddLink(%id%)%';
                        }

                        if($element->getValue('common_quantity') > 0){
                            return '%emarket basketAddLink(%id%)%';
                        }

                        if($element->getValue('common_quantity') <= 0){
                            $input_block = '<div class="reminder_block">E-mail:<br /> <input type="text" rel="'.$pageId.'" class="unaviable_reminder" placeholder="Уведомить при поступлении" /><a class="reminder_ok" href="#">OK</a></div>';
                            $unaviableBtn = '<a class="unaviable" href="#" rel="'.$pageId.'">Временно недоступен</a>';
                            return $unaviableBtn.$input_block;
                        }
                    }
		}


		/**
		 * Кнопка добавления товара в корзину
		 *
		 * Генерирует кнопку добавления товара в корзину
		 *
		 * @param $elementId Элемент, который требуется добавить в корзину
		 * @param string $template Шаблон(для TPL)
		 *
		 * @return mixed
		 */
		public function getBasketAddBtnBlock($elementId, $template = 'default', $cart = false) {
                    $hierarchy = umiHierarchy::getInstance();
                    $element = $hierarchy->getElement($elementId);
                    if($element->getObjectTypeId() == 318)
                    {
                        return '';
                    }
                    $unaviable = $element->getValue('unaviable');

                    $cart_postfix = '';

                    if($cart){
                        $cart_postfix = '_cart';
                    }

                    if(true == $unaviable){
                        list($tpl_block) = def_module::loadTemplates("emarket/".$template, 'basket_out_stock_block'.$cart_postfix);
                        return def_module::parseTemplate($tpl_block, array('id'=>(int) $elementId));
                    }else{


                    	if( $element->getId() == 11223 ){
                    		return;
                    	}

                        if(is_null($element->getValue('common_quantity'))){
                            list($tpl_block) = def_module::loadTemplates("emarket/".$template, 'basket_in_stock_block'.$cart_postfix);
                            return def_module::parseTemplate($tpl_block, array(
                                'link' => $this->pre_lang . '/emarket/basket/put/element/' . (int) $elementId . '/',
                                'id'=>(int) $elementId
                            ));
                        }

                        if(trim($element->getValue('common_quantity')) == ''){
                            list($tpl_block) = def_module::loadTemplates("emarket/".$template, 'basket_in_stock_block'.$cart_postfix);
                            return def_module::parseTemplate($tpl_block, array(
                                'link' => $this->pre_lang . '/emarket/basket/put/element/' . (int) $elementId . '/',
                                'id'=>(int) $elementId
                            ));
                        }

                        if($element->getValue('common_quantity') > 0){
                            list($tpl_block) = def_module::loadTemplates("emarket/".$template, 'basket_in_stock_block'.$cart_postfix);
                            return def_module::parseTemplate($tpl_block, array(
                                'link' => $this->pre_lang . '/emarket/basket/put/element/' . (int) $elementId . '/',
                                'id'=>(int) $elementId
                            ));
                        }

                        if($element->getValue('common_quantity') <= 0){
                            list($tpl_block) = def_module::loadTemplates("emarket/".$template, 'basket_out_stock_block'.$cart_postfix);
                            return def_module::parseTemplate($tpl_block, array(
                                'link' => $this->pre_lang . '/emarket/basket/put/element/' . (int) $elementId . '/',
                                'id'=>(int) $elementId
                            ));
                        }
                    }
		}
		
		public function showPrice($id = 0, $catalog_preview = 0)
                {
                    $price = '';
                    
                    if($id > 0)
                    {
                        $connection = ConnectionPool::getInstance()->getConnection();
                        $query = 'Select o.type_id From cms3_hierarchy h, cms3_objects o Where h.id = '.$id.' and h.obj_id = o.id limit 0, 1';
                        $result = $connection->queryResult($query);
                        
                        if($result->length() > 0)
                        {
                            $result->setFetchType(IQueryResult::FETCH_ASSOC);
                            $row = $result->fetch();
                            if($row['type_id'] != 318)
                            {
                                $price = "%data getProperty(%id%, 'price'".($catalog_preview ? "" : ", 'catalog_preview'").")%";
                            }
                        }
                        $connection->close();
                    }
                    
                    return $price;
                }

		public function gift_modal_show(){
			//11223 - id подарка
			$html = '';
			if ( !isset($_COOKIE['gift_on']) && !isset($_COOKIE['gift_modal']) ) {

				$presentObjects = umiHierarchy::getInstance()->getElement(11223);
				//если подарок включен
				if( $presentObjects->getIsActive() ){
					$html = '<div id="gift-popup" class="gift-popup">
							<div class="gift-popup__wrapper">
                 <div class="gift-popup__title">Вам подарок:</div>
                 <div class="gift-popup__item">
                 		' . $presentObjects->getName() .'
								 </div>
                 <div class="gift-popup__footer">Нажмите на корзину</div>
								 <button class="gift-popup__close">x</button>
							 </div>
						 </div>';
				}
			}
			return $html;
		}
		public function gift_true($id, $str1, $str2) {
			//11223 - id подарка
			if( $id != 11223 ){
				return $str1;
			}
			else{
				return $str2;
			}
		}
		public function gift_order_add() {
                    //11223 - id подарка
                    if( !isset($_COOKIE['gift_on']) ){
                        $presentObjects = umiHierarchy::getInstance()->getElement(11223);
                        //если подарок включен, то добавляем в корзину
                        if( $presentObjects->getIsActive() && !$this->is_cartPresent(11223) ){
                            $this->cust_basket('put', 'element', 11223, 1);
                        }
                    }
		}
		public function is_cartPresent($id){
			$ini = cmsController::getInstance()->getModule("emarket");
			$page = (int) $id;
			static $pages_arr;
			if(is_null($pages_arr)){
				// текущая корзина покупателя
				$order_object = $ini->getBasketOrder();
				$order = order::get($order_object->id);
				// Список элементов заказа
				$orderItems = $order->getItems();
				foreach($orderItems as $orderItem) {
					// $page_id - id товара в корзине
					$page_id = $orderItem->getItemElement()->getId();
					$pages_arr[] = $page_id;
				}
				// если товаров нет, то ставим пустой массив
				if(is_null($pages_arr)) $pages_arr = array();

				if(in_array($page, $pages_arr)){
					return TRUE;
				}else{
					return FALSE;
				}
			}else{
				if(in_array($page, $pages_arr)){
					return TRUE;
				}else{
					return FALSE;
				}
			}
		}

                /* Функция для пролучения html кода миникорзины, что бы обновить нужный блок */
                public function getMiniCartBlock(){
                    $template = templater::getInstance();
                    $string = "%emarket cart('basket')%";
                    echo $template->parseInput($string);
                    exit;
                }

	}