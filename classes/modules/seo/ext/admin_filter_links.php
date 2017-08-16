<?php

abstract class admin_filter_links {

    public function onImplement() {
        if (cmsController::getInstance()->getCurrentMode() != 'admin')
            return;

        $commonTabs = $this->getCommonTabs();
        if (is_object($commonTabs)) {
            $commonTabs->add('filter_links');
        }
    }

    public function fl_toggleActivity() {
        $regedit = regedit::getInstance();
        $is_enabled = intval(getRequest('is_enabled'));

        if ($is_enabled) {
            $regedit->setVal('//settings/disable_url_autocorrection', 1);
        }

        $regedit->setVal('//modules/seo/filter_links_is_enabled', $is_enabled);
        $this->chooseRedirect($this->pre_lang . '/admin/seo/filter_links/');
    }

    public function filter_links() {
        $regedit = regedit::getInstance();

		require_once dirname(__FILE__)."/install_helper.php";
        if (registrateModule('seo', 'filter_links')) {
			
			$config = mainConfiguration::getInstance();
            $config->set('kernel', 'buffer-send-event-enable', '1');
			
            createType(array(
                'regedit_section_name' => 'seo',
                'object_type_guid' => 'filter_links',
                'object_type_title' => 'SEO-ссылки для фильтров',
                'groups' => array(
                    array(
                        'name' => 'link-info',
                        'title' => 'Настройки ссылки',
                        'is_visible' => '0',
                        'fields' => array(
                            array(
                                'name' => 'url',
                                'title' => 'Адрес ссылки',
                                'is_visible' => 0,
                                'tip' => 'Укажите адрес ссылки (без адреса сайта), при переходе на которую должен открываться соответствующий раздел каталога с учетом фильтрации',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 1,
                                'field_type' => 'string',
                            ),
                            array(
                                'name' => 'page_id',
                                'title' => 'Раздел каталога',
                                'is_visible' => 0,
                                'tip' => 'Укажите раздел каталога, для которого будет формироваться ссылка',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 1,
                                'field_type' => 'symlink',
                            ),
                            array(
                                'name' => 'filters',
                                'title' => 'Фильтры',
                                'is_visible' => 0,
                                'tip' => 'Укажите query-хэш фильтров, которые должны применяться при переходе по ссылке. Более подробная информация по формату ввода данных доступна в Справке к расширению',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'text',
                            ),
                            array(
                                'name' => 'domain_id',
                                'title' => 'Идентификатор домена',
                                'is_visible' => 0,
                                'tip' => '',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'int',
                            ),
                        )
                    ), array(
                        'name' => 'seo-info',
                        'title' => 'SEO-настройки',
                        'is_visible' => '0',
                        'fields' => array(
                            array(
                                'name' => 'title',
                                'title' => 'Title',
                                'is_visible' => 0,
                                'tip' => 'Укажите значение тега title, которое будет выводиться при переходе по ссылке. Если поле не заполнено, будет использоваться значение по умолчанию, заданное в конфигурации домена',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'string',
                            ),
                            array(
                                'name' => 'meta_description',
                                'title' => 'Meta Description',
                                'is_visible' => 0,
                                'tip' => 'Укажите значение тега meta description, которое будет выводиться при переходе по ссылке. Если поле не заполнено, будет использоваться значение по умолчанию, заданное в конфигурации домена',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'string',
                            ),
                            array(
                                'name' => 'meta_keywords',
                                'title' => 'Meta Keywords',
                                'is_visible' => 0,
                                'tip' => 'Укажите значение тега meta keywords, которое будет выводиться при переходе по ссылке. Если поле не заполнено, будет использоваться значение по умолчанию, заданное в конфигурации домена',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'string',
                            ),
                            array(
                                'name' => 'is_sitemap',
                                'title' => 'Добавить в sitemap.xml',
                                'is_visible' => 0,
                                'tip' => 'Поставьте галочку, чтобы ссылка попала в sitemap.xml. Добавление в ссылки sitemap.xml поможет поисковым системам быстрее проиндексировать ее.',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'boolean',
                            ),
                            array(
                                'name' => 'priority',
                                'title' => 'Priority',
                                'is_visible' => 0,
                                'tip' => 'Задает приоритетность URL относительно других URL в sitemap.xml. Допустимый диапазон значений — от 0.0 до 1.0. Приоритет страницы по умолчанию — 0.5',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'float',
                            ),
                            array(
                                'name' => 'h1',
                                'title' => 'H1',
                                'is_visible' => 0,
                                'tip' => '',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'string',
                            ),
                            array(
                                'name' => 'content',
                                'title' => 'Контент',
                                'is_visible' => 0,
                                'tip' => 'Укажите контент, который будет при переходе по ссылке. Более подробная информация доступна в Справке к расширению',
                                'is_in_filter' => 0,
                                'is_in_search' => 0,
                                'is_required' => 0,
                                'field_type' => 'wysiwyg',
                            ),
                        )
                    )
                ),
            ));
        }

        $this->setDataType("list");
        $this->setActionType("view");

        $type_id = $regedit->getVal("//modules/seo/filter_links_otype_id");

        $limit = getRequest('per_page_limit');
        $domain_id = getRequest('domain_id');
        $curr_page = (int) getRequest('p');
        $offset = $limit * $curr_page;

        $sel = new selector('objects');
        $sel->types('object-type')->id($type_id);
        $sel->where('domain_id')->equals($domain_id);
        $sel->limit($offset, $limit);

        selectorHelper::detectFilters($sel);

        $this->setDataRange($limit, $offset);
        $data = $this->prepareData($sel->result, "objects");
        $data['attribute:is_enabled'] = intval($regedit->getVal('//modules/seo/filter_links_is_enabled'));

        $this->setData($data, $sel->length);
        return $this->doData();
    }

