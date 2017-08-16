<?php
abstract class __custom_content {
    public function showLinkLogo($pageId = false){
        $ClickedLogo = '
                <a href="/">
                    <img width="280px" alt="Кальян-Хат" src="/images/logo.png" />
                </a>
                <a href="//shop.kalyan-hut.ru/rules/" id="licence_doc" rel="8996">Пользовательское соглашение</a>
            ';
        $noClickedLogo = '
                <span id="noClickedLogo">
                    <img width="280px" alt="Кальян-Хат" src="/images/logo.png" />
                    <br>
                    <a href="//shop.kalyan-hut.ru/rules/" id="licence_doc" rel="8996">Пользовательское соглашение</a>
                <span>
            ';
        if(!$pageId){
            return '
                <a href="/">
                    <img width="280px" alt="Кальян-Хат" src="/images/logo.png" />
                </a>
                <a href="//shop.kalyan-hut.ru/rules/" id="licence_doc" rel="8996">Пользовательское соглашение</a>                
                ';
        }
        
        $hierarchy = umiHierarchy::getInstance();
        $pageElement = $hierarchy->getElement($pageId);
        if($pageElement instanceof umiHierarchyElement){
            if($hierarchy->getElement($pageId)->getIsDefault()){
                return $noClickedLogo;
            }else{
                return $ClickedLogo;
            }
        }else{
            return $ClickedLogo;
        }
    }
	
    public function getHeader() {
        if(isset($_REQUEST['seo_filter_link_id'])) {
            $obj_id = $_REQUEST['seo_filter_link_id'];
            $obj = umiObjectsCollection::getInstance()->getObject($obj_id);
            if(is_object($obj)) {
                return $obj->getValue('h1');
            }
        } else {
            return '%header%';
        }
    }
    
    public function showDopText($pageId = false, $fldName = false){
        if(getRequest('p')){
            return false;
        }
		
		if(isset($_REQUEST['seo_filter_link_id'])) {
			$obj_id = $_REQUEST['seo_filter_link_id'];
			$obj = umiObjectsCollection::getInstance()->getObject($obj_id);
			if(is_object($obj)) {
				if($obj->getValue($fldName) && $obj->getValue($fldName) != ''){
					if($fldName == 'zagolovok'){
						return "<h2 umi:object-id='{$obj_id}' umi:field-name='zagolovok'>".$obj->getValue('zagolovok')."</h2>";
					}
					
					if($fldName == 'descripton2'){
						return "<div umi:object-id='{$obj_id}' umi:field-name='descripton2'>".$obj->getValue('descripton2')."</div>";
					}
				}
			}
		} else {
			$hierarchy = umiHierarchy::getInstance();
			$page = $hierarchy->getElement($pageId);
			
			if($page){
				if($page->getValue($fldName) && $page->getValue($fldName) != ''){
					if($fldName == 'zagolovok'){
						return "<h2 umi:element-id='{$pageId}' umi:field-name='zagolovok'>".$page->getValue('zagolovok')."</h2>";
					}
					
					if($fldName == 'descripton2'){
						return "<div umi:element-id='{$pageId}' umi:field-name='descripton2'>".$page->getValue('descripton2')."</div>";
					}
				}
			}
		}

        
        
    }
    
    /* Возврат контента страницы */
    public function getPageContent(){
        $pageId = getRequest('pageId');
        
        $hierarchy = umiHierarchy::getInstance();
        $page = $hierarchy->getElement($pageId);
        echo $page->getValue('content');
        exit;
    }
    
    //rel=canonical
    public function setcano() {
        $qu = strpos($_SERVER['REQUEST_URI'], '?');
        $ruri = substr($_SERVER['REQUEST_URI'], 0, $qu);
        if(!$ruri){
        $ruri=$_SERVER['REQUEST_URI'];
        }
        if($_GET['p']>0){
        $ruri = $ruri.'?p='.$_GET['p'];

        }
        if($_GET['search_string']){
        $ruri = $ruri.'?search_string='.$_GET['search_string'];

        }
        return mb_strtolower('');

    }

