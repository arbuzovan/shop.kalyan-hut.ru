<?php
	abstract class __custom_adm_catalog {
		//TODO: Write here your own macroses (admin mode) р
		public function unaviableChange(iUmiEventPoint $event){
			if ($event->getMode() == 'after') {
				$subject = $event->getRef('element');

				if(!$subject){
					return false;
				}
				
				$object = $subject->getObject();
				$typeId = umiObjectTypesCollection::getInstance()->getBaseType('catalog', 'object');

				if ($object->getTypeId() == $typeId) {
					if($object->getValue('unaviable') != 1){
						$waitingMailList = $object->getValue('waiting');
						$waitingMailListArr = explode('|',$waitingMailList);
						foreach($waitingMailListArr as $email){
							$itemName = $object->getName();
							// Параметр конструктора - шаблон письма. По-умолчанию, "default"
							$mail = new umiMail();
							// Установка адреса отправителя
							$mail->setFrom("info@shop.kalyan-hut.ru");
							// Установка адреса получателя
							$mail->addRecipient($email, "Уважаемый клиент");
							// Установка темы письма
							$mail->setSubject("Товар {$itemName} доступен в магазине shop.kalyan-hut.ru");
							// Установка приоритета письма
							$mail->setPriorityLevel('highest');
							// setContent устанавливает текст письма, обрабатывая макросы
							$itemLink = 'http://shop.kalyan-hut.ru'.umiHierarchy::getInstance()->getPathById($subject->id);
							$mail->setContent("Добрый день. Вы оставляли заявку на оповещение Вас о доступности товара {$itemName}. Товар посупил на наш склад и <a href='".$itemLink."'>доступен для заказа</a>.");
							// подтверждение отправки сообщения
							$mail->commit();
							$res = $mail->send();
						}
					}
				}
				
			}
			return false;
		}
	};
?>