    public function filter_link_edit() {

        $obj_id = (int) getRequest('param0');
        $mode = getRequest('param1');

        $regedit = regedit::getInstance();
        $inputData = array();
        $action = 'create';
        $type_id = $regedit->getVal('//modules/seo/filter_links_otype_id');

        $inputData['type-id'] = $type_id;

        $domain_id = cmsController::getInstance()->getCurrentDomain()->getId();

        if ($obj_id > 0) {
            $action = 'modify';
            $object = umiObjectsCollection::getInstance()->getObject($obj_id);

            $object = $this->expectObject('param0', true);
            if (is_object($object) && $object->getTypeId() == $type_id) {
                $inputData['object'] = $object;
            }

            if ($mode == 'do') {
                if (isset($_REQUEST['data'][$obj_id]['url'])) {
                    $_REQUEST['data'][$obj_id]['url'] = $this->fl_validateUrl($_REQUEST['data'][$obj_id]['url'], $obj_id);
                }
                if (isset($_REQUEST['data'][$obj_id]['page_id'])) {
                    $_REQUEST['data'][$obj_id]['page_id'] = $this->fl_validateCategory($_REQUEST['data'][$obj_id]['page_id']);
                }
                if (isset($_REQUEST['data'][$obj_id]['filters'])) {
                    $_REQUEST['data'][$obj_id]['filters'] = $this->fl_validateFilters($_REQUEST['data'][$obj_id]['filters']);
                }

                $_REQUEST['data'][$obj_id]['priority'] = str_replace(',', '.', $_REQUEST['data'][$obj_id]['priority']);
                $_REQUEST['data'][$obj_id]['priority'] = round(floatval($_REQUEST['data'][$obj_id]['priority']), 1);
                if ($_REQUEST['data'][$obj_id]['priority'] > 1) {
                    $_REQUEST['data'][$obj_id]['priority'] = 1;
                } else if ($_REQUEST['data'][$obj_id]['priority'] < 0) {
                    $_REQUEST['data'][$obj_id]['priority'] = 0;
                }

                $is_sitemap_delete = 1;
                if (isset($_REQUEST['data'][$obj_id]['is_sitemap']) && $_REQUEST['data'][$obj_id]['is_sitemap'] == 1) {
                    $is_sitemap_delete = 0;
                }

                $this->fl_updateSitemap($domain_id, $obj_id, $_REQUEST['data'][$obj_id]['url'], $_REQUEST['data'][$obj_id]['priority'], $is_sitemap_delete);

                $this->saveEditedObjectData($inputData);

                $this->chooseRedirect($this->pre_lang . '/admin/seo/filter_link_edit/' . $obj_id . '/');
            }
        } else {
            if ($mode == 'do') {
                if (isset($_REQUEST['data']['new']['url'])) {
                    $_REQUEST['data']['new']['url'] = $this->fl_validateUrl($_REQUEST['data']['new']['url']);
                }
                if (isset($_REQUEST['data']['new']['page_id'])) {
                    $_REQUEST['data']['new']['page_id'] = $this->fl_validateCategory($_REQUEST['data']['new']['page_id']);
                }
                if (isset($_REQUEST['data']['new']['filters'])) {
                    $_REQUEST['data']['new']['filters'] = $this->fl_validateFilters($_REQUEST['data']['new']['filters']);
                }

                $_REQUEST['data']['new']['priority'] = str_replace(',', '.', $_REQUEST['data']['new']['priority']);
                $_REQUEST['data']['new']['priority'] = round(floatval($_REQUEST['data']['new']['priority']), 1);
                if ($_REQUEST['data']['new']['priority'] > 1) {
                    $_REQUEST['data']['new']['priority'] = 1;
                } else if ($_REQUEST['data']['new']['priority'] < 0) {
                    $_REQUEST['data']['new']['priority'] = 0;
                }

                $object = $this->saveAddedObjectData($inputData);
                $added = umiObjectsCollection::getInstance()->getObject($object->getId());
                $added->setValue('domain_id', $domain_id);
                $added->commit();

                if (isset($_REQUEST['data']['new']['is_sitemap']) && $_REQUEST['data']['new']['is_sitemap'] == 1) {
                    $this->fl_updateSitemap($domain_id, $object->getId(), $_REQUEST['data']['new']['url'], $_REQUEST['data']['new']['priority']);
                }

                $this->chooseRedirect($this->pre_lang . '/admin/seo/filter_link_edit/' . $object->getId() . '/');
            }
        }

        $this->setHeaderLabel('header-seo-filter-link-' . $action);

        $this->setDataType('form');
        $this->setActionType($action);

        $data = $this->prepareData($inputData, 'object');

        $this->setData($data);
        return $this->doData();
    }

