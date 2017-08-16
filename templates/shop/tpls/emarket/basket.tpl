<?php
$FORMS = array();

$FORMS['order_block'] = <<<END
	<a class="bskt_lnk" id="basket_link" href="/emarket/cart/" style="padding-left: 50px; position: relative; color: #DC9B36;">
	<img style="position: absolute; left: 0px;" src="/templates/shop/images/shopping_cart.png"><span id="cart_text">Ваша корзина</span></a>
	<span id="amount" style="font-weight: bold;">( %total-amount% )</span>
	<div id="basket_items"></div>
END;

$FORMS['order_block_empty'] = <<<END
	<a class="bskt_lnk" nohref style="padding-left: 60px; position: relative; color: #DC9B36;">
	<img style="position: absolute; left: 0px;" src="/templates/shop/images/shopping_cart.png"><span id="cart_text">Корзина пуста</span></a>
	<span id="amount" style="font-weight: bold;"></span>
	<div id="basket_items"></div>
END;

$FORMS['order_item'] = <<<END
	<li>
		<a href="//%domain%%link%">%name%</a> x <input type="text" value"%amount%" style="width: 30px;">
		<br />
		%total-price%
		<a href="%pre_lang%/emarket/basket/remove/item/%id%/">(X)</a>
	</li>
END;

$FORMS['order_block_popup'] = <<<END
<table style="width:100%; text-align: left;">
	<thead>
		<tr>
			<th>Товар</th>
			<th style="text-align: center;">Кол-во, шт</th>
			<th style="text-align: center;">Цена</th>
		</tr></thead>
	<tfoot>
		<tr>
			<td colspan=2 style="text-align: right; font-weight: bold">Итого:</td>
			<td style="width: 20%; text-align: center;">%totalPrice%</td>
		</tr>
	</tfoot>
	<tbody style="border-top: 1px solid #FF7A00; border-bottom: 1px solid #FF7A00; padding-top: 10px">
		%items%
	</tbody>
</table>
END;

$FORMS['order_block_popup_item'] = <<<END
<tr>
	<td><a style="color: #3c3c3c;" href="//%domain%%link%">%name%</a></td>
	<td style="width: 22%; text-align: center;">%amount%</td>
	<td style="width: 20%; text-align: center;">%price%</td>
</tr>
END;


$FORMS['price_original'] = <<<END
<strike>%prefix%&nbsp;%original%&nbsp;%suffix%</strike>
END;

$FORMS['price_actual'] = <<<END
%prefix%&nbsp;%actual%&nbsp;%suffix%
END;


?>