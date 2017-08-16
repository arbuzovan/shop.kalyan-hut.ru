<?php
$FORMS = Array();
 
$FORMS['payment_block'] = <<<END
	<div style="%hidden-title%">Выберите подходящий вам способ оплаты:</div>
	<ul>
		%items%
	</ul>
END;
 
$FORMS['payment_item'] = <<<END
	<li><input type="%input-type%" name="payment-id" value="%id%" %checked% />%name%</li>
END;

?>