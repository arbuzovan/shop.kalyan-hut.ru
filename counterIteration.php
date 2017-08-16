<?php
    define("CURRENT_WORKING_DIR", str_replace("\\", "/", $dirname = dirname(__FILE__)));
    require CURRENT_WORKING_DIR . '/libs/root-src/standalone.php';
    header("Content-Type: text/html; charset=utf-8");

    $regedit = regedit::getInstance();
    if($regedit->getVal('//modules/emarket/counter_on') == true){
        $currentValue = $regedit->getVal('//modules/emarket/counter_current_value');
        $counterDeltaStart = $regedit->getVal('//modules/emarket/counter_delta_start');
        $counterDeltaEnd = $regedit->getVal('//modules/emarket/counter_delta_end');
        $counterIterator = rand($counterDeltaStart,$counterDeltaEnd);
        $newCounterValue = $currentValue + $counterIterator;
        $regedit->setVar('//modules/emarket/counter_current_value', $newCounterValue);
        
        echo "Новое значение счетчика - {$newCounterValue}";
    }
    
?>