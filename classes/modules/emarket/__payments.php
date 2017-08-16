<?php
	abstract class __emarket_payment {

		public function payment(order $order, $step, $mode, $template) {
			$paymentId = $order->getValue('payment_id');
			$payment = null;
			if($paymentId) {
				$payment = payment::get($paymentId, $order);
			}

			switch($step) {
				case 'choose':
					return ($mode == 'do') ? $this->choosePayment($order) : $this->renderPaymentsList($order, $template);
					break;
				case 'bonus':
					$urlPrefix = cmsController::getInstance()->getUrlPrefix() ? (cmsController::getInstance()->getUrlPrefix() . '/') : '';
					if ($mode == 'do') {
						$bonus = getRequest("bonus");
						$controller = cmsController::getInstance();
						 if ($bonus || $bonus === 0 || $bonus === '0') {
							$order->setBonusDiscount($bonus);
							$order->refresh();
							if (!$order->getActualPrice()) {
								$order->setPaymentStatus('accepted');
								$order->order();
								$this->redirect($this->pre_lang .'/'. $urlPrefix . 'emarket/purchase/result/successful/');
							}
						}
						$this->redirect($this->pre_lang .'/'. $urlPrefix . 'emarket/purchase/payment/choose/');
					} else {
						return $this->renderBonusPayment($order, $template);
					}
					break;

				default:
					if($payment instanceof payment) {
						return $payment->process($template);
					} else {
						throw new privateException("Unkown payment step \"{$step}\"");
					}
			}
		}

		public function paymentCheckStep(order $order, $step) {
			if (($step == 'address' && !regedit::getInstance()->getVal('//modules/emarket/enable-delivery')) || ($step == 'bonus' && !customer::get()->bonus)) {
				return false;
			}
			return $step;
		}

		public function renderPaymentsList(order $order, $template) {
			list($tpl_block, $tpl_item) = def_module::loadTemplates("emarket/payment/".$template, 'payment_block', 'payment_item');

			$payementIds = payment::getList(); $items_arr = array();
			$currentPaymentId = $order->getValue('payment_id');

			foreach($payementIds as $paymentId) {
				$payment = payment::get($paymentId, $order);
				if($payment->validate() == false) continue;
				$paymentObject = $payment->getObject();
				$paymentTypeId = $paymentObject->getValue('payment_type_id');
				$paymentTypeName = umiObjectsCollection::getInstance()->getObject($paymentTypeId)->getValue('class_name');

				if( $paymentTypeName == 'social') continue;

				$item_arr = array(
					'attribute:id'			=> $paymentObject->id,
					'attribute:name'		=> $paymentObject->name,
					'attribute:type-name'	=> $paymentTypeName,
					'xlink:href'			=> $paymentObject->xlink
				);

				if($paymentId == $currentPaymentId) {
					$item_arr['attribute:active'] = 'active';
				}

				$items_arr[] = def_module::parseTemplate($tpl_item, $item_arr, false, $paymentObject->id);
			}

/*			if(cmsController::getInstance()->getCurrentTemplater() instanceof tplTemplater) {
				return def_module::parseTemplate($tpl_block, array('items' => $items_arr));
			} else {
				return array('items' => array('nodes:item'	=> $items_arr));
			}*/

			$urlPrefix = cmsController::getInstance()->getUrlPrefix() ? (cmsController::getInstance()->getUrlPrefix() . '/') : '';
			$submitUrl = $this->pre_lang . '/' . $urlPrefix . 'emarket/purchase/payment/choose/do/';
			return def_module::parseTemplate($tpl_block, array('subnodes:items' => $items_arr, 'submit_url' => $submitUrl));

		}

		public function renderBonusPayment(order $order, $template) {

			list($tpl_block) = def_module::loadTemplates("emarket/payment/" . $template, 'bonus_block');
			$customer = customer::get($order->getCustomerId());

			$block_arr = array(
				'bonus'	=> $this->formatCurrencyPrice(array(
					'reserved_bonus'		=> $order->getBonusDiscount(),
					'available_bonus'		=> $customer->bonus,
					'spent_bonus'			=> $customer->spent_bonus,
					'actual_total_price' 	=> $order->getActualPrice(),
				))
			);
			$block_arr['void:reserved_bonus'] = $this->parsePriceTpl($template, $this->formatCurrencyPrice(array('actual' => $order->getBonusDiscount())));
			$block_arr['void:available_bonus'] = $this->parsePriceTpl($template, $this->formatCurrencyPrice(array('actual' => $customer->bonus)));
			$block_arr['void:spent_bonus'] = $this->parsePriceTpl($template, $this->formatCurrencyPrice(array('actual' => $customer->spent_bonus)));
			$block_arr['void:actual_total_price'] = $this->parsePriceTpl($template, $this->formatCurrencyPrice(array('actual' => $order->getActualPrice())));

			return def_module::parseTemplate($tpl_block, $block_arr);

		}

		public function choosePayment(order $order) {
			$paymentId = getRequest('payment-id');
			if(!$paymentId) {
				$this->errorNewMessage(getLabel('error-emarket-choose-payment'));
				$this->errorPanic();
			}
			$order->setValue('payment_id', $paymentId);
			$order->commit();

			$payment = payment::get($paymentId);

			$urlPrefix = cmsController::getInstance()->getUrlPrefix() ? (cmsController::getInstance()->getUrlPrefix() . '/') : '';
			if($payment instanceof payment) {
				$paymentName = $payment->getCodeName();
				$url = "{$this->pre_lang}/".$urlPrefix."emarket/purchase/payment/{$paymentName}/";
			} else {
				$url = "{$this->pre_lang}/".$urlPrefix."emarket/purchase/payment/choose/";
			}
			$this->redirect($url);
		}

		public function gateway() {
			if ($error = getRequest('err_msg')) {
				$error = $error[0];
				$error = iconv("windows-1251", "utf-8", urldecode($error));
				cmsController::getInstance()->errorUrl = "/emarket/ordersList/";
				$this->errorNewMessage($error);
			}

			$orderId = payment::getResponseOrderId();
			if (!$orderId) {
				throw new publicException("Order identificator wasn't recieved from payment system");
			}

			$order = order::get($orderId);
			if ($order instanceof order) {
				$paymentId = $order->getValue('payment_id');
				if ($paymentId) {
					$payment = payment::get($paymentId, $order);
					return $payment->poll();
				} else {
					throw new publicException("No payment method inited for order #{$orderId}");
				}
			} else {
				throw new publicException("Order #{$orderId} doesn't exists");
			}
		}

		public function receipt() {
			$orderId = (int) getRequest('param0');
			if(!$orderId) $orderId = (int) getRequest('order-id');
			$sign = (string) getRequest('param1');
			if(!$sign) $sign = (string) getRequest('signature');
			$order = order::get($orderId);

			if($order instanceof order) {

				$customer = customer::get($order->getCustomerId());
				if($customer->isUser()) {
					$users = cmsController::getInstance()->getModule('users');
					$userId = $users->user_id;
					if($userId != $customer->id) {
						throw new publicException("Access denied");
					}
					$permissions = permissionsCollection::getInstance();
					$object = umiObjectsCollection::getInstance()->getObject($orderId);
					if ($object->getOwnerId() != $userId && !$permissions->isSv($userId)) {
						throw new publicException("Access denied");
					}
				} else {
					if (strcasecmp($sign, sha1("{$customer->id}:{$customer->email}:{$order->order_date}")) !== 0) {
						throw new publicException("Access denied");
					}
				}
				$uri = "uobject://{$orderId}/?transform=sys-tpls/emarket-receipt.xsl";
				$result = file_get_contents($uri);
				$buffer = outputBuffer::current();
				$buffer->charset('utf-8');
				$buffer->contentType('text/html');
				$buffer->clear();
				$buffer->push($result);
				$buffer->end();
			} else {
				throw new publicException("Order #{$orderId} doesn't exists");
			}
		}
	};
?>
