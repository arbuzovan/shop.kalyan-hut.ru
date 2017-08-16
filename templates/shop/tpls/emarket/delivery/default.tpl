<?php
$FORMS = Array();

$FORMS['delivery_block'] = <<<END
<form action="%pre_lang%/emarket/purchase/payment/choose" method="post">
	<ul>
		%items%
	</ul>

	<p>
		<input type="submit" style="margin-top: 20px;" class="btn" value="Продолжить" />
	</p>
</form>
END;

$FORMS['delivery_item_free'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" %checked%/> %name% - бесплатно</li>
END;

$FORMS['delivery_item_priced'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" %checked%/> %name% - %price% р.</li>
END;

$FORMS['self_delivery_block'] = <<<END
	
END;

$FORMS['self_delivery_item_free'] = <<<END
	<li><input type="radio" name="delivery-address" value="delivery_%id%" %checked%/> %name% - бесплатно</li>
END;

$FORMS['self_delivery_item_priced'] = <<<END
	<li><input type="radio" name="delivery-address" value="delivery_%id%" %checked%/> %name% - %price%</li>
END;

$FORMS['delivery_address_block'] = <<<END
<form action="%pre_lang%/emarket/purchase/delivery/address/do/" method="post">
	<p><b>Выберите адрес доставки:</b></p>
		%items%
		%delivery%
		<br /><input type="radio" name="delivery-address" value="new" /><b>&nbsp;Новый адрес доставки:</b>
	<p></p>
	%data getCreateForm(%type_id%, 'purchase')%
	<p>
		<input type="submit" value="Продолжить" class="btn" />
	</p>
</form>
END;

$FORMS['delivery_address_item'] = <<<END
	<li><input type="radio" name="delivery-address" value="%id%" %checked%/> %data getPropertyGroupOfObject(%id%, 'common', 'purchase')%</li>
END;
?>

