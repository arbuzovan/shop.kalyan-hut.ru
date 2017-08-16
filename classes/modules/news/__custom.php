<?php
	abstract class __custom_news {
		//TODO: Write here your own macroses
            
            
	public function custom_lastlist($path = "", $template = "default", $per_page = false, $ignore_paging = false, $sDaysInterval = '', $bSkipOrderByTime = false) {
		if(!$per_page) $per_page = $this->per_page;

		if (strlen($sDaysInterval)) {
			$sStartDaysOffset = ''; $iStartDaysOffset = 0;
			$sFinishDaysOffset = ''; $iFinishDaysOffset = 0;
			$arrDaysInterval = preg_split("/\s+/is", $sDaysInterval);
			if (isset($arrDaysInterval[0])) $sStartDaysOffset = $arrDaysInterval[0];
			if (isset($arrDaysInterval[1])) $sFinishDaysOffset = $arrDaysInterval[1];

			$iNowTime = time();
			if ($sStartDaysOffset === '+') {
				$iStartDaysOffset = (PHP_INT_MAX - $iNowTime);
			} elseif ($sStartDaysOffset === '-') {
				$iStartDaysOffset = (0 - PHP_INT_MAX + $iNowTime);
			} else {
				$iStartDaysOffset = intval($sStartDaysOffset);
				$sPostfix = substr($sStartDaysOffset, -1);
				if ($sPostfix === 'm') { // minutes
					$iStartDaysOffset *= (60);
				} elseif ($sPostfix === 'h' || $sPostfix === 'H') { // hours
					$iStartDaysOffset *= (60*60);
				} else { // days
					$iStartDaysOffset *= (60*60*24);
				}
			}
			if ($sFinishDaysOffset === '+') {
				$iFinishDaysOffset = (PHP_INT_MAX - $iNowTime);
			} elseif ($sFinishDaysOffset === '-') {
				$iFinishDaysOffset = (0 - PHP_INT_MAX + $iNowTime);
			} else {
				$iFinishDaysOffset = intval($sFinishDaysOffset);
				$sPostfix = substr($sFinishDaysOffset, -1);
				if ($sPostfix === 'm') { // minutes
					$iFinishDaysOffset *= (60);
				} elseif ($sPostfix === 'h' || $sPostfix === 'H') { // hours
					$iFinishDaysOffset *= (60*60);
				} else { // days
					$iFinishDaysOffset *= (60*60*24);
				}
			}
			$iPeriodStart = $iNowTime + $iStartDaysOffset;
			$iPeriodFinish = $iNowTime + $iFinishDaysOffset;
			$bPeriodOrder = ($iPeriodStart >= $iPeriodFinish ? false : true);
		} else {
			$iPeriodStart = false;
			$iPeriodFinish = false;
			$bPeriodOrder = false;
		}

		//
		list($template_block, $template_block_empty, $template_line, $template_archive) = def_module::loadTemplates("news/".$template, "lastlist_block", "lastlist_block_empty", "lastlist_item", "lastlist_archive");
		$curr_page = (int) getRequest('p');
		if($ignore_paging) $curr_page = 0;


		$parent_id = $this->analyzeRequiredPath($path);

		if($parent_id === false && $path != KEYWORD_GRAB_ALL) {
			throw new publicException(getLabel('error-page-does-not-exist', null, $path));
		}

		$month = (int) getRequest('month');
		$year = (int) getRequest('year');
		$day = (int) getRequest('day');


		$hierarchy_type_id = umiHierarchyTypesCollection::getInstance()->getTypeByName("news", "item")->getId();

		$object_type_id = umiObjectTypesCollection::getInstance()->getBaseType("news", "item");
		$object_type = umiObjectTypesCollection::getInstance()->getType($object_type_id);
		$publish_time_field_id = $object_type->getFieldId('publish_time');


		$sel = new umiSelection;
		$sel->addElementType($hierarchy_type_id);

		if($path != KEYWORD_GRAB_ALL) {
			$sel->addHierarchyFilter($parent_id, 0, true);
		}

		$sel->addPermissions();

		if (!$bSkipOrderByTime) {
			$sel->setOrderByProperty($publish_time_field_id, $bPeriodOrder);
		}


		if (!empty($month) && !empty($year) && !empty($day)) {
			$date1 = mktime(0, 0, 0, $month, $day, $year);
			$date2 = mktime(23, 59, 59, $month, $day, $year);
			$sel->addPropertyFilterBetween($publish_time_field_id, $date1, $date2);
		} elseif (!empty($month) && !empty($year)) {
			$date1 = mktime(0, 0, 0, $month, 1, $year);
			$date2 = mktime(23, 59, 59, $month+1, 0, $year);
			$sel->addPropertyFilterBetween($publish_time_field_id, $date1, $date2);
		} elseif( !empty($year)) {
			$date1 = mktime(0, 0, 0, 1, 1, $year);
			$date2 = mktime(23, 59, 59, 12, 31, $year);
			$sel->addPropertyFilterBetween($publish_time_field_id, $date1, $date2);
		} elseif ($iPeriodStart !== $iPeriodFinish) {
			if($iPeriodStart != false && $iPeriodFinish != false) {
				if($sDaysInterval && $sDaysInterval != '+ -') {
					if ($iPeriodStart < $iPeriodFinish) {
						$sel->addPropertyFilterBetween($publish_time_field_id, $iPeriodStart, $iPeriodFinish);
					} else {
						$sel->addPropertyFilterBetween($publish_time_field_id, $iPeriodFinish, $iPeriodStart);
					}
				}
			}
		}

		if($object_type_id) {
			$this->autoDetectOrders($sel, $object_type_id);
			$this->autoDetectFilters($sel, $object_type_id);
		}

		$sel->addLimit($per_page, $curr_page);

		$result = umiSelectionsParser::runSelection($sel);
		$total = umiSelectionsParser::runSelectionCounts($sel);

		if(($sz = sizeof($result)) > 0) {
                        $oCollection = umiObjectsCollection::getInstance();
			$block_arr = Array();

			$lines = Array();
			for($i = 0; $i < $sz; $i++) {
				$line_arr = Array();
				$element_id = $result[$i];
				$element = umiHierarchy::getInstance()->getElement($element_id);
                                
                                
                                if(count($element->timeoff) > 0){
                                    $currTime = getdate();  // Текущее время для выборочного показа по времени
                                    $offHoursArray = array();   // Массив часов, когда слайд выключен
                                    foreach ($element->timeoff as $timeId){
                                        $hourObjectArray = explode(':',$oCollection->getObject($timeId)->name);
                                        $hour = $hourObjectArray[0];
                                        $offHoursArray[] = $hour;
                                    }
                                    
                                    if(in_array($currTime['hours'], $offHoursArray)){
                                        continue;
                                    }
                                }
                                

				if(!$element) continue;

				$line_arr['attribute:id'] = $element_id;
				$line_arr['node:name'] = $element->getName();
				$line_arr['attribute:link'] = umiHierarchy::getInstance()->getPathById($element_id);
				$line_arr['xlink:href'] = "upage://" . $element_id;
				$line_arr['void:header'] = $lines_arr['name'] = $element->getName();

				if($publish_time = $element->getValue('publish_time')) {
					$line_arr['attribute:publish_time'] = $publish_time->getFormattedDate("U");
				}

				$lent_id = $element->getParentId();
				if($lent_element = umiHierarchy::getInstance()->getElement($lent_id)) {
					$lent_name = $lent_element->getName();
					$lent_link = umiHierarchy::getInstance()->getPathById($lent_id);
				} else {
					$lent_name = "";
					$lent_link = "";
				}

				$line_arr['attribute:lent_id'] = $lent_id;
				$line_arr['attribute:lent_name'] = $lent_name;
				$line_arr['attribute:lent_link'] = $lent_link;

				$lines[] = $this->parseTemplate($template_line, $line_arr, $element_id);

				$this->pushEditable("news", "item", $element_id);

				umiHierarchy::getInstance()->unloadElement($element_id);
			}

			if(is_array($parent_id)) {
				list($parent_id) = $parent_id;
			}

			$block_arr['subnodes:items'] = $block_arr['void:lines'] = $lines;
			$block_arr['archive'] = ($total > ($i)) ? $template_archive : "";
			$block_arr['archive_link'] = umiHierarchy::getInstance()->getPathById($parent_id);

			$block_arr['total'] = $total;
			$block_arr['per_page'] = $per_page;
			$block_arr['category_id'] = $parent_id;

			return $this->parseTemplate($template_block, $block_arr, $parent_id);
		} else {
			return $template_block_empty;
		}
	}

            
	};
?>