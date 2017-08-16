<?php
$FORMS = Array();
 
$FORMS['delivery_block'] = <<<END
	<div class="gropu_field_title">Выберите подходящий вам способ доставки:</div>
	<ul>
		%items%
	</ul>
END;
 
$FORMS['delivery_item_free'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" checked="checked" /> %name%</li>
END;
 
$FORMS['delivery_item_priced'] = <<<END
	<li><input type="radio" name="delivery-id" value="%id%" /> %name% - %price% руб.</li>
END;
 
 
$FORMS['delivery_address_block'] = <<<END
<div class="adress">
	<div class="gropu_field_title">Выберите подходящий вам адрес доставки:</div>
		<ul>
			%items%
			<li>
				<input type="radio" name="delivery-address" id="new_adress_btn" value="new" /><b>Новый адрес доставки:</b>
				<table id="new_adress_tbl">
				%data getCreateForm(%type_id%, 'onestep')%
				</table>
			</li>
		</ul>
	</div>
</div>
END;
 
$FORMS['delivery_address_item'] = <<<END
	<li><input type="radio" name="delivery-address" value="%id%" />%index%, %city%, %street%, д. %house%, кв. %flat%</li>
END;
 
?>