    public function showTabakContent($area = false){
        
        if(!$area){
            return;
        }
        
        $currTime = getdate();
        $notificationCode = '';

        $regedit = regedit::getInstance();
        switch($area){
            case 'basket':
                if($regedit->getVal('//modules/emarket/basketNotificationSwitcher') == true){
                    $timeStartArray = explode(':',$regedit->getVal('//modules/emarket/basketNotificationStart'));
                    $timeStopArray = explode(':',$regedit->getVal('//modules/emarket/basketNotificationStop'));
                    if($currTime['hours'] >= $timeStartArray[0] && $currTime['hours'] < $timeStopArray[0]){
                        $notificationCode = '<div>
                                    <h2>Уважаемые &nbsp;покупатели, обращаем Ваше внимание:</h2>
                                    <div style="font-size: 0.8em">
                                        <em>В соответствии с ФЗ N 15-ФЗ &laquo;Об охране здоровья граждан от воздействия окружающего табачного дыма..&raquo; мы не осуществляем дистанционную торговлю табачной и табакосодержащей продукцией физическим лицам. В заказах, включающих табачные изделия со способом получения: &laquo;доставка&raquo;, будут исключены табачные позиции. Табачные изделия заказанные на сайте, могут быть приобретены физическими лицами только в <a href="//shop.kalyan-hut.ru/contacts/">наших магазинах</a>.</em>
                                    </div>
                                </div>';
                    }else{
                        $notificationCode = '';
                    }
                }else{
                    $notificationCode = '';
                }
                
                break;
            case 'itemCart':
                if($regedit->getVal('//modules/emarket/itemCartNotificationSwitcher') == true){
                    $timeStartArray = explode(':',$regedit->getVal('//modules/emarket/itemCartNotificationStart'));
                    $timeStopArray = explode(':',$regedit->getVal('//modules/emarket/itemCartNotificationStop'));
                    if($currTime['hours'] >= $timeStartArray[0] && $currTime['hours'] < $timeStopArray[0]){    
                        $notificationCode = '<div style="font-size: 0.8em; font-style: italic; color: red;">
                            Доставка табакосодержащей продукции не осуществляется.<br>Приобрести табак можно в <a href="/contacts/" target="_blank">наших магазинах</a>.
                            </div>';
                    }else{
                        $notificationCode = '';
                    }
                }else{
                    $notificationCode = '';
                }
                break;
            case 'category':
                if($regedit->getVal('//modules/emarket/categoryNotificationSwitcher') == true){
                    $timeStartArray = explode(':',$regedit->getVal('//modules/emarket/categoryNotificationStart'));
                    $timeStopArray = explode(':',$regedit->getVal('//modules/emarket/categoryNotificationStop'));
                    if($currTime['hours'] >= $timeStartArray[0] && $currTime['hours'] < $timeStopArray[0]){
                        $notificationCode = '<div style="font-size: 0.8em; font-style: italic; color: red;">
                            Доставка табакосодержащей продукции не осуществляется.<br>Приобрести табак можно в <a href="/contacts/" target="_blank">наших магазинах</a>.
                            </div>';
                    }else{
                        $notificationCode = '';
                    }
                }else{
                    $notificationCode = '';
                }
                break;
            default :
                $notificationCode = '';
                break;
        }
        return $notificationCode;

        
        $showAlways = true;

        
        //if($currTime['hours'] < '19' && $currTime['hours'] > '5'){
        if($currTime['hours'] <= '14' && $currTime['hours'] >= '10'){
        //if($showAlways){
            switch($area){
                default :
                    return;
                    break;
            }
        }
    }
   
    
    public function __showTabakContent($area = false){
        if(!$area){
            return;
        }
        
        $currTime = getdate();
        
        $showAlways = true;

        
        //if($currTime['hours'] < '19' && $currTime['hours'] > '5'){
        if($currTime['hours'] <= '14' && $currTime['hours'] >= '10'){
        //if($showAlways){
            switch($area){
                case 'basket':
                    $htmlCode = '<div>
                                    <h2>Уважаемые &nbsp;покупатели, обращаем Ваше внимание:</h2>
                                    <div style="font-size: 0.8em">
                                        <em>В соответствии с ФЗ N 15-ФЗ &laquo;Об охране здоровья граждан от воздействия окружающего табачного дыма..&raquo; мы не осуществляем дистанционную торговлю табачной и табакосодержащей продукцией физическим лицам. В заказах, включающих табачные изделия со способом получения: &laquo;доставка&raquo;, будут исключены табачные позиции. Табачные изделия заказанные на сайте, могут быть приобретены физическими лицами только в <a href="//shop.kalyan-hut.ru/contacts/">наших магазинах</a>.</em>
                                    </div>
                                </div>';
                    return $htmlCode;
                    break;
                case 'itemCart':
                    $htmlCode = '<div style="font-size: 0.8em; font-style: italic; color: red;">
                                Доставка табакосодержащей продукции не осуществляется.<br>Приобрести табак можно в <a href="/contacts/" target="_blank">наших магазинах</a>.
                                </div>';
                    return $htmlCode;
                default :
                    return;
                    break;
            }
        }
    }
    
