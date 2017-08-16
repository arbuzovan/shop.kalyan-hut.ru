<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);

abstract class common_filter_links {

    public function fl_doWork($event) {
		
        if (cmsController::getInstance()->getCurrentMode() != "admin") {
            if ($event->getMode() == 'before') {
                $regedit = regedit::getInstance();
                $cc = cmsController::getInstance();
                $path = getRequest('path');
                $type_id = intval($regedit->getVal('//modules/seo/filter_links_otype_id'));
                if (strlen($path) && $type_id > 0 && $regedit->getVal('//modules/seo/filter_links_is_enabled')) {
                    if ($cc->getCurrentModule() == 'content' && !$cc->getCurrentElementId()) {
                        $type_id = intval($regedit->getVal('//modules/seo/filter_links_otype_id'));
                        if (strlen($path) && $type_id > 0 && $regedit->getVal('//modules/seo/filter_links_is_enabled')) {
                            $s = new selector('objects');
                            $s->types('object-type')->id($type_id);
                            $s->where('url')->equals("/{$path}");
                            $s->where('domain_id')->equals($cc->getCurrentDomain()->getId());
                            $obj = $s->first;
                            if (is_object($obj)) {
                                $page_id_arr = $obj->getValue('page_id');
                                if (is_array($page_id_arr) && count($page_id_arr) && isset($page_id_arr[0]) && is_object($page_id_arr[0])) {
                                    $page_id = $page_id_arr[0]->getId();
                                    $page_path = umiHierarchy::getInstance()->getPathById($page_id);
                                    if (strlen($page_path) > 1) {
                                        $page_path = substr($page_path, 1);

                                        $uri_arr = parse_url($_SERVER['REQUEST_URI']);
                                        if (isset($uri_arr['query'])) {
                                            //die('123');
                                            //def_module::redirect("{$page_path}?".$uri_arr['query']);
                                        }

                                        $_REQUEST['path'] = $page_path;
                                        if (strlen($obj->getValue('filters'))) {
                                            $filters_arr = array();
                                            parse_str(urldecode($obj->getValue('filters')), $filters_arr);
                                            if (count($filters_arr) > 0) {
                                                if (isset($filters_arr['path'])) {
                                                    unset($filters_arr['path']);
                                                }

                                                $_REQUEST = array_merge($_REQUEST, $filters_arr);
                                                $_GET = array_merge($_GET, $filters_arr);
                                            }
                                        }
                                        $cc->analyzePath();
                                        $_REQUEST['path'] = $path;
                                        $_REQUEST['seo_filter_path'] = 1;
                                        $_REQUEST['seo_filter_link_id'] = $obj->getId();
										

                                        if ($obj->getValue('title') != '') {
                                            $_REQUEST['seo_filter_link_title'] = $obj->getValue('title');
                                            //$cc->currentTitle = $obj->getValue('title');
                                        }
                                        if ($obj->getValue('meta_description') != '') {
                                            $_REQUEST['seo_filter_link_meta_description'] = $obj->getValue('meta_description');
                                            //$cc->currentMetaDescription = $obj->getValue('meta_description');
                                        }
                                        if ($obj->getValue('meta_keywords') != '') {
                                            $_REQUEST['seo_filter_link_meta_keywords'] = $obj->getValue('meta_keywords');
                                            //$cc->currentMetaKeywords = $obj->getValue('meta_keywords');
                                        }
                                    }
                                }
                            }
                        }
                    } else if ($cc->getCurrentElementId()) {
                        $_path = isset($_REQUEST['path']) ? $_REQUEST['path'] : '';
                        if (strlen($_path)) {
                            $s = new selector('objects');
                            $s->types('object-type')->id($type_id);
                            $s->where('page_id')->equals(array($cc->getCurrentElementId()));
                            $s->where('domain_id')->equals($cc->getCurrentDomain()->getId());
                            $items = $s->result();

                            if (count($items)) {
                                $_request = $_REQUEST;
                                $_p = isset($_REQUEST['p']) ? intval($_REQUEST['p']) : 0;
                                if (isset($_REQUEST['fields_filter'])) {
                                    $_request = array();
                                    $_request['fields_filter'] = $_REQUEST['fields_filter'];
                                }
                                $keys_todelete = array('path', 'umi_authorization', 'p', 'transform');
                                foreach ($keys_todelete as $key) {
                                    if (isset($_request[$key])) {
                                        unset($_request[$key]);
                                    }
                                }

                                foreach ($items as $item) {
                                    $filters = strlen($item->getValue('filters')) ? urldecode($item->getValue('filters')) : '';
                                    $filters_arr = array();
                                    parse_str(urldecode($filters), $filters_arr);
                                    if ($_request == $filters_arr) {
                                        $url = $item->getValue('url');
                                        if ($_p) {
                                            $url = $url . '?p=' . $_p;
                                        }
                                        def_module::redirect($url);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function getSeoFiltersData($field_name) {
        $regedit = regedit::getInstance();
        $type_id = intval($regedit->getVal('//modules/seo/filter_links_otype_id'));
        $path = getRequest('path');
        $result = '';
        if (isset($_REQUEST['seo_filter_path']) && strlen($path) && $type_id > 0 && $regedit->getVal('//modules/seo/filter_links_is_enabled')) {
            $s = new selector('objects');
            $s->types('object-type')->id($type_id);
            $s->where('url')->equals("/{$path}");
            $s->where('domain_id')->equals(cmsController::getInstance()->getCurrentDomain()->getId());
            $obj = $s->first;
            if (is_object($obj)) {
                $result = $obj->getValue($field_name);
            }
        }
        return $result;
    }

    public function fl_BufferSend($event) {
        static $fl_modified = 0;
        if (isset($_REQUEST['seo_filter_path']) && !$fl_modified) {
            include_once dirname(__FILE__) . '/libs/simple_html_dom.php';
            $fl_modified = 1;

            $cmsController = cmsController::getInstance();
            $currentMode = $cmsController->getCurrentMode();

            $buffer = &$event->getRef('buffer');

            $doc = str_get_html($buffer);

            if (isset($_REQUEST['seo_filter_link_title'])) {
                if (isset($doc->find('title', 0)->innertext)) {
                    $doc->find('title', 0)->innertext = getTitleWithPrefix($_REQUEST['seo_filter_link_title']);
                }
            }
			
            if (isset($_REQUEST['seo_filter_link_meta_description']) || isset($_REQUEST['seo_filter_link_meta_keywords'])) {
                if (isset($_REQUEST['seo_filter_link_meta_description']) && isset($doc->find('meta[name=DESCRIPTION]', 0)->content)) {
                    $doc->find('meta[name=DESCRIPTION]', 0)->content = $_REQUEST['seo_filter_link_meta_description'];
                }

                if (isset($_REQUEST['seo_filter_link_meta_keywords']) && isset($doc->find('meta[name=KEYWORDS]', 0)->content)) {
                    $doc->find('meta[name=KEYWORDS]', 0)->content = $_REQUEST['seo_filter_link_meta_keywords'];
                }
            }

            $buffer = $doc;
        }
    }

}
