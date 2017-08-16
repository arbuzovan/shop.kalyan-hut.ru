<?php
	class custom extends def_module {
		public function cms_callMethod($method_name, $args) {
			return call_user_func_array(Array($this, $method_name), $args);
		}

		public function __call($method, $args) {
			throw new publicException("Method " . get_class($this) . "::" . $method . " doesn't exists");
		}
		public function calcDiscount($newPrice, $oldPrice) {
			return round($newPrice/$oldPrice * 100, 2);
		}
		public function getPriceRange() {
			$arr = array();
			$pages = new selector('pages');
			$pages->types('hierarchy-type')->name('catalog', 'object');
			$pages->where('exclude_from_slider')->isnull(true);
			$pages->order('price')->asc();
			$pages->limit(0,1);
			foreach ($pages as $page) {
				$arr['min_price'] = $page->getValue('price');
			}
			$pages = new selector('pages');
			$pages->types('hierarchy-type')->name('catalog', 'object');
			$pages->where('exclude_from_slider')->isnull(true);
			$pages->order('price')->desc();
			$pages->limit(0,1);
			foreach ($pages as $page) {
				$arr['max_price'] = $page->getValue('price');
			}
			return $arr;
		}
		//TODO: Write your own macroses here
		public function filter() {
			$category_id= getRequest('category_id');
			$price_from = getRequest('price_from');
			$price_to   = getRequest('price_to');
			$sex	    = getRequest('sex');
			$povod      = getRequest('povod');
			$like	    = getRequest('search_string');
			$limit	    = getRequest('limit');
			$p 	    = getRequest('p');
			$order_by   = getRequest('sort_by');
			$order	    = getRequest('sort');
			$hot	    = getRequest('hot');
			$new        = getRequest('new');

			$pages = new selector('pages');

			$pages->types('hierarchy-type')->name('catalog', 'object');

			if($category_id) $pages->where('hierarchy')->page($category_id)->childs(99);
			if($sex)   $pages->where('sex')->equals($sex);
			if($povod) $pages->where('povod')->equals($povod);
			if($price_from)
				   $pages->where('price')->eqmore($price_from);
			if($price_to)
				   $pages->where('price')->eqless($price_to);

			if($like) $pages->where('*')->ilike('%'.$like.'%');
			if($new)  $pages->where('new_offers')->equals(1);
			if($hot)  $pages->where('best_offers')->equals(1);

			if(!$limit) $limit = 10;
			if(!$p) $p = 0;

			if($order_by)
				if($order) $pages->order($order_by)->asc();
				else $pages->order($order_by)->desc();

			$pages->limit($p*$limit, $limit);

			$XmlItem = array();
			$Xml     = array();

			foreach($pages as $item) {
				$XmlItem['attribute:id']   = $item->id;
				$XmlItem['node:name'] = $item->name;
				$XmlItem['attribute:alt_name'] = $item->getAltName();
				$XmlItem['attribute:price']= $item->getValue('price');
				$XmlItem['attribute:link'] = umiHierarchy::getInstance()->getPathById($item->id);
				$XmlItem['xlink:href'] = "upage://" . $item->id;
				$Xml['subnodes:lines'][] = $XmlItem;
			}
			$Xml['total']=$pages->length;
			$Xml['category_id']=$category_id;


			return self::parseTemplate(false, $Xml);
		}
		//TODO: Write here your own macroses
		public function rating($element_id, $mark='0') {
			$hierarchy = umiHierarchy::getInstance();

			$object = $hierarchy->getElement($element_id);

			$xsl = array();

			$xsl['rating'] = $object->getValue("rating");
			$xsl['votes'] = $object->getValue("votes");
			$xsl['sum'] = $object->getValue("sum41");
			$xsl['element_id'] = $element_id;
			$xsl['mark'] = $mark;

			//if($mode == 'do') {
				if($mark > 0 && $mark <= 5 && !isset($_COOKIE['tovar'.$element_id])) {
					$new_sum = $xsl['sum'] + $mark;
					$new_votes = $xsl['votes'] + 1;
					$new_rating = $new_sum / $new_votes;

					$object->setValue("rating", $new_rating);
					$object->setValue("votes", $new_votes);
					$object->setValue("sum41", $new_sum);

					$object->commit();

					setcookie('tovar'.$element_id, $mark, time()+(3600*24*365));

					$xsl['rating'] = $new_rating;
					$xsl['votes'] = $new_votes;
					$xsl['sum'] = $new_sum;
				}
			//}
			return $this->parseTemplate(null, $xsl);
			//return $xsl;
		}

                public function slider_2($page_id = 457){
                    $hierarchy = umiHierarchy::getInstance();
                    $slider_pages = $hierarchy->getChilds($page_id);

                    if(!$page_id){
                        return '';
                    }else{
                        $html = '<div class="slider2">';

                        $currTime = getdate();  // Текущее время для выборочного показа по времени
                        
                        if(count($slider_pages) > 0){
                            $html .= '<div class="h1text s i">Популярные товары</div>';
                            if(count($slider_pages) > 3){
                                $html .= '<a class="arr" onclick="slide2();return false" href=""><img alt="" src="/images/slider2/l.png"></a>';
                            }
                            $html .= '<div class="slide"><ul>';
                            foreach ($slider_pages as $key => $page_id) {
                                

                                $page = $hierarchy->getElement($key);

                                // Если у слайдера указаны часы, когда не надо показывать слайд
                                if($page->timeoff > 0){
                                    $offHoursArray = array();   // Массив часов, когда слайд выключен
                                    foreach ($page->timeoff as $timeId){
                                        $hourObjectArray = explode(':',$oCollection->getObject($timeId)->name);
                                        $hour = $hourObjectArray[0];
                                        $offHoursArray[] = $hour;
                                    }

                                    var_dump($offHoursArray);
                                    echo '<br>';
                                    echo $currTime['hours'];
                                    
                                    if(in_array($currTime['hours'], $offHoursArray)){
                                        continue;
                                    }
                                }
                                
                                
                                $html .= '<li>';
                                $html .= '<a href="'.$hierarchy->getPathById($page->id).'">';
                                $html .= '<img alt="'.$page->getValue('h1').'" src="'.$page->getValue('photo').'">';
                                $html .= '</a>';
                                $html .= '<span class="b i pr">'.$page->getValue('price').'</span>';
                                $html .= '<span class="i rub">Р<span>&ndash;</span></span><br><b><span class="i">'.$page->getValue('h1').'</span></b>';
                                $html .= '</li>';
                            }
                            $html .= '</ul></div>';
                            if(count($slider_pages) > 3){
                                $html .= '<a class="arr" onclick="slide2(true);return false" href=""><img alt="" src="/images/slider2/r.png"></a>';
                            }
                        }


                        $html .= '</div>';
                    }
                    return $html;
                }

		public function makeThumbnail($path, $width, $height, $template = "default", $returnArrayOnly = false, $fixHeight = false, $alt_text = '') {
			if(!$template){
				$template = "default";
			}

			$thumbs_path = "./images/cms/thumbs/";


			$image = new umiImageFile($path);
			$file_name = $image->getFileName();
			$file_ext = $image->getExt();
			$thumbPath = sha1($image->getDirName());

			if (!is_dir($thumbs_path.$thumbPath)) {
				mkdir($thumbs_path.$thumbPath, 0755);
			}

			$file_ext = strtolower($file_ext);
			$allowedExts = Array('gif', 'jpeg', 'jpg', 'png', 'bmp');
			if(!in_array($file_ext, $allowedExts))
				return "";

			$file_name = substr($file_name, 0, (strlen($file_name) - (strlen($file_ext) + 1)) );
			$file_name_new = $file_name . "_" . $width . "_" . $height . "." . $file_ext;
			$path_new = $thumbs_path .$thumbPath."/". $file_name_new;

			if(!file_exists($path_new) || filemtime($path_new) < filemtime($path)) {
				if(file_exists($path_new)) {
					unlink($path_new);
				}
				$width_src = $image->getWidth();
				$height_src = $image->getHeight();

				if($width_src <= $width && $height_src <= $height) {
					copy($path, $path_new);
					$real_width = $width;
					$real_height = $height;
				} else {

					if ($width == "auto" && $height == "auto"){
						$real_height = $height_src;
						$real_width = $width_src;
					}elseif ($width == "auto" || $height == "auto"){
						if ($height == "auto"){
							$real_width = (int) $width;
							$real_height = (int) round($height_src * ($width / $width_src));
						}elseif($width == "auto"){
							$real_height = (int) $height;
							$real_width = (int) round($width_src * ($height / $height_src));
						}
					}else{
						//для фона
						if($fixHeight){
							$real_width = $width;// для макс заданного контура
							$real_height = $height;// для макс заданного контура
						}

						//определяем размеры картинки
						if($width_src > $height_src) {//горизонт
							$real_width = $width;
							$real_height = (int) round($height_src * ($width / $width_src));
							if($real_height > (int) $height){
								$real_height = (int) $height;
								$real_width = (int) round($width_src * ($real_height / $height_src));
							}
						}
						else{
							$real_height = (int) $height;
							$real_width = (int) round($width_src * ($height / $height_src));
							if($real_width > $width){
								$real_width = (int) $width;
								$real_height = (int) round($height_src * ($real_width / $width_src));
							}
						}
					}

					if($fixHeight){
						$thumb = imagecreatetruecolor($width, $height);//width для макс заданного контура
					}
					else{
						$thumb = imagecreatetruecolor($real_width, $real_height);
					}

					if($image->getExt() == "gif") {
						$source = imagecreatefromgif($path);

						$thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
						imagefill($thumb, 0, 0, $thumb_white_color);
						imagecolortransparent($thumb, $thumb_white_color);

						imagealphablending($source, TRUE);
						imagealphablending($thumb, TRUE);
					} else if($image->getExt() == "png") {
						$source = imagecreatefrompng($path);

						$thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
						imagefill($thumb, 0, 0, $thumb_white_color);
						imagecolortransparent($thumb, $thumb_white_color);

						imagealphablending($source, TRUE);
						imagealphablending($thumb, TRUE);
					} else {
						//echo $path;
						$source = imagecreatefromjpeg($path);
						$thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
						imagefill($thumb, 0, 0, $thumb_white_color);
						imagecolortransparent($thumb, $thumb_white_color);

						imagealphablending($source, TRUE);
						imagealphablending($thumb, TRUE);
					}

					//определяем координаты по середине полотна
					$dstY = 0;
					$dstX = 0;
					if($fixHeight){
						$dstX = round(($width - $real_width)/2);//для макс контура
						$dstY = round(($height - $real_height)/2);
					}

					imagecopyresampled($thumb, $source, $dstX, $dstY, 0, 0, $real_width, $real_height, $width_src, $height_src);

					if($image->getExt() == "png") {
						imagepng($thumb, $path_new);
					} else if($image->getExt() == "gif") {
						imagegif($thumb, $path_new);
					} else {
						imagejpeg($thumb, $path_new, 75);
					}
				}
			}

			//Parsing
			$value = new umiImageFile($path_new);

			$arr = Array();
			$arr['size'] = $value->getSize();
			$arr['filename'] = $value->getFileName();
			$arr['filepath'] = $value->getFilePath();
			$arr['src'] = $value->getFilePath(true);
			$arr['ext'] = $value->getExt();

			$arr['width'] = $value->getWidth();
			$arr['height'] = $value->getHeight();

			$arr['template'] = $template;

			$arr['alt_text'] = $alt_text;

			if(cmsController::getInstance()->getCurrentMode() == "admin") {
				$arr['src'] = str_replace("&", "&amp;", $arr['src']);
			}

			if($returnArrayOnly) {
				return $arr;
			} else {
				list($tpl) = def_module::loadTemplates("tpls/thumbs/{$template}.tpl", "image");
				return def_module::parseTemplate($tpl, $arr);
			}
		}

		public function makeThumbnail1($path, $width, $height, $template = "default", $returnArrayOnly = false, $fixHeight = false, $alt_text = '') {

                    if(!$template){
                        $template = "default";
                    }

                    $thumbs_path = CURRENT_WORKING_DIR."/images/cms/thumbs/";
                    $path = CURRENT_WORKING_DIR.$path;

                    $image = new umiImageFile($path);
                    $file_name = $image->getFileName();
                    $file_ext = $image->getExt();
                    $thumbPath = sha1($image->getDirName());

                    if (!is_dir($thumbs_path.$thumbPath)) {
                        mkdir($thumbs_path.$thumbPath, 0755);
                    }

                    $file_ext = strtolower($file_ext);
                    $allowedExts = Array('gif', 'jpeg', 'jpg', 'png', 'bmp');
                    if(!in_array($file_ext, $allowedExts)){
                        return "";
                    }

                    $file_name = substr($file_name, 0, (strlen($file_name) - (strlen($file_ext) + 1)) );
                    $file_name_new = $file_name . "_" . $width . "_" . $height . "." . $file_ext;
                    $path_new = $thumbs_path .$thumbPath."/". $file_name_new;

                    if(!file_exists($path_new) || filemtime($path_new) < filemtime($path)) {
                        if(file_exists($path_new)) {
                            unlink($path_new);
                        }
                        $width_src = $image->getWidth();
                        $height_src = $image->getHeight();

                        if($width_src <= $width && $height_src <= $height) {
                            copy($path, $path_new);
                            $real_width = $width;
                            $real_height = $height;
                        } else {

                        if ($width == "auto" && $height == "auto"){
                            $real_height = $height_src;
                            $real_width = $width_src;
                        }elseif ($width == "auto" || $height == "auto"){
                            if ($height == "auto"){
                                $real_width = (int) $width;
                                $real_height = (int) round($height_src * ($width / $width_src));
                            }elseif($width == "auto"){
                                $real_height = (int) $height;
                                $real_width = (int) round($width_src * ($height / $height_src));
                            }
                        }else{
                            //для фона
                            if($fixHeight){
                                $real_width = $width;// для макс заданного контура
                                $real_height = $height;// для макс заданного контура
                            }

                            //определяем размеры картинки
                            if($width_src > $height_src) {//горизонт
                                $real_width = $width;
                                $real_height = (int) round($height_src * ($width / $width_src));
                                if($real_height > (int) $height){
                                    $real_height = (int) $height;
                                    $real_width = (int) round($width_src * ($real_height / $height_src));
                                }
                            }
                            else{
                                $real_height = (int) $height;
                                $real_width = (int) round($width_src * ($height / $height_src));
                                if($real_width > $width){
                                    $real_width = (int) $width;
                                    $real_height = (int) round($height_src * ($real_width / $width_src));
                                }
                            }
                        }

                        if($fixHeight){
                            $thumb = imagecreatetruecolor($width, $height);//width для макс заданного контура
                        }
                        else{
                            $thumb = imagecreatetruecolor($real_width, $real_height);
                        }

                        if($image->getExt() == "gif") {
                            $source = imagecreatefromgif($path);

                            $thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
                            imagefill($thumb, 0, 0, $thumb_white_color);
                            imagecolortransparent($thumb, $thumb_white_color);

                            imagealphablending($source, TRUE);
                            imagealphablending($thumb, TRUE);
                        } else if($image->getExt() == "png") {
                            $source = imagecreatefrompng($path);

                            $thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
                            imagefill($thumb, 0, 0, $thumb_white_color);
                            imagecolortransparent($thumb, $thumb_white_color);

                            imagealphablending($source, TRUE);
                            imagealphablending($thumb, TRUE);
                        } else {
                            $source = imagecreatefromjpeg($path);
                            $thumb_white_color = imagecolorallocate($thumb, 255, 255, 255);
                            imagefill($thumb, 0, 0, $thumb_white_color);
                            imagecolortransparent($thumb, $thumb_white_color);

                            imagealphablending($source, TRUE);
                            imagealphablending($thumb, TRUE);
                        }

                        //определяем координаты по середине полотна
                        $dstY = 0;
                        $dstX = 0;
                        if($fixHeight){
                            $dstX = round(($width - $real_width)/2);//для макс контура
                            $dstY = round(($height - $real_height)/2);
                        }

                        imagecopyresampled($thumb, $source, $dstX, $dstY, 0, 0, $real_width, $real_height, $width_src, $height_src);

                        if($image->getExt() == "png") {
                            imagepng($thumb, $path_new);
                        } else if($image->getExt() == "gif") {
                            imagegif($thumb, $path_new);
                        } else {
                            imagejpeg($thumb, $path_new, 75);
                        }
                    }
                    }

                    //Parsing
                    $value = new umiImageFile($path_new);

                    $arr = Array();
                    $arr['size'] = $value->getSize();
                    $arr['filename'] = $value->getFileName();
                    $arr['filepath'] = $value->getFilePath();
                    $arr['src'] = $value->getFilePath(true);
                    $arr['ext'] = $value->getExt();

                    $arr['width'] = $value->getWidth();
                    $arr['height'] = $value->getHeight();

                    $arr['template'] = $template;

                    $arr['alt_text'] = $alt_text;

                    if(cmsController::getInstance()->getCurrentMode() == "admin") {
                        $arr['src'] = str_replace("&", "&amp;", $arr['src']);
                    }

                    if(true == $returnArrayOnly) {
                        return $arr;
                    } else {
                        list($tpl) = def_module::loadTemplates("thumbs/{$template}.tpl", "image");
                        return def_module::parseTemplate($tpl, $arr);
                    }
		}

		public function freeDelivery($total_price){
                    if((int) $total_price < 5000){
                        $mod = 5000 - (int) $total_price;
                        $html = 'Для бесплатной доставки в течении дня (<b>в пределах МКАД</b>)<br /> Вам надо добрать в корзину товаров на сумму '.$mod.' руб.';
                        return $html;
                    }else{
                        return false;
                    }
		}

                public function getCount(){
                    $count = intval(getRequest('count'));
                    if ($count > 0){
                        return $count;
                    }
                    return '';
                }

                public function is_sel($count){
                    $count = intval($count);
                    $current_sel = intval(getRequest('count'));
                    if ($count == $current_sel){
                        return " selected";
                    }
                }

                /* Макрос сворачивает\разворачивает меню категории для каталога */
                public function ShowHideInCatalog($pageId) {
                    $hierarchy = umiHierarchy::getInstance();
                    $pageElement = $hierarchy->getElement($pageId);
                    if($pageElement instanceof umiHierarchyElement){
                        if($pageElement->getObject()->getTypeGUID() == 'catalog-category'){
                            return 'style="display:none;"';
                        }else{
                            return 'style="padding-left: 0px"';
                        }
                    }
                }

               public function makeRelCanonical($page_id = false){
 
					$current_page_id = cmsController::getInstance()->getCurrentElementId();
					$hierarchy_col = umiHierarchy::getInstance();
					$domain_col = domainsCollection::getInstance(); 
		 
					if($page_id == false){
						if($current_page_id == false){
							return '';
						}				
						if(defined('VIA_HTTP_SCHEME')){
							throw new publicException('cant get current element via HTTP SCHEME MODE');
						}
						$page_id = $current_page_id;
						$page = $hierarchy_col->getElement($page_id, true, true);
						$object_id = $page->getObjectId();
						$parents_ids = $hierarchy_col->getObjectInstances($object_id, true, true);
						if(count($parents_ids) == 0 || count($parents_ids) == 1 || $parents_ids[0] == $page_id){
							return '';
						}
						$first_parent_id = $parents_ids[0];			
						$path = $hierarchy_col->getPathById($first_parent_id);			
						$domain_id = $hierarchy_col->getElement($first_parent_id, true, true)->getDomainId();			
						$domain_name = $domain_col->getDomain($domain_id)->getHost();
		 
						return '<link rel="canonical" href="' . '//' . $domain_name . $path . '"/>';			
					}else{
						$page_id = intval($page_id);
						if($page_id == 0){
							throw new publicException('wrong id given');
						}
						$page = $hierarchy_col->getElement($page_id, true, true);
						if($page == false){
							throw new publicException('page with id = ' . $page_id . ' not found');
						}
						$object_id = $page->getObjectId();			
						$parents_ids = $hierarchy_col->getObjectInstances($object_id, true, true);		
						if(count($parents_ids) == 0 || count($parents_ids) == 1 || $parents_ids[0] == $page_id){
							return '';
						}
						$first_parent_id = $parents_ids[0];		
						$path = $hierarchy_col->getPathById($first_parent_id);	
						$domain_id = $hierarchy_col->getElement($first_parent_id, true, true)->getDomainId();	
						$domain_name = $domain_col->getDomain($domain_id)->getHost();
		 
						return '<link rel="canonical" href="' . '//' . $domain_name . $path . '"/>';
					}
				}
				//rel=canonical
				public function setcano() {
					$qu = strpos($_SERVER['REQUEST_URI'], '?');
					$ruri = substr($_SERVER['REQUEST_URI'], 0, $qu);

					if(!$ruri){
					$ruri=$_SERVER['REQUEST_URI'];
					}
					if(getRequest('p') > 0){
                                            $ruri = $ruri.'?p='.getRequest('p');
					}
                                        
					if(getRequest('search_string')){
                                            $ruri = $ruri.'?search_string='.getRequest('search_string');
					}
					
					return '<link rel="canonical" href="//shop.kalyan-hut.ru'.mb_strtolower($ruri).'"/>';
				}

        }