    public function showRedHelper(){
        //mail('arbuzovan@gmail.com', 'lazutchiki', cmsController::getCurrentModule());
        if(cmsController::getInstance()->getCurrentMethod() == 'cart'){
            return '';
        }else{
            return '
                <!-- RedHelper -->
                <script id="rhlpscrtg" type="text/javascript" charset="utf-8" async src="//web.redhelper.ru/service/main.js?c=kalyanhut"></script>
                <!--/Redhelper -->
            ';
        }
    }
    
    /* Вывод карты сайта */
    public function contentSitemap($template = "default", $max_depth = false, $root_id = false) {
        $hierarchy = umiHierarchy::getInstance();
        
//        if($hierarchy){
//            
//        }
        
        $iElementId = cmsController::getInstance()->getCurrentElementId();
        if($iElementId != 11239){
            $url = umiHierarchy::getInstance()->getPathById(11239, false);
            $this->redirect($url);
        }
        
        if (def_module::breakMe()){
            return;
        }

        if (!$max_depth){
            $max_depth = getRequest('param0');
        }

        if (!$max_depth)
            $max_depth = 4;

        if (!$root_id)
            $root_id = 0;

        if (cmsController::getInstance()->getCurrentMethod() == "sitemap") {
            def_module::setHeader("%content_sitemap%");
        }

        $site_tree = umiHierarchy::getInstance()->getChilds($root_id, false, true, $max_depth - 1);
        return self::gen_sitemap($template, $site_tree, $max_depth - 1);
    }

    public function gen_sitemap($template = "default", $site_tree, $max_depth) {
        $res = "";

        list($template_block, $template_item) = def_module::loadTemplates("content/sitemap/{$template}.tpl", "block", "item");
        list($template_block, $template_item) = def_module::loadTemplates("content/sitemap/{$template}.tpl", "block", "item");

        $block_arr = Array();
        $items = Array();
        if (is_array($site_tree)) {
            foreach($site_tree as $element_id => $childs) {
                if ($element = umiHierarchy::getInstance()->getElement($element_id)) {
                    if($element->disallowTextSitemap){
                        continue;
                    }
                    
                    $link = umiHierarchy::getInstance()->getPathById($element_id);
                    $update_time = $element->getUpdateTime();

                    $item_arr = Array();
                    $item_arr['attribute:id'] = $element_id;
                    $item_arr['attribute:link'] = $link;
                    $item_arr['attribute:name'] = $element->getObject()->getName();
                    $item_arr['xlink:href'] = "upage://".$element_id;
                    $item_arr['attribute:update-time'] = date('c', $update_time);

                    if ($max_depth > 0) {
                        $item_arr['nodes:items'] = $item_arr['void:sub_items'] = (sizeof($childs) && is_array($childs)) ? $this->gen_sitemap($template, $childs, ($max_depth - 1)) : "";
                    } else {
                        $item_arr['sub_items'] = "";
                    }

                    $items[] = def_module::parseTemplate($template_item, $item_arr, $element_id);

                    umiHierarchy::getInstance()->unloadElement($element_id);
                } else {
                    continue;
                }
            }
        }

        $block_arr['subnodes:items'] = $items;
        return def_module::parseTemplate($template_block, $block_arr, 0);
    }
    
