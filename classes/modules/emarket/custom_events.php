<?php
	new umiEventListener("order-status-changed", "emarket", "regOnOrder");
	
	new umiEventListener("systemModifyObject", "emarket", "onOrderCreate");
	
	//new umiEventListener('order-status-changed', 'emarket', 'notifyMegaplan');
?>