<?php
	abstract class payment extends umiObjectProxy {
		protected $order;

		final public static function create(iUmiObject $paymentTypeObject) {
			$objects = umiObjectsCollection::getInstance();
			$paymentTypeId = null;
			if(strlen($paymentTypeObject->payment_type_guid)) {
				$paymentTypeId = umiObjectTypesCollection::getInstance()->getTypeIdByGUID($paymentTypeObject->payment_type_guid);
			} else {
				$paymentTypeId = $paymentTypeObject->payment_type_id;
			}
			$objectId = $objects->addObject('', $paymentTypeId);
			$object = $objects->getObject($objectId);
			if($object instanceof umiObject) {
				$object->payment_type_id = $paymentTypeObject->id;
				$object->commit();

				return self::get($objectId);
			} else {
				return false;
			}
		}

		final public static function get($objectId, order $order = null) {
			if($objectId instanceof iUmiObject) {
				$object = $objectId;
			} else {
				$objects = umiObjectsCollection::getInstance();
				$object = $objects->getObject($objectId);

				if($object instanceof iUmiObject == false) {
					throw new coreException("Couldn't load order item object #{$objectId}");
				}
			}

			$classPrefix = objectProxyHelper::getClassPrefixByType($object->payment_type_id);

			objectProxyHelper::includeClass('emarket/classes/payment/systems/', $classPrefix);
			$className = $classPrefix . 'Payment';
			return new $className($object, $order);
		}

		final public static function getList() {
			$sel = new selector('objects');
			$sel->types('object-type')->name('emarket', 'payment');
			return $sel->result;
		}

		/**
		 * Ищет идентификатор заказа в ответе платежной системы.
		 * Сначала проверяются стандартные поля, потом опрашивается метод getOrderId
		 * каждой подключенной платежной системы
		 * @return Integer | boolean false
		 */
		final public static function getResponseOrderId() {
			$orderId = (int) getRequest('param0');
			if(!$orderId) $orderId = (int) getRequest('orderid');
			if(!$orderId) $orderId = (int) getRequest('orderId');	// RBK
			if(!$orderId) $orderId = (int) getRequest('order-id');	// Chronopay
			if(!$orderId) $orderId = (int) getRequest('order_id');
			if(!$orderId) {
				$paymentSystems = self::getList();
				foreach ($paymentSystems as $paymentSystem) {
					$classPrefix = objectProxyHelper::getClassPrefixByType($paymentSystem->payment_type_id);
					objectProxyHelper::includeClass('emarket/classes/payment/systems/', $classPrefix);
					$className = $classPrefix . 'Payment';
					//TODO: change to $className::getOrderId() after minimum requirements for UMI changes to PHP 5.3
					$orderId = (int) call_user_func("$className::getOrderId");
					if ($orderId) {
						break;
					}
				}
			}
			return $orderId;
		}

		public function __construct(iUmiObject $object, order $order = null) {
			parent::__construct($object);
			$this->order = $order;
		}

		public function getCodeName() {
			$objects = umiObjectsCollection::getInstance();
			$paymentTypeId = $this->object->payment_type_id;
			$paymentType = $objects->getObject($paymentTypeId);
			return ($paymentType instanceof iUmiObject) ? $paymentType->class_name : false;
		}

		/**
		 * Ищет идентификатор заказа в параметре специфичном для платежной системы.
		 * Если платежная системы использует один из предопределенных параметров
		 * (orderid, orderId, order-id, order_id) возвращает false, в противном случае
		 * необходимо переопредилить функцию в файле платежной системы.
		 * @return Integer | boolean false
		 */
		public static function getOrderId() {
			return false;
		}

		abstract function validate();
		abstract function process();
		abstract function poll();
	};
?>