    /* Дополнительное меню для главной страницы */
    public function showDopMenu($pageId = false){
        $hierarchy = umiHierarchy::getInstance();
        $pageElement = $hierarchy->getElement($pageId);
        $html = '';
        if($pageElement instanceof umiHierarchyElement && $hierarchy->getElement($pageId)->getIsDefault()){
            $html = '
                <div class="dopMenu">
                    <div class="h1text">Информация</div>
                    <ul>
                        <li>
                            <a href="/sale/">Акции</a>
                        </li>
                        <li>
                            <a href="/sitemap/">Карта сайта</a>
                        </li>
                        <li>
                            <a href="/stati/">Статьи</a>
                        </li>
                        <li>
                            <a href="/uslugi/">Услуги</a>
                        </li>
                    </ul>        
                </div>';   
        }
        return $html;
    }
    
    /* Функция показывает счетчик сделанных заказов */
    public function ordersCount(){
        $regedit = regedit::getInstance();
        if($regedit->getVal('//modules/emarket/counter_on') == true){
            $currentValue = $regedit->getVal('//modules/emarket/counter_current_value');
            $html = '<div id="counterHeader"></div>';
            $html .= '<div id="counterBlock">Мы исполнили<br><span id="counterValue">'.$currentValue.'</span> заказа</div>';
            return $html;
        }
        return;
    }
    
    /* Увеличивать счетик */
    public function ordersCountIterator(){
        $regedit = regedit::getInstance();
        if($regedit->getVal('//modules/emarket/counter_on') == true){
            $currentValue = $regedit->getVal('//modules/emarket/counter_current_value');
            $counterDeltaStart = $regedit->getVal('//modules/emarket/counter_delta_start');
            $counterDeltaEnd = $regedit->getVal('//modules/emarket/counter_delta_end');
            $counterIterator = rand($counterDeltaStart,$counterDeltaEnd);
            $newCounterValue = $currentValue + $counterIterator;
            $regedit->setVar('//modules/emarket/counter_current_value', $newCounterValue);
        }
    }
    
    public function cacheMenu($template = 'category_menu', $max_depth = 2, $pid = 253, $cur_id = 0)
    {
        $path = CURRENT_WORKING_DIR.'/files/menu_items';
        if(!is_dir($path))
        {
            mkdir($path, 0777, TRUE);
        }
        $path_file = $path.'/'.sha1(base64_encode($template.';'.$max_depth.';'.$pid.';'.$cur_id)).'.txt';
        $time = 900;
        $is_file = is_file($path_file);

        if($is_file && time() <= (filemtime($path_file) + $time))
        {
            return json_decode(file_get_contents($path_file), TRUE);
        }
        
        $content = cmsController::getInstance()->getModule('content');
        $menu = $content->menu($template, $max_depth, $pid);
        file_put_contents($path_file, json_encode($menu));
        
        return $menu;
    }
    
