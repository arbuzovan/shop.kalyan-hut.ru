<?php
	abstract class __custom_catalog {
		public $ObjPHPExcel;
		public $center;
		public $row_cnt;
		public $objDrawing; 	// Объект картинки


		//TODO: Write here your own macroses

		public function fill_price($id = false){
			if(!$id){
				return false;
			}
			$hierarchy = umiHierarchy::getInstance();
			$items = $hierarchy->getChilds($id, false, false, 0);

			$typesCollection = umiObjectTypesCollection::getInstance();
			$categoryId = $typesCollection->getBaseType('catalog', 'category');


			$show_title = true;
			foreach($items as $key=>$item_id){
				$item = $hierarchy->getElement($key);
				// Определяем тип и либо рекурсивно вызываем либо делаем списко товаров.
				if($item->getObjectTypeId() == $categoryId){
					$this->ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$this->row_cnt, $item->getValue('h1'));
					$this->row_cnt++;
					$this->fill_price($key);
				}else{
					if($show_title){
						$this->ObjPHPExcel->setActiveSheetIndex(0)
							->setCellValue('A'.$this->row_cnt, 'Артикул')
							->setCellValue('B'.$this->row_cnt, 'Название')
							->setCellValue('C'.$this->row_cnt, 'Цена')
							->setCellValue('D'.$this->row_cnt, 'Изображение');
						$this->row_cnt++;
						$show_title = false;
					}
					$this->ObjPHPExcel->getActiveSheet()->SetCellValue('A'.$this->row_cnt, $item->getValue('art'));
					$this->ObjPHPExcel->getActiveSheet()->SetCellValue('B'.$this->row_cnt, $item->getValue('h1'));
					$this->ObjPHPExcel->getActiveSheet()->SetCellValue('C'.$this->row_cnt, $item->getValue('price').' руб.');

					$this->objDrawing = new PHPExcel_Worksheet_Drawing();
					$this->objDrawing->setWorksheet($this->ObjPHPExcel->getActiveSheet());

					$this->objDrawing->setPath('.'.$item->getValue('photo'));
					$this->objDrawing->setHeight(200);
					$this->ObjPHPExcel->getActiveSheet()->getRowDimension($this->row_cnt)->setRowHeight(155);

					//To add the above drawing to the worksheet, use the following snippet of code. PHPExcel creates the link between the drawing and the worksheet:
					//$this->objDrawing->setWorksheet($this->ObjPHPExcel->getActiveSheet());

					$this->objDrawing->setCoordinates('D'.$this->row_cnt);

					$this->ObjPHPExcel->getActiveSheet()->getStyle('A'.$this->row_cnt)->applyFromArray($this->center);
					$this->ObjPHPExcel->getActiveSheet()->getStyle('B'.$this->row_cnt)->applyFromArray($this->center);
					$this->ObjPHPExcel->getActiveSheet()->getStyle('C'.$this->row_cnt)->applyFromArray($this->center);
					$this->row_cnt++;
				}
			}

		}

		public function get_xls_price(){
			include('PHPExcel.php');
			include('PHPExcel/Writer/Excel5.php');

			$this->ObjPHPExcel = new PHPExcel();

			$this->ObjPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
			$this->ObjPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(14);
			$this->ObjPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);

			$this->center = array(
			    'alignment'=>array(
				'vertical'=>PHPExcel_Style_Alignment::VERTICAL_CENTER
			    )
			);
			$this->row_cnt = 1;

			//$cat_id = getRequest('cat_id');
			$cat_id = 253;

			$this->fill_price($cat_id);

			$objWriter = new PHPExcel_Writer_Excel5($this->ObjPHPExcel);
			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="price.xls"');
			header('Cache-Control: max-age=0');
			$objWriter->save('php://output');
		}

		public function getPriceLink(){
			if(permissionsCollection::getInstance()->isAdmin()){
				$html = '<div class="get_price">
					<a title="Скачать прайс лист" alt="Скачать прайс лист" href="/catalog/get_xls_price/">Скачать прайс лист</a>
				</div>';
				return $html;
			}else{
				return false;
			}
		}

		public function similarGoods($page_id, $template = 'similar', $limit = false, $title = false){
                    if(!$page_id){
                        return false;
                    }
                    //$cmsController = cmsController::getInstance();
                    $hierarchy = umiHierarchy::getInstance();
                    $typesCollection = umiObjectTypesCollection::getInstance();

                    $typeId = $typesCollection->getBaseType('catalog', 'object');           // Тип объекта катагога
                    $pageTypeId = $hierarchy->getElement($page_id)->getObjectTypeId();      // Тип переданной страницы

                    $typeId = $typesCollection->getParentClassId($typeId);
                    if($typeId != $pageTypeId){
                        return false;
                    }

                    $per_page = ($limit) ? $limit : $this->per_page;
                    if(!getRequest('p')){
                        $curr_page = 0;
                    }else{
                        $curr_page = (int)getRequest('p');
                    }

                    $curr_page = $curr_page+1;

                    list($template_block, $template_block_empty, $template_line) = def_module::loadTemplates("/catalog/".$template, "objects_block", "objects_block_empty", "objects_block_line");

                    $item = $hierarchy->getElement($page_id);
                    $similar_goods = $item->getValue('recommended_items');

                    shuffle($similar_goods);

                    $similar_goods = array_slice($similar_goods, 0, $limit);

                    $block_arr = array();
                    $lines = array();

                    $total = count($similar_goods);

                    if($total == 0){
                        $title = '';
                    }

                    foreach($similar_goods as $product){
                        $pageTypeId = $hierarchy->getElement($product->id)->getObjectTypeId();	// Тип переданной страницы

                        if($product->getValue('photo')){
                            $line_arr = Array();
                            $line_arr['attribute:id'] = $product->id;
                            $line_arr['void:alt_name'] = $product->getAltName();
                            $line_arr['attribute:link'] = umiHierarchy::getInstance()->getPathById($product->id);
                            $line_arr['xlink:href'] = "upage://" . $product->id;
                            $line_arr['node:text'] = $product->getName();
                            $lines[] = $this->parseTemplate($template_line, $line_arr, $product->id);
                        }
                    }
                    $line_arr['block_title'] = '<strong>'.$title.'</strong>';
                    $line_arr['lines'] = $lines;

                    return $this->parseTemplate($template_block, $line_arr, $page_id);
		}

		public function setReminder(){
                    $id = getRequest('id');
                    $email = getRequest('email');
                    $obj = umiHierarchy::getInstance()->getElement($id)->getObject();
                    if(trim($obj->getValue('waiting')) == ''){
                        $obj->setValue('waiting',$email.'|');
                    }else{
                        $waiting = explode(',',$obj->getValue('waiting'));
                        $waiting[] = $email;
                        $obj->setValue('waiting',implode('|',$waiting));
                    }
                    $obj->commit();
                    exit;
		}

                /* custom поле вывода товаров каталога с сортировкой по доступности товаров */
                /*public function customGetObjectsList($template = "default", $path = false, $limit = false, $ignore_paging = false, $i_need_deep = 0, $field_id = false, $asc = true) {*/
                public function customGetObjectsList($template = "default", $path = false, $limit = false, $ignore_paging = false, $i_need_deep = 0, $field_id = false, $asc = false) {
                        if(!$template) $template = "default";
                        if (!$i_need_deep) $i_need_deep = intval(getRequest('param4'));
                        if (!$i_need_deep) $i_need_deep = 0;
                        $i_need_deep = intval($i_need_deep);
                        if ($i_need_deep === -1) $i_need_deep = 100;

                        $path_dir = CURRENT_WORKING_DIR.'/files/category_items';
                        if(!is_dir($path_dir))
                        {
                            mkdir($path_dir, 0777, TRUE);
                        }
                        
                        $input_param = $template.';'.$path.';'.$limit.';'.$ignore_paging.';'.$i_need_deep.';'.$field_id.';'.$asc;
                        $path_file = $path_dir.'/'.sha1(base64_encode($input_param.';'.json_encode($_REQUEST))).'.txt';
                        $time = 300;
                        $is_file = is_file($path_file);
                        
                        if($is_file && time() <= (filemtime($path_file) + $time))
                        {
                            return json_decode(file_get_contents($path_file), TRUE);
                        }
                        
                        $hierarchy = umiHierarchy::getInstance();

                        list($template_block, $template_block_empty, $template_block_search_empty, $template_line) = def_module::loadTemplates("catalog/".$template, "objects_block", "objects_block_empty", "objects_block_search_empty", "objects_block_line");

                        $hierarchy_type_id = umiHierarchyTypesCollection::getInstance()->getTypeByName("catalog", "object")->getId();

                        $category_id = $this->analyzeRequiredPath($path);

                        if($category_id === false && $path != KEYWORD_GRAB_ALL) {
                            throw new publicException(getLabel('error-page-does-not-exist', null, $path));
                        }

                        $category_element = $hierarchy->getElement($category_id);

                        $per_page = ($limit) ? $limit : $this->per_page;
                        $curr_page = getRequest('p');
                        if($ignore_paging) $curr_page = 0;

                        $sel = new umiSelection;
                        $sel->setElementTypeFilter();
                        $sel->addElementType($hierarchy_type_id);

                        if($path != KEYWORD_GRAB_ALL) {
                            $sel->setHierarchyFilter();
                            $sel->addHierarchyFilter($category_id, $i_need_deep);
                        }

                        $sel->setPermissionsFilter();
                        $sel->addPermissions();

                        $hierarchy_type = umiHierarchyTypesCollection::getInstance()->getType($hierarchy_type_id);
                        $type_id = umiObjectTypesCollection::getInstance()->getBaseType($hierarchy_type->getName(), $hierarchy_type->getExt());


                        if($path === KEYWORD_GRAB_ALL) {
                            $curr_category_id = cmsController::getInstance()->getCurrentElementId();
                        } else {
                            $curr_category_id = $category_id;
                        }


                        if($path != KEYWORD_GRAB_ALL) {
                            $type_id = $hierarchy->getDominantTypeId($curr_category_id, $i_need_deep, $hierarchy_type_id);
                        }

                        if(!$type_id) {
                            $type_id = umiObjectTypesCollection::getInstance()->getBaseType($hierarchy_type->getName(), $hierarchy_type->getExt());
                        }


                        if($type_id) {
                            $this->autoDetectOrders($sel, $type_id);
                            $this->autoDetectFilters($sel, $type_id);

                            if($this->isSelectionFiltered) {
                                $template_block_empty = $template_block_search_empty;
                                $this->isSelectionFiltered = false;
                            }
                        } else {
                            $sel->setOrderFilter();
                            $sel->setOrderByName();
                        }

                        if($curr_page !== "all") {
                            $curr_page = (int) $curr_page;
                            //$sel->setLimitFilter();
                            //$sel->addLimit($per_page, $curr_page);
                        }

                        $hierarchy_ord = array('5171');

                        // if($field_id && !in_array($category_id, $hierarchy_ord)) {
                        if($field_id) {

                            if (is_numeric($field_id)) {
                                $sel->setOrderByProperty($field_id, $asc);
                            } else {
                                if ($type_id) {
                                    $field_id = umiObjectTypesCollection::getInstance()->getType($type_id)->getFieldId($field_id);
                                    $field_id2 = umiObjectTypesCollection::getInstance()->getType($type_id)->getFieldId('price');
                                    if ($field_id) {

                                        $sel->setOrderByProperty($field_id, $asc);

                                        if ($field_id2) {
                                            $sel->setOrderByProperty($field_id2, 1);
                                        }

                                    } else {
                                        $sel->setOrderByOrd($asc);
                                    }
                                } else {
                                    $sel->setOrderByOrd($asc);
                                }
                            }
                        }
                        else {
                            $sel->setOrderByOrd($asc);
                        }


                        $result = umiSelectionsParser::runSelection($sel);
                        $total = umiSelectionsParser::runSelectionCounts($sel);

                        $unaviableElementsArray = array();

                        /* доступность */

                        foreach ($result as $key => $resultElementKey){
                            $resultElement = umiHierarchy::getInstance()->getElement($resultElementKey);
                            $unaviable = $resultElement->getValue('unaviable');
                            if($unaviable == 1 || $resultElement->getValue('common_quantity') <= 0){
                                $unaviableElementsArray[] = $result[$key];
                                unset($result[$key]);
                            }
                        }
                        $result = array_merge($result, $unaviableElementsArray);

                        $total = count($result);

                        $result = array_values($result);

                        $result = array_slice($result, (int)$per_page * $curr_page, (int)$per_page);

                        /* доступность */

                        if(($sz = sizeof($result)) > 0) {
                                $block_arr = Array();

                                $lines = Array();
                                for($i = 0; $i < $sz; $i++) {
                                    $element_id = $result[$i];
                                    $element = umiHierarchy::getInstance()->getElement($element_id);

                                    if(!$element) continue;

                                    $line_arr = Array();
                                    $line_arr['attribute:id'] = $element_id;
                                    $line_arr['attribute:alt_name'] = $element->getAltName();
                                    $line_arr['attribute:link'] = umiHierarchy::getInstance()->getPathById($element_id);
                                    $line_arr['xlink:href'] = "upage://" . $element_id;
                                    $line_arr['node:text'] = $element->getName();

                                    $lines[] = $this->parseTemplate($template_line, $line_arr, $element_id);

                                    $this->pushEditable("catalog", "object", $element_id);
                                    umiHierarchy::getInstance()->unloadElement($element_id);
                                }

                                $block_arr['subnodes:lines'] = $lines;
                                $block_arr['numpages'] = umiPagenum::generateNumPage($total, $per_page);
                                $block_arr['total'] = $total;
                                $block_arr['per_page'] = $per_page;
                                $block_arr['category_id'] = $category_id;

                                if($type_id) {
                                        $block_arr['type_id'] = $type_id;
                                }

                                $parse = $this->parseTemplate($template_block, $block_arr, $category_id);
                                file_put_contents($path_file, json_encode($parse));
                                return $parse;
                                //return $this->parseTemplate($template_block, $block_arr, $category_id);
                        } else {
                                $block_arr['numpages'] = umiPagenum::generateNumPage(0, 0);
                                $block_arr['lines'] = "";
                                $block_arr['total'] = 0;
                                $block_arr['per_page'] = 0;
                                $block_arr['category_id'] = $category_id;

                                return $this->parseTemplate($template_block_empty, $block_arr, $category_id);;
                        }

                }

                // Показ текста каталога только на первой страницы пагинации
                 public function showDescr($pageId = false) {
                    if(getRequest('p')){
                        return false;
                    }
					
					if(isset($_REQUEST['seo_filter_link_id'])) {
						$obj_id = $_REQUEST['seo_filter_link_id'];
						$obj = umiObjectsCollection::getInstance()->getObject($obj_id);
						if(is_object($obj)) {
							return $obj->getValue('content');
						}
					} else {
						$hierarchy = umiHierarchy::getInstance();
						$page = $hierarchy->getElement($pageId);
						return $page->descr;
					}

                    
                }


                /*
                    Вывод других товаров из категории
                */
                public function showAnotherCategoryItems($pageId = false, $template = 'surrounding_items', $limit = 25, $customHeader = false){

                    $path = CURRENT_WORKING_DIR.'/files/show_special_option_items';
                    if(!is_dir($path)){
                        mkdir($path, 0777, TRUE);
                    }
                    
                    $path_file = $path.'/another_'.sha1(base64_encode($pageId.';'.$template.';'.$limit.';'.$customHeader)).'.txt';
                    $is_file = is_file($path_file);
                    $time = 300;
                    if($is_file && time() <= (filemtime($path_file) + $time)){
                        return json_decode(file_get_contents($path_file), TRUE);
                    }
                    
                    if(!$pageId){
                        $pageId = getRequest('param0');
                    }

                    if(!$pageId){
                        return false;
                    }

                    list($template_block, $template_line, $template_empty_result) = $this->loadTemplates("catalog/".$template, "category_block", "objects_block", "category_block_empty");

                    $hierarchy = umiHierarchy::getInstance();
                    $page = $hierarchy->getElement($pageId);
                    $categoryPath = $hierarchy->getPathById($pageId);
                    $categoryPathArray = explode('/', $categoryPath);
                    $categoryPathArray = array_slice($categoryPathArray,0,-2);
                    $categoryPathArray[] = '';
                    $categoryPath = implode('/', $categoryPathArray);

                            
                    $pages = new selector('pages');
                    $pages->types('hierarchy-type')->name('catalog', 'object');
                    $pages->where('hierarchy')->page($categoryPath)->childs(3);
                    //$pages->limit(0,$limit*2);
                    $pages->order('rand');
                    
                    $result = array();
                    foreach($pages as $oPage){
                        if(!$this->availability($oPage->id)){
                            continue;
                        }else{
                            $result[] = $oPage;
                        }
                    }

                    $pages = array_slice($result, 0, $limit);
                    
                    
                    $i = 0;                 // счетчик товара в выборке
                    $lines = array();       // Массив для страниц
                    $block_arr = array();

                    $cnt = 0;               // Счетчик текущей страницы
                    foreach($pages as $objectPage){
                        if($objectPage->id == $pageId){
                            continue;
                        }
                        
                        $line_arr = Array();

                        $line_arr['void:num'] = ++$i;
                        $line_arr['attribute:id'] = $objectPage->id;
                        $line_arr['attribute:name'] = $objectPage->getName();
                        $line_arr['attribute:link'] = umiHierarchy::getInstance()->getPathById($objectPage->id);
                        $line_arr['attribute:photo'] = (string)$objectPage->photo;
                        $line_arr['xlink:href'] = "upage://" . $objectPage->id;

                        $lines[] = $this->parseTemplate($template_line, $line_arr, $objectPage->id);
                    }

                    if(!$customHeader){
                        $customHeader = 'Популярные товары';
                    }

                    
                    $block_arr['attribute:headerBlock'] = $customHeader;
                    $block_arr['void:lines'] = $lines;
                    $block_arr['total'] = count($pages);

                    
                    $parse = $this->parseTemplate((count($pages) > 0 ? $template_block : $template_empty_result), $block_arr);
                    
                    file_put_contents($path_file, json_encode($parse));
                    
                    return $parse;

                }

                /**
                 * 
                 * @param type $optionsName массив опций, который надо учесть для показа позиций
                 * @param type $template    шаблон для отображения
                 * @param type $limit       лимит на выборку
                 * @param type $excludeDirecories   директории, которые не должны участвовать в выборке для показа
                 * @param type $debugMode   режим отладки. Время жизни кеша ставим в 0.
                 * @param type $customHeader   Произвольный заголовок. Иначе 'Новинки нашего магазина'
                 * @return type
                 */
                public function showSpecialOptionItems($optionsName = false, $template = 'surrounding_items', $limit = false, $excludeDirecoriesString = false, $debugMode = false, $customHeader = false)
                {
                    $path = CURRENT_WORKING_DIR.'/files/show_special_option_items';
                    if(!is_dir($path)){
                        mkdir($path, 0777, TRUE);
                    }
                    $path_file = $path.'/'.sha1(base64_encode($optionsName.';'.$template.';'.$limit.';'.$excludeDirecoriesString)).'.txt';
                    // Если включен режим отладки, то время жизни кеша выставляем в 0.

                    $is_file = is_file($path_file);
                    $time = 300;
                    if($is_file && time() <= (filemtime($path_file) + $time) && false == $debugMode){
                        return json_decode(file_get_contents($path_file), TRUE);
                    }
                    
                    if(!$optionsName){
                        return;
                    }
                    
                    list($template_block, $template_line, $template_empty_result) = $this->loadTemplates("catalog/".$template, "category_block", "objects_block", "category_block_empty");
                    
                    $hierarchy = umiHierarchy::getInstance();
                    
                    $ht_id = umiHierarchyTypesCollection::getInstance()->getTypeByName('catalog', 'object')->getId();
                    $ot_id = umiObjectTypesCollection::getInstance()->getTypeByHierarchyTypeId($ht_id);
                    $list_type_ids = umiObjectTypesCollection::getInstance()->getChildClasses($ot_id);
                    $list_type_ids[] = $ot_id;
                    
                    $connection = ConnectionPool::getInstance()->getConnection();
                    $query = 'Select distinct obj_f.id From cms3_object_fields obj_f, cms3_object_field_groups obj_fg, cms3_fields_controller fc 
                             Where obj_fg.type_id in('.implode(',', $list_type_ids).') and obj_f.name = "'.$connection->escape($optionsName).'" and obj_fg.id = fc.group_id 
                             and fc.field_id = obj_f.id';
                    $result = $connection->queryResult($query);
                    if($result->length() == 0)
                    {
                        $connection->close();
                        return;
                    }
                    
                    $mas_field_ids = array();
                    $result->setFetchType(IQueryResult::FETCH_ASSOC);
                    While($row = $result->fetch())
                    {
                        $mas_field_ids[] = $row['id'];
                    }
                    
                    $mas_exlude_ids = array();
                    if($excludeDirecoriesString)
                    {
                        $htc_id = umiHierarchyTypesCollection::getInstance()->getTypeByName('catalog', 'category')->getId();
                        $query = 'Select hr.child_id From cms3_hierarchy_relations hr, cms3_hierarchy h 
                                 Where hr.rel_id in('.$connection->escape($excludeDirecoriesString).') and h.id = hr.child_id and h.type_id = '.$htc_id;
                        $result = $connection->queryResult($query);
                        
                        if($result->length() > 0)
                        {
                            $result->setFetchType(IQueryResult::FETCH_ASSOC);
                            While($row = $result->fetch())
                            {
                                $mas_exlude_ids[] = $row['child_id'];
                            }
                        }
                    }
                    
                    $controller = cmsController::getInstance();
                    $domain = $controller->getCurrentDomain();
                    $lang = $controller->getCurrentLang();
                    $query = 'Select h.id
                             From cms3_hierarchy h, cms3_object_content oc 
                             Where h.type_id = '.$ht_id.' and h.is_active = 1 and h.is_deleted = 0 and h.domain_id = '.$domain->getId().' and h.lang_id = '.$lang->getId().' and 
                             '.(sizeof($mas_exlude_ids) > 0 ? 'h.rel not in('.implode(',', $mas_exlude_ids).') and ' : '').' oc.field_id in('.implode(',', $mas_field_ids).') and oc.obj_id = h.obj_id and oc.int_val = 1';
                    $result = $connection->queryResult($query);
                    
                    if($result->length() > 0)
                    {
                        $mas_ids = array();
                        $tmp_ids = array();
                        $result->setFetchType(IQueryResult::FETCH_ASSOC);
                        While($row = $result->fetch())
                        {
                            $tmp_ids[$row['id']] = $row['id'];
                        }
                        shuffle($tmp_ids);
                        
                        $pagesIds = array();
                        foreach($tmp_ids as $pageId){
                            if(!$this->availability($pageId)){
                                continue;
                            }else{
                                $pagesIds[] = $pageId;
                            }
                        }

                        $tmp_ids = $pagesIds;
                        
                        
                        $mas_ids = ($limit > 0) ? array_slice($tmp_ids, 0, $limit) : $tmp_ids;
                        
                        $total = sizeof($tmp_ids);
                        $i = 0;                 // счетчик товара в выборке
                        $lines = array();       // Массив для страниц
                        $block_arr = array();
                        $objectPage = '';

                        $cnt = 0;               // Счетчик текущей страницы
                        foreach($mas_ids as $key=>$page_id)
                        {
                            $objectPage = $hierarchy->getElement($page_id);
                            if(!is_object($objectPage))
                            {
                                continue;
                            }
                            
                            $line_arr = Array();

                            $line_arr['void:num'] = ++$i;
                            $line_arr['attribute:id'] = $page_id;
                            $line_arr['attribute:name'] = $objectPage->getName();
                            $line_arr['attribute:link'] = $hierarchy->getPathById($page_id);
                            $line_arr['attribute:photo'] = (string)$objectPage->getValue('photo');
                            $line_arr['xlink:href'] = "upage://" . $page_id;
                            
                            $lines[] = $this->parseTemplate($template_line, $line_arr, $page_id);
                        }
                        
                        if(!$customHeader){
                            $customHeader = 'Новинки нашего магазина';
                        }
                        
                        if(sizeof($lines) > 0)
                        {
                            $block_arr['attribute:headerBlock'] = $customHeader;
                            $block_arr['void:lines'] = $lines;
                            $block_arr['total'] = $total;
                            $parse = $this->parseTemplate($template_block, $block_arr);
                            
                            file_put_contents($path_file, json_encode($parse));
                            $connection->close();
                            return $parse;
                        }
                        else
                        {
                            $connection->close();
                            return $this->parseTemplate($template_empty_result, array());
                        }
                    }
                    else
                    {
                        $connection->close();
                        return $this->parseTemplate($template_empty_result, array());
                    }
                }

                /* возврат имени ('названия') объекта*/
                public function getElementName($pageId){
                    $hierarchy = umiHierarchy::getInstance();
                    if(!$pageId){
                        return false;
                    }

                    $pageElement = $hierarchy->getElement($pageId);
                    $elementName = $pageElement->getName();
                    return $elementName;
                }

                public function customShowFilter($pageId){
                    $hierarchy = umiHierarchy::getInstance();
                    $typesCollection = umiObjectTypesCollection::getInstance();
                    $categoryTypeId = $typesCollection->getBaseType('catalog', 'category');

                    $categorySubTypeId = $typesCollection->getSubTypesList($categoryTypeId);

                    if($categorySubTypeId){
                        $categorySubTypeId[] = $categoryTypeId;
                    }else{
                        $categorySubTypeId = array();
                        $categorySubTypeId[] = $categoryTypeId;
                    }

                    $pageTypeId = $hierarchy->getElement($pageId)->getObjectTypeId();

                    if(in_array($pageTypeId, $categorySubTypeId)){
                        if($hierarchy->getElement($pageId)->getValue('dont_show_filter')){
                            return false;
                        }
                    }
                    
                    $ht_id = umiHierarchyTypesCollection::getInstance()->getTypeByName('catalog', 'object')->getId();
                    $connection = ConnectionPool::getInstance()->getConnection();
                    $query = 'Select o.type_id From cms3_hierarchy_relations hr, cms3_hierarchy h, cms3_objects o Where hr.rel_id = '.$pageId.' and 
                             hr.child_id = h.id and h.type_id = '.$ht_id.' and h.obj_id = o.id limit 0, 1';
                    $result = $connection->queryResult($query);
                    $result->setFetchType(IQueryResult::FETCH_ASSOC);
                    $row = $result->fetch();
                    $connection->close();
                    if($row['type_id'] == 318)
                    {
                        return "%catalog search({$pageId},'catalog_option_props opcionnye_svojstva_uglej opcionnye_svojstva_dlya_tabakov opcionnye_svojstva_aksessuarov', 'search', %catalog custom_getDominantTypeId({$pageId})%)%";
                    }

                    return "%catalog search({$pageId},'cenovye_svojstva catalog_option_props opcionnye_svojstva_uglej opcionnye_svojstva_dlya_tabakov opcionnye_svojstva_aksessuarov', 'search', %catalog custom_getDominantTypeId({$pageId})%)%";
                    $permissions = permissionsCollection::getInstance();
                    if($permissions->isAdmin()){
                        return "%catalog search({$pageId},'cenovye_svojstva catalog_option_props opcionnye_svojstva_uglej opcionnye_svojstva_dlya_tabakov opcionnye_svojstva_aksessuarov', 'search', %catalog custom_getDominantTypeId({$pageId})%)%";
                    }else{
                        return FALSE;
                    }
                }
                
                public function showSortParam($id = 0)
                {
                    $sort = '<a href="?order_filter[default]=0">По умолчанию</a> | <a href="?&order_filter[price]=1">Цене</a> | <a href="?&order_filter[name]=1">Названию</a>';
                    
                    if($id > 0)
                    {
                        $ht_id = umiHierarchyTypesCollection::getInstance()->getTypeByName('catalog', 'object')->getId();
                        $connection = ConnectionPool::getInstance()->getConnection();
                        $query = 'Select o.type_id From cms3_hierarchy_relations hr, cms3_hierarchy h, cms3_objects o Where hr.rel_id = '.$id.' and 
                                 hr.child_id = h.id and h.type_id = '.$ht_id.' and h.obj_id = o.id limit 0, 1';
                        $result = $connection->queryResult($query);
                        $result->setFetchType(IQueryResult::FETCH_ASSOC);
                        $row = $result->fetch();
                        $connection->close();
                        if($row['type_id'] == 318)
                        {
                            $sort = '<a href="?order_filter[default]=0">По умолчанию</a> | <a href="?&order_filter[name]=1">Названию</a>';
                        }
                    }
                    
                    return $sort;
                }

                public function custom_getDominantTypeId($categoryId) {
                    $pages = new selector('pages');
                    $pages->types('hierarchy-type')->name('catalog', 'object');
                    $pages->where('hierarchy')->page($categoryId)->childs(4);

                    $oArray = array();

                    foreach ($pages as $page){
                        $objectTypeId = $page->getObjectTypeId();
                        if(!isset($oArray[$objectTypeId])){
                            $oArray[$objectTypeId] = 0;
                        }
                        $oArray[$objectTypeId]++;
                    }

                    arsort($oArray);
                    reset($oArray);

                    return key($oArray);
                }

                public function getSubcategoryTitle($pageId){
                    $hierarchy = umiHierarchy::getInstance();
                    if(!$pageId){
                        return false;
                    }

                    $pageElement = $hierarchy->getElement($pageId);
                    if($pageElement->getValue('subcategorycaption') && $pageElement->getValue('subcategorycaption') != ''){
                        return $pageElement->getValue('subcategorycaption');
                    }else{
                        return 'Разделы';
                    }


                }
                
                /*
                 * Метод возвращает доступность или недоступноть товара
                 */
                public function availability($pageId = false){
                    if(!$pageId){
                        return false;
                    }
                    
                    $hierarchy = umiHierarchy::getInstance();
                    $pageElement = $hierarchy->getElement($pageId);
                    if($pageElement instanceof umiHierarchyElement){
			$typesCollection = umiObjectTypesCollection::getInstance();
			$objectId = $typesCollection->getBaseType('catalog', 'object');
                        //if($pageElement->getObjectTypeId() == $objectId){
                            // Товар отмечен, как временно недоступный
                            if($pageElement->unaviable){
                                return false;
                            }
                            
                            if($pageElement->getValue('common_quantity') <= 0){
                                return false;
                            }
                            
                            return true;
                        //}
                    }else{
                        return false;
                    }
                }
	}