    public function fl_validateUrl($url = '', $id = 0) {
        $url = trim($url);
        if (strlen($url)) {
            if ($url[0] != '/') {
                $url = '/' . $url;
            }

            $config = mainConfiguration::getInstance();
            $lang = cmsController::getInstance()->getCurrentLang();
            if (is_object($lang)) {
                $prefix = '';
                if (method_exists($lang, 'getIsDefault')) {
                    if (!$lang->getIsDefault()) {
                        $prefix = $lang->getPrefix();
                    }
                }

                if (strlen($prefix)) {
                    if (strpos($url, "/{$prefix}/") === FALSE || strpos($url, "/{$prefix}/") > 0) {
                        $url = "/{$prefix}" . $url;
                    }
                }
            }

            $url_exploded = parse_url($url);
            if (isset($url_exploded['path'])) {
                $url = $url_exploded['path'];
            }

            if ($config->get('seo', 'url-suffix.add')) {
                $suffix = $config->get('seo', 'url-suffix');
                if (substr($url, strlen($url) - strlen($suffix), strlen($suffix)) != $suffix) {
                    $url = $url . $suffix;
                }
            }

            $regedit = regedit::getInstance();
            $domain_id = cmsController::getInstance()->getCurrentDomain()->getId();
            $type_id = $regedit->getVal('//modules/seo/filter_links_otype_id');

            $sel = new selector('objects');
            $sel->types('object-type')->id($type_id);
            $sel->where('domain_id')->equals($domain_id);
            $sel->where('url')->equals($url);
            $sel->where('id')->notequals($id);
            $is_dublicate = $sel->first;

            if (umiHierarchy::getInstance()->getIdByPath($url, 1) || is_object($is_dublicate)) {
                throw new publicAdminException('На сайте существует страница с указанным URL. Ссылка должна иметь уникальный адрес.<br/><a href="javascript: history.back()">← Вернуться назад и исправить</a>');
            }
        }
        return $url;
    }