    public function getPageLastModified($page_id = 0)
    {
        $LastModified_unix = time();//strtotime(date("D, d M Y H:i:s", $time));
        $LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
        $IfModifiedSince = false;
        
        if(isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
        {
            $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
        }
        
        if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
        {
            $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
        }
        
        $cur_time = time();
        header('Expires: '.gmdate("D, d M Y H:i:s \G\M\T", $cur_time + (3600 * 24) ));
        header('Date: '.gmdate("D, d M Y H:i:s \G\M\T", $cur_time));
        //header('Vary: User-Agent');
        if($IfModifiedSince && $IfModifiedSince >= $LastModified_unix)
        {
            header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
            return '';
        }
        
        header('Last-Modified: '. $LastModified);
        return '<meta http-equiv="Last-Modified" content="'.$LastModified.'" />';
    }
    
    public function showVacancies($pageId = false, $template = 'vacancies') {
        if($pageId != 11128){
            return;
        }
        
        $oCollection = umiObjectsCollection::getInstance();
        $permissions = permissionsCollection::getInstance();

        $pages = new selector('pages');
        $pages->where('hierarchy')->page($pageId)->childs(1);

        $block_arr = Array();
        list($template_block, $template_item) = def_module::loadTemplates("content/".$template, "vacancies", "vacancy");

        foreach($pages as $objectPage){
            if($objectPage->getObjectTypeId() != 402){
                continue;
            }

            $line_arr = Array();

            $line_arr['void:num'] = ++$i;
            $line_arr['attribute:id'] = $objectPage->id;
            $line_arr['attribute:name'] = $objectPage->getName();
            $line_arr['attribute:vac_duties'] = $objectPage->vac_duties;
            
            $line_arr['attribute:vac_duties'] = $objectPage->vac_duties;
            $line_arr['attribute:vac_demands'] = $objectPage->vac_demands;
            $line_arr['attribute:vac_conditions'] = $objectPage->vac_conditions;
            $line_arr['attribute:vac_salary'] = $objectPage->vac_salary;
            $line_arr['attribute:vac_adress'] = $objectPage->vac_adress;
            $line_arr['attribute:vac_experience'] = $objectPage->vac_experience;
            
            
            $line_arr['attribute:link'] = umiHierarchy::getInstance()->getPathById($objectPage->id);
            $line_arr['xlink:href'] = "upage://" . $objectPage->id;

            $line_arr['attribute:prices'] = '<ul class="room_prices">';


            $lines[] = $this->parseTemplate($template_item, $line_arr, $objectPage->id);

        }

        $block_arr['subnodes:lines'] = $lines;
        return $this->parseTemplate($template_block, $block_arr);
   }
   
   public function getVacancyReplyForm($vacancyId = false) {
       
        if(!$vacancyId){
            $vacancyId = getRequest('vacancy_id');
        }
        
        if(!$vacancyId){
            return;
        }
       
       $html = '<form id="vacForm">';
       $html .= '<span class="require"><input id="vacRplFIO" name="vacRplFIO" class="vacancyReplyForm" placeholder="ФИО" /></span>';
       $html .= '<br>';
       $html .= '<span class=""><input id="vacRplVozrast" name="vacRplVozrast" class="vacancyReplyForm" placeholder="Возраст" /></span>';
       $html .= '<br>';
       $html .= '<span class=""><input id="vacRplPhone" name="vacRplPhone" class="vacancyReplyForm" placeholder="Телефон" /></span>';
       $html .= '<br>';
       $html .= '<span class="require"><input id="vacRplEmail" name="vacRplEmail" class="vacancyReplyForm" placeholder="Почта" /></span>';
       $html .= '<br>';
       $html .= '<span class=""><input id="vacRplVKLink" name="vacRplVKLink" class="vacancyReplyForm" placeholder="Ссылка на страницу в соц. сетях" />';
       $html .= '<br>';
       $html .= '<span class=""><input id="vacRplMetro" name="vacRplMetro" class="vacancyReplyForm" placeholder="Проживание (метро)" /></span>';
       $html .= '<br>';
       $html .= '<div class="">Гражданство:<span class=""></span></div>';
       $html .= '<span class=""><select id="vacRplCounty" name="vacRplCounty" class="vacancyReplyForm" placeholder="Гражданство: выбор из РФ/другая страна">';
       $html .= '<option value="russia">Россия</option>';
       $html .= '<option value="another">другая страна</option>';
       $html .= '</select></span>';
       $html .= '<br>';
       $html .= '<div class="">О себе:<span class="require"></span></div>';
       $html .= '<div style="font-size: 0.8em;">(напишите о себе/своем опыте работы, знаниях кальяна/vape, желаемый график работы и т.д.)</div>';
       $html .= '<textarea class="vacancyReplyForm" id="vacRplMessage" name="vacRplMessage"></textarea>';
       $html .= '<br>';
       $html .= '<a class="vacReplySnd" href="" rel="'.$vacancyId.'" href="#">Отправить</a>';
       $html .= '</form>';
       
       echo $html;
       exit;
   }
   
   /*
        Обрабтка полученных с формы данных и отправка письма
   */
   public function sendVacancyReplyForm($vacancyId = false) {
        $vacancyId = getRequest('vacancy_id');
        $hierarchy = umiHierarchy::getInstance();
        $vacancy = $hierarchy->getElement($vacancyId);
        
        $soiskatelTmpDataArray = explode('&',urldecode(getRequest('soiskatel')));
        $soiskatelDataArray = array();
        foreach ($soiskatelTmpDataArray as $v){
            $tmpArr = explode('=',$v);
            $soiskatelDataArray[$tmpArr[0]] = $tmpArr[1];
        }

        $answer = array();
        $answer['status'] = 'ok';
        $answer['message'] = 'some message';
        
        // Масив  обязательных полей
        $requireFlds = array();
        $requireFlds[] = array('vacRplFIO','ФИО');
        $requireFlds[] = array('vacRplEmail','Почта');
        $requireFlds[] = array('vacRplMessage','О себе');
        
        foreach ($requireFlds as $fld){
            if(trim($soiskatelDataArray[$fld[0]]) == ''){
                $answer['status'] = 'error';
                $answer['message'] = 'Поле "'.$fld[1].'" обязательно для заполнения';
                $answer['fld'] = $fld[0];
                echo json_encode($answer);
                exit;
            }
        }
		
        $answer['status'] = 'ok';
        $answer['message'] = 'Ваша заявка отправлена.<br> Спасибо за проявленный интерес.';
        
        $mailContent = "";
        $mailContent .= "ФИО: ".$soiskatelDataArray["vacRplVozrast"]."<br>";
        $mailContent .= "Телефон: ".$soiskatelDataArray["vacRplPhone"]."<br>";
        $mailContent .= "E-mail: ".$soiskatelDataArray["vacRplEmail"]."<br>";
        $mailContent .= "Ссылка на страницу в соц.сетях: ".$soiskatelDataArray["vacRplVKLink"]."<br>";
        $mailContent .= "Ст. метро: ".$soiskatelDataArray["vacRplMetro"]."<br>";
        $mailContent .= "Страна: ".$soiskatelDataArray["vacRplCounty"]."<br>";
        $mailContent .= "О себе: ".$soiskatelDataArray["vacRplMessage"]."<br>";
        
        $mail = new umiMail();
        // Установка адреса отправителя
        $mail->setFrom("info@kalyan-hut.ru");
        // Установка адреса получателя
        $mail->addRecipient("2101779@mail.ru");
        //$mail->addRecipient("arbuzovan@gmail.com");
        // Установка темы письма
        $mail->setSubject("Отклик на вакансию '".$vacancy->getName()."'");
        $mail->setContent($mailContent);
        // подтверждение отправки сообщения
        $mail->send();
        
        echo json_encode($answer);
        exit;

   }
};
?>