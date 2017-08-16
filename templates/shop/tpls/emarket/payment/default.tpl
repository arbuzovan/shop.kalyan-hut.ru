<?php
$FORMS = Array();
 
$FORMS['payment_block'] = <<<END
	Выберите подходящий вам способ оплаты:
	<ul>
		%items%
	</ul>
END;
 
$FORMS['payment_item'] = <<<END
	<li><input type="radio" name="payment-id" value="%id%" /> %name%</li>
END;
 
?>