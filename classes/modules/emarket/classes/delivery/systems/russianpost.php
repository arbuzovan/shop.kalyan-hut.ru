<?php
	class russianpostDelivery extends delivery {
		public function validate(order $order) {
			return true;
		}

		public function calculateSumEMS(&$ems_price, $city_from, $city_to, $weight, &$ems_min, &$ems_max, &$ems_flag) {
			$ems_max_weigt = json_decode(umiRemoteFileGetter::get('http://emspost.ru/api/rest/?method=ems.get.max.weight'));
			if (($weight <= 0) or ($weight > $ems_max_weigt->rsp->max_weight)) {
				$ems_flag = 'Недопустимый вес. Максимально возможный вес: ' . $ems_max_weigt->rsp->max_weight . 'кг. Разделите заказ на несколько.';
				return;
			}
			$ems_locations = json_decode(umiRemoteFileGetter::get('http://emspost.ru/api/rest?method=ems.get.locations&type=cities&plain=true'));
			$ems_locations = $ems_locations->rsp->locations;

			$city_from = wa_strtoupper($city_from);
			foreach ($ems_locations as $k => $value) {
				if ($value->name == $city_from) {
					$ems_city_from = $ems_locations[$k];
					break;
				}
			}
			$city_to = wa_strtoupper($city_to);
			foreach ($ems_locations as $k => $value) {
				if ($value->name == $city_to){
					$ems_city_to = $ems_locations[$k];
					break;
				}
			}
			
			if (!isset($ems_city_to)) {
				$ems_flag = 'Ошибка расчета цены. Уточните город на странице адреса.';
				return;
			}

			$ems_calculate_price = json_decode(umiRemoteFileGetter::get('http://emspost.ru/api/rest?method=ems.calculate&from=' . $ems_city_from->value . '&to=' . $ems_city_to->value . '&weight=' . $weight));

			$ems_flag = $ems_calculate_price->rsp->stat;
			if ($ems_flag == 'ok') {
				return $ems_calculate_price->rsp;
			} 
			
			$ems_flag = 'Ошибка расчета цены. Уточните город на странице адреса.';
			return;
			
		}

		public function getDeliveryPrice(order $order) {

			$objects = umiObjectsCollection::getInstance();

			$deliveryAddress = $objects->getObject($order->delivery_address);
			if(!$deliveryAddress) {
				return "Невозможно автоматически определить стоимость";
			}

			$orderPrice = $order->getActualPrice();

			$weight = 0;
			$items  = $order->getItems();
			foreach($items as $item) {
				$element    = $item->getItemElement();
				$itemWeight = (int) $element->getValue("weight");
				if($itemWeight != 0) {
					$weight += $itemWeight * $item->getAmount();
				} else {
					return "Невозможно автоматически определить стоимость";
				}
			}

			$viewPost = $objects->getObject($this->object->viewpost)->getValue("identifier");

			if($viewPost == 44 || $viewPost == 45){
				$weight = $weight/1000;
				$departureCity = $objects->getObject($this->object->departure_city);
				$departureCity = $departureCity instanceof umiObject ? $departureCity->getName() : "Москва";
				$city = $deliveryAddress->getValue("city");
				$response = $this->calculateSumEMS($price, $departureCity, $city, $weight, $min, $max, $flag);
				if ($flag == 'ok') {
					$price = $response->price;
					$min = $response->term->min;
					$max = $response->term->max;

					$flag = " {$price} руб. (займет от {$min} до {$max} дней)";
 				}
				return $flag;
			} else {
				$typePost = $objects->getObject($this->object->typepost)->getValue("identifier");
				$value    = $this->object->setpostvalue ? ceil($order->getActualPrice()) : 0;
				$zip	  = $deliveryAddress->getValue("index");
				$url = "http://www.russianpost.ru/autotarif/Autotarif.aspx?viewPost={$viewPost}&countryCode=643&typePost={$typePost}&weight={$weight}&value1={$value}&postOfficeId={$zip}";
				$content = umiRemoteFileGetter::get($url);
				if (preg_match("/<input id=\"key\" name=\"key\" value=\"(\d+)\"\/>/i", $content, $match)) {
					$key = trim($match[1]);
					$content = umiRemoteFileGetter::get($url, false, array('Content-type' => 'application/x-www-form-urlencoded'), array('key' => $key));
					$content = umiRemoteFileGetter::get($url);
				}
				if (preg_match("/span\s+id=\"TarifValue\">([^<]+)<\/span/i", $content, $match)) {
					$price = floatval(str_replace(",", ".", trim($match[1])));
					if ($price > 0) {
						return $price;
					} elseif (preg_match("/span\s+id=\"lblErrStr\">([^<]+)<\/span/i", $content, $match)) {
						return $match[1];
					}
				}
				return "Не определено. Свяжитесь с менеджером для уточнения информации.";
 			}
		}
	};
?>