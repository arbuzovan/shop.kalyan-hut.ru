<?php
	abstract class __config	extends	baseModuleAdmin	{
		public function	main() {
			$regedit = regedit::getInstance();
			$config = mainConfiguration::getInstance();

			include_once('timezones.php');
			$timezones['value'] = $config->get("system", "time-zone");

			$params	= array(
				"globals" => array(
					"string:keycode"	=> NULL,
					"boolean:chache_browser"	=> NULL,
					"boolean:disable_url_autocorrection"	=> NULL,
					"boolean:disable_captcha"	=> NULL,
					"int:max_img_filesize"		=> NULL,
					"status:upload_max_filesize" =>	NULL,
					"boolean:allow-alt-name-with-module-collision" => NULL,
					"boolean:allow-redirects-watch" => NULL,
					"int:session_lifetime"	=> NULL,
					"status:busy_quota_files_and_images"	=> NULL,
					"int:quota_files_and_images"	=> NULL,
					"boolean:search_morph_disabled"	=> NULL,
					"boolean:disable_too_many_childs_notification"	=> NULL,
					'select:timezones' => NULL
				)
			);

			$upload_max_filesize = cmsController::getInstance()->getModule('data')->getAllowedMaxFileSize();

			$mode =	getRequest("param0");

			if($mode ==	"do") {
				$params	= $this->expectParams($params);

				$regedit->setVar("//settings/chache_browser", $params['globals']['boolean:chache_browser']);
				$regedit->setVar("//settings/keycode", $params['globals']['string:keycode']);
				$regedit->setVar("//settings/disable_url_autocorrection", $params['globals']['boolean:disable_url_autocorrection']);
				$config->set('anti-spam', 'captcha.enabled', !$params['globals']['boolean:disable_captcha']);

				$maxImgFilesize = $params['globals']['int:max_img_filesize'];
				if ($maxImgFilesize <= 0 || $maxImgFilesize > $upload_max_filesize) $maxImgFilesize = $upload_max_filesize;
				$regedit->setVar("//settings/max_img_filesize",	$maxImgFilesize);

				$config->set('kernel', 'ignore-module-names-overwrite', $params['globals']['boolean:allow-alt-name-with-module-collision']);
				$config->set('seo', 'watch-redirects-history', $params['globals']['boolean:allow-redirects-watch']);
				$config->set("system", "session-lifetime", $params['globals']['int:session_lifetime']);
				$quota = (int) $params['globals']['int:quota_files_and_images'];
				if ($quota<0) {
					$quota = 0;
				}
				$config->set("system", "quota-files-and-images", $quota * 1024 * 1024);
				$config->set("system", "search-morph-disabled", $params['globals']['boolean:search_morph_disabled']);
				$config->set("system", "disable-too-many-childs-notification", $params['globals']['boolean:disable_too_many_childs_notification']);
				$config->set("system", "time-zone", $params['globals']['select:timezones']);

				$this->chooseRedirect();
			}

			$params['globals']['boolean:chache_browser'] = $regedit->getVal("//settings/chache_browser");
			$params['globals']['string:keycode'] = $regedit->getVal("//settings/keycode");
			$params['globals']['boolean:disable_url_autocorrection'] = $regedit->getVal("//settings/disable_url_autocorrection");
			$params['globals']['boolean:disable_captcha'] =	!$config->get('anti-spam', 'captcha.enabled');
			$params['globals']['status:upload_max_filesize'] = $upload_max_filesize;

			$max_img_filesize =	$regedit->getVal("//settings/max_img_filesize");

			$params['globals']['int:max_img_filesize'] = $max_img_filesize ? $max_img_filesize : $upload_max_filesize;
			$params['globals']['boolean:allow-alt-name-with-module-collision'] = $config->get('kernel', 'ignore-module-names-overwrite');
			$params['globals']['boolean:allow-redirects-watch'] = $config->get('seo', 'watch-redirects-history');

			$quotaByte = getBytesFromString( mainConfiguration::getInstance()->get('system', 'quota-files-and-images') );
			$params['globals']['status:busy_quota_files_and_images'] = ($quotaByte != 0) ? ceil(getBusyDiskSize() / (1024*1024)) : 0;

			$params['globals']['int:quota_files_and_images'] = (int) (getBytesFromString($config->get('system', 'quota-files-and-images')) / (1024*1024));
			$params['globals']['int:session_lifetime'] = $config->get('system', 'session-lifetime');
			$params['globals']['boolean:search_morph_disabled'] = $config->get('system', 'search-morph-disabled');
			$params['globals']['boolean:disable_too_many_childs_notification'] = $config->get('system', 'disable-too-many-childs-notification');
			$params['globals']['select:timezones'] = $timezones;

			$this->setDataType("settings");
			$this->setActionType("modify");

			if(is_demo()) {
				unset($params["globals"]['string:keycode']	);
			}

			$data =	$this->prepareData($params,	"settings");

			$this->setData($data);
			return $this->doData();
		}


		public function menu() {
			$block_arr = Array();
			$regedit = regedit::getInstance();

			$modules = $this->getSortedModulesList();

			$result = array();
			foreach ( $modules as $moduleName => $moduleInfo ) {
				$moduleConfig = $regedit->getVal("//modules/{$moduleName}/config");
				$currentModule = cmsController::getInstance()->getCurrentModule();
				$currentMethod = cmsController::getInstance()->getCurrentMethod();

				$line_arr = Array();
				$line_arr['attribute:name'] = $moduleInfo['name'];
				$line_arr['attribute:label'] = $moduleInfo['label'];
				$line_arr['attribute:type']= $moduleInfo['type'];

				if($currentModule == $moduleName && !($currentMethod == 'mainpage')) {
					$line_arr['attribute:active'] = "active";
				}

				if($moduleConfig && system_is_allowed( $currentModule, "config" )) {
					$line_arr['attribute:config'] = "config";
				}

				$result[] = $line_arr;
			}

			$block_arr['items'] = Array("nodes:item" =>$result);

			return $block_arr;
		}


		public function	modules() {
			$modules = Array();
			$regedit = regedit::getInstance();
			$modules_list =	$regedit->getList("//modules");

			foreach($modules_list as $module_name) {
				list($module_name) = $module_name;

				$modules[] = $module_name;
			}


			$this->setDataType("list");
			$this->setActionType("view");

			$data =	$this->prepareData($modules, "modules");

			$this->setData($data);
			return $this->doData();
		}


		public function	add_module_do()	{
			$cmsController = cmsController::getInstance();

			$modulePath = getRequest('module_path');

			$moduleName = '';
			if(preg_match("/\/modules\/(\S+)\//", $modulePath, $out)) {
				$moduleName = getArrayKey($out, 1);
			}

			if (!preg_match("/.\.php$/", $modulePath )){
				$modulePath .= "/install.php";
			}

			if(!is_demo()) {
				$cmsController->installModule($modulePath);
				if($moduleName == 'geoip') {
					self::switchGroupsActivity('city_targeting', true);
				}
			}

			$this->chooseRedirect($this->pre_lang .	"/admin/config/modules/");
		}


		public function	del_module() {
			$restrictedModules = array('config', 'content', 'users', 'data');

			$target	= getRequest('param0');

			if(in_array($target, $restrictedModules))	{
				throw new publicAdminException(getLabel("error-can-not-delete-{$target}-module"));
			}

			$module	= cmsController::getInstance()->getModule($target);

			if(!is_demo()) {
				if($module instanceof def_module) {
					$module->uninstall();
				}
				if($target == 'geoip') {
					self::switchGroupsActivity('city_targeting', false);
				}
			}

			$this->chooseRedirect($this->pre_lang . "/admin/config/modules/");
		}

		// for testing  generation time
		public function speedtest() {
			$buffer = outputBuffer::current();
			$buffer-> option('generation-time', false);
			$buffer-> clear();
			$calltime = $buffer->calltime();
			$buffer-> push($calltime);
			$buffer-> end();
		}

	};
?>