    public function fl_validateCategory($category = '') {
        if (!is_array($category)) {
            throw new publicAdminException('Необходимо указать раздел каталога, для которого будет применяться создаваемая ссылка.<br/><a href="javascript: history.back()">← Вернуться назад и исправить</a>');
        }

        if (isset($category[1])) {
            $q = l_mysql_query("SELECT id FROM cms3_hierarchy WHERE id = {$category[1]} AND type_id IN (SELECT id FROM cms3_hierarchy_types WHERE name = 'catalog' AND ext = 'category')");
            $row = mysql_fetch_row($q);
            if (!is_array($row)) {
                throw new publicAdminException('В качестве значения для поля «Раздел каталога» должны использоваться страницы сайта с типом данных «Раздел каталога», или производные от него.<br/><a href="javascript: history.back()">← Вернуться назад и исправить</a>');
            } else {
                return array(0 => $category[1]);
            }
        }
    }

    public function fl_validateFilters($filters = '') {
        $filters = trim($filters);
        if (strlen($filters)) {
            $filters = str_replace('?', '', $filters);
        }
        return $filters;
    }

    public function fl_updateSitemap($domain_id, $id, $url = '', $priority = 0, $is_delete = 0) {
        $domain = domainsCollection::getInstance()->getDomain($domain_id);
        $host = $domain->getHost();
        $host = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443) ? 'https://' . $host : 'http://' . $host;
        $domain_id = $domain->getId();
        $link = $host . $url;

        if (mysql_num_rows(l_mysql_query("SHOW TABLES LIKE 'cms_sitemap'")) == 1) {
            $beforeUpdate = umiObjectsCollection::getInstance()->getObject($id);
            if (is_object($beforeUpdate)) {
                $prev_link = $host . $beforeUpdate->getValue('url');
                l_mysql_query("DELETE FROM cms_sitemap WHERE link = '{$prev_link}' AND domain_id = {$domain_id}");
            }
            if (!$is_delete) {
                //пока нет autoincrement в колонке ID
                $_id = 0;
                $q = l_mysql_query("SELECT MAX(id) FROM cms_sitemap");
                $row = mysql_fetch_row($q);
                if (is_array($row) && isset($row[0])) {
                    $_id = intval($row[0] + 1);
                }

                $lang_id = cmsController::getInstance()->getCurrentLang()->getId();
                l_mysql_query("INSERT INTO cms_sitemap(id,domain_id,link,sort,priority,dt,level,lang_id) VALUES({$_id},{$domain_id},'{$link}',0,'{$priority}','" . date('Y-m-d H:i:s') . "',1,{$lang_id})");
            }
        } else {
            $dir_name = CURRENT_WORKING_DIR . "/sys-temp/sitemap/{$domain_id}/";
            if (!is_dir($dir_name))
                mkdir($dir_name, 0777, true);
            $filename = $dir_name . "fl_{$id}.xml";

            if (file_exists($filename))
                unlink($filename);

            if ($is_delete) {
                return 1;
            }

            $root = new DOMDocument();
            $node_url = $root->createElement('url');
            $node_loc = $root->createElement('loc', $link);
            if ($priority > 0) {
                $node_priority = $root->createElement('priority', $priority);
            }
            $node_lastmod = $root->createElement('lastmod', date('c', time()));
            $root->appendChild($node_url);
            $node_url->appendChild($node_loc);
            $node_url->appendChild($node_lastmod);
            if ($priority > 0) {
                $node_url->appendChild($node_priority);
            }
            if (file_put_contents($filename, $root->saveXML($node_url))) {
                return 1;
            }
        }

        return 0;
    }

    public function filter_links_delete() {
        $regedit = regedit::getInstance();
        $objects = getRequest('element');
        if (!is_array($objects)) {
            $objects = array($objects);
        }
        $domain_id = cmsController::getInstance()->getCurrentDomain()->getId();

        foreach ($objects as $objectId) {
            $obj = $this->expectObject($objectId, false, true);

            if (is_object($obj) && $obj->getTypeId() == $regedit->getVal("//modules/seo/filter_links_otype_id")) {
                $params = Array(
                    'object' => $obj
                );

                $this->fl_updateSitemap($domain_id, $objectId, '', 0, 1);

                $this->deleteObject($params);
            }
        }

        $this->setDataType('list');
        $this->setActionType('view');
        $data = $this->prepareData($objects, 'objects');
        $this->setData($data);

        return $this->doData();
    }

    public function getObjectTypeEditLink($typeId) {
        return Array(
            'create-link' => $this->pre_lang . "/admin/data/type_add/" . $typeId . "/",
            'edit-link' => $this->pre_lang . "/admin/data/type_edit/" . $typeId . "/"
        );
    }

}