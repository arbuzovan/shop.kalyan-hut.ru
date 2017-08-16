<?php
	define("CURRENT_WORKING_DIR", str_replace("\\", "/", $dirname = dirname(__FILE__)));
	require CURRENT_WORKING_DIR . '/libs/config.php';
 
	$cmsController = cmsController::getInstance();
	$config = mainConfiguration::getInstance();
 
	$crawlDelay = $config->get('seo', 'crawl-delay');
	$primaryWWW = (bool) $config->get('seo', 'primary-www');
 
	$buffer = outputBuffer::current('HTTPOutputBuffer');
	$buffer->contentType('text/plain');
	$buffer->charset('utf-8');
 
	$domain = $cmsController->getCurrentDomain();
	$domain_id = $domain->getId();
	
	if(file_exists("robots{$domain_id}.txt")) {
		$buffer->push(file_get_contents("robots{$domain_id}.txt"));
	
	} else {
	
		$sel = new selector('pages');
		$sel->where('robots_deny')->equals('1');
		$sel->where('domain')->equals($domain_id);
		
		$rules = "";
		//if(sizeof($sel->result) == 0) {
		//	$rules .= "Disallow: \r\n";
		//}
	 
		$rules .= "Disallow: /?\r\n";
	 
		foreach($sel->result as $element) {
			$rules .= "Disallow: " . $element->link . "\r\n";
		}
	 
		$host = $domain->getHost();
		if($primaryWWW) {
			$host = 'www.' . $host;
		}
	 
		$buffer->push("User-Agent: Googlebot\r\n");
		$buffer->push($rules . "\r\n");
	 
		$buffer->push("User-Agent: Yandex\r\n");
		$buffer->push($rules . "\r\n");
	 
		$buffer->push("Host: {$host} \r\n");
	 
		$buffer->push("Crawl-delay: {$crawlDelay}\r\n");
	 
		$buffer->push("User-Agent: *\r\n");
		$buffer->push($rules);
 
	}
	
	$buffer->end();
?>