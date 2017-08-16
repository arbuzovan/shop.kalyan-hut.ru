<?php
	abstract class __emarket_custom_admin {
		public $ObjPHPExcel;
		public $center;
		public $row_cnt;
		public $objDrawing; 	// Объект картинки
		
		//TODO: Write here your own macroses (admin mode)
		// Выгзрузка заказов в Excel
		public function xls_orders(){
			include('PHPExcel.php');
			include('PHPExcel/Writer/Excel5.php');
			
			$oCollection = umiObjectsCollection::getInstance();
			
		    $this->ObjPHPExcel = new PHPExcel();
	
		    $this->center = array(
			'alignment'=>array(
			    'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
			)
		    );
		    $this->row_cnt = 1;

			if(!getRequest('export_start_date') || getRequest('export_start_date') == ''){
				$arr_s_date = false;
			}else{
				$arr_s_date = explode('.', getRequest('export_start_date'));
			}

			if(!getRequest('export_start_date') || getRequest('export_start_date') == ''){
				$arr_e_date = false;
			}else{
				$arr_e_date = explode('.', getRequest('export_end_date'));
			}    
			
			if($arr_s_date){
				$start_date = mktime(0,0,0,$arr_s_date[1],$arr_s_date[0],$arr_s_date[2]);
			}else{
				$start_date = false;
			}
			
			if($arr_e_date){
				$end_date = mktime(0,0,0,$arr_e_date[1],$arr_e_date[0]+1,$arr_e_date[2]);
			}else{
				$end_date = false;
			}
			
		    
		    $selector = new selector('objects');
		    $selector->types('object-type')->name('emarket', 'order');
			if($start_date && $end_date){
				$selector->where('status_change_date')->between($start_date, $end_date);
			}
			
			if($start_date && !$end_date){
				$selector->where('status_change_date')->eqmore($start_date);
			}
			
			if(!$start_date && $end_date){
				$selector->where('status_change_date')->less($start_date);
			}
			
		    $selector->where('name')->isNull(false);
			
			// if($status_id && $status_id != ''){
				// $selector->where('status_id')->equals($status_id);
			// }
			
		    $this->ObjPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$this->row_cnt, '№ Заказа')
			->setCellValue('B'.$this->row_cnt, 'ФИО Клиента')
			->setCellValue('C'.$this->row_cnt, 'Сумма заказа')
			->setCellValue('D'.$this->row_cnt, 'email')
			->setCellValue('E'.$this->row_cnt, 'Дата оформления');
			
			$this->ObjPHPExcel->setActiveSheetIndex(0)->getColumnDimension('A')->setWidth(13);
			$this->ObjPHPExcel->setActiveSheetIndex(0)->getColumnDimension('B')->setWidth(35);
			$this->ObjPHPExcel->setActiveSheetIndex(0)->getColumnDimension('C')->setWidth(20);
			$this->ObjPHPExcel->setActiveSheetIndex(0)->getColumnDimension('D')->setWidth(20);
			$this->ObjPHPExcel->setActiveSheetIndex(0)->getColumnDimension('E')->setWidth(30);

			$oCollection = umiObjectsCollection::getInstance();
			
			$cnt = 1;
			
			foreach($selector as $order){
				$cusomer = $oCollection->getObject($order->getValue('customer_id'));
				$cnt++;
				if($cusomer){
					$lname = $cusomer->getValue('lname');
					$fname = $cusomer->getValue('fname');
					$father_name = $cusomer->getValue('father_name');
					$email = $cusomer->getValue('e-mail');
					if(!$email || $email == ''){
						$email = $cusomer->getValue('email');
					}
					$this->ObjPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$cnt, $order->getValue('number'))
						->setCellValue('B'.$cnt, $lname.' '.$fname.' '.$father_name)
						->setCellValue('C'.$cnt, $order->getValue('total_price'))
						->setCellValue('D'.$cnt, $email)
						->setCellValue('E'.$cnt, $order->getValue('order_date')->getFormattedDate('d.m.Y'));
				}else{
					$this->ObjPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.$cnt, $order->getValue('number'));
				}
		    }

		    $this->ObjPHPExcel->getActiveSheet()->setAutoFilter('A1:E'.$this->row_cnt);
			
		    $objWriter = new PHPExcel_Writer_Excel5($this->ObjPHPExcel);
		    
			$objWriter->save($_SERVER['DOCUMENT_ROOT'].'/files/orders.xls');

			
			chmod($_SERVER['DOCUMENT_ROOT'].'/files/orders.xls', 0777);
		    header('Content-Type: application/vnd.ms-excel');
		    header('Content-Disposition: attachment;filename="orders.xls"');
		    header('Cache-Control: max-age=0');
			header("Content-Length: " . filesize($_SERVER['DOCUMENT_ROOT'].'/files/orders.xls'));
			echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/files/orders.xls');
			exit;
		}
		
		public function onOrderCreate(iUmiEventPoint $oEventPoint){
			if ($oEventPoint->getMode() == "after"){
				$subject = $oEventPoint->getRef('object');
				$typesCollection = umiObjectTypesCollection::getInstance();
				$umiHierarchy = umiHierarchy::getInstance();
				$subjectTypeId = $subject->getTypeId();
				$subjectType = $typesCollection->getType($subjectTypeId);
				$subjectModule = $subjectType->getModule();
				$subjectMethod = $subjectType->getMethod();
				$subjectOrder = order::get($subject->id);
			
				if ($subjectModule == 'emarket' && $subjectMethod == 'order'){
				
					$letter = new umiMail();
					$letter->addRecipient('arbuzovan@gmail.com');
					$letter->setFrom($regedit->getVal('//modules/emarket/from-email'), $regedit->getVal('//modules/emarket/from-name'));
					$letter->setSubject('Новый заказ');
					$letter->setContent('Новый заказ');
					$letter->commit();
					$letter->send();
				
					// $orderStatusId = $subject->getValue('status_id');
					// $orderStatus = order::getCodeByStatus($orderStatusId);
					
					// if ($orderStatus == 'waiting'){
						// $subjectOrder->setDeliveryStatus(38);
					// }
					
				}
			}
		}
                
		public function onInit() {
                    $configTabs = $this->getConfigTabs();
                    $commonTabs = $this->getCommonTabs();
                    if ($configTabs){
                        $configTabs->add("ordersCounterSettings");
                        $configTabs->add("antiTabakNotificationSettings");
                    }
                    
                    //Отзывы со сторонних сайтов
//                    if($commonTabs){
//                        $commonTabs->add("reviews");
//                        $this->__loadLib("__admin_reviews.php");
//                        $this->__implement("__emarket_admin_reviews");
//                    } 
		}
                
		/* Вкладка по настройке счетчика заказов */
		public function ordersCounterSettings() {
                    $regedit = regedit::getInstance();
                    $params['emarket-counter-request']['boolean:counter_on'] = $regedit->getVal('//modules/emarket/counter_on');
                    $params['emarket-counter-request']['int:counter_delta_start'] = $regedit->getVal('//modules/emarket/counter_delta_start');
                    $params['emarket-counter-request']['int:counter_delta_end'] = $regedit->getVal('//modules/emarket/counter_delta_end');
                    $params['emarket-counter-request']['int:counter_current_value'] = $regedit->getVal('//modules/emarket/counter_current_value');


                    $data = $this->prepareData($params, 'settings');

                    $mode = (string) getRequest('param0');
                    if ($mode == "do") {
                        $params = $this->expectParams($params);

                        $regedit->setVar('//modules/emarket/counter_on', $params['emarket-counter-request']['boolean:counter_on']);
                        $regedit->setVar('//modules/emarket/counter_delta_start', $params['emarket-counter-request']['int:counter_delta_start']);
                        $regedit->setVar('//modules/emarket/counter_delta_end', $params['emarket-counter-request']['int:counter_delta_end']);
                        $regedit->setVar('//modules/emarket/counter_current_value', $params['emarket-counter-request']['int:counter_current_value']);

                        $this->chooseRedirect();
                    }

                    $this->setDataType('settings');
                    $this->setActionType('modify');

                    $this->setData($data);
                    return $this->doData();
		}
                
		public function antiTabakNotificationSettings() {
                    $regedit = regedit::getInstance();
                    $params['emarket-categoryNotification']['boolean:categoryNotificationSwitcher'] = $regedit->getVal('//modules/emarket/categoryNotificationSwitcher');
                    $params['emarket-categoryNotification']['string:categoryNotificationStart'] = $regedit->getVal('//modules/emarket/categoryNotificationStart');
                    $params['emarket-categoryNotification']['string:categoryNotificationStop'] = $regedit->getVal('//modules/emarket/categoryNotificationStop');
                    
                    $params['emarket-itemCartNotification']['boolean:itemCartNotificationSwitcher'] = $regedit->getVal('//modules/emarket/itemCartNotificationSwitcher');
                    $params['emarket-itemCartNotification']['string:itemCartNotificationStart'] = $regedit->getVal('//modules/emarket/itemCartNotificationStart');
                    $params['emarket-itemCartNotification']['string:itemCartNotificationStop'] = $regedit->getVal('//modules/emarket/itemCartNotificationStop');

                    $params['emarket-basketNotification']['boolean:basketNotificationSwitcher'] = $regedit->getVal('//modules/emarket/basketNotificationSwitcher');
                    $params['emarket-basketNotification']['string:basketNotificationStart'] = $regedit->getVal('//modules/emarket/basketNotificationStart');
                    $params['emarket-basketNotification']['string:basketNotificationStop'] = $regedit->getVal('//modules/emarket/basketNotificationStop');

                    
                    $data = $this->prepareData($params, 'settings');

                    $mode = (string) getRequest('param0');
                    if ($mode == "do") {
                        $params = $this->expectParams($params);

                        $regedit->setVar('//modules/emarket/categoryNotificationSwitcher', $params['emarket-categoryNotification']['boolean:categoryNotificationSwitcher']);
                        $regedit->setVar('//modules/emarket/categoryNotificationStart', $params['emarket-categoryNotification']['string:categoryNotificationStart']);
                        $regedit->setVar('//modules/emarket/categoryNotificationStop', $params['emarket-categoryNotification']['string:categoryNotificationStop']);
                        
                        $regedit->setVar('//modules/emarket/itemCartNotificationSwitcher', $params['emarket-itemCartNotification']['boolean:itemCartNotificationSwitcher']);
                        $regedit->setVar('//modules/emarket/itemCartNotificationStart', $params['emarket-itemCartNotification']['string:itemCartNotificationStart']);
                        $regedit->setVar('//modules/emarket/itemCartNotificationStop', $params['emarket-itemCartNotification']['string:itemCartNotificationStop']);

                        $regedit->setVar('//modules/emarket/basketNotificationSwitcher', $params['emarket-basketNotification']['boolean:basketNotificationSwitcher']);
                        $regedit->setVar('//modules/emarket/basketNotificationStart', $params['emarket-basketNotification']['string:basketNotificationStart']);
                        $regedit->setVar('//modules/emarket/basketNotificationStop', $params['emarket-basketNotification']['string:basketNotificationStop']);
                        
                        $this->chooseRedirect();
                    }

                    $this->setDataType('settings');
                    $this->setActionType('modify');

                    $this->setData($data);
                    return $this->doData();
		}
		
	};
?>