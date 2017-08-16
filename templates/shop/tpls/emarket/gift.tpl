<?php
$FORMS = array();

$FORMS['order_block'] = <<<END
    <h3 style="margin: 20px 0 10px 0; color: #7A500E;">Покупки в заказе</h3>
    <table style="text-align: left;" width="100%" rules="rows" cellspacing="0" cellpadding="0" border="0" id="order_block">
        <thead>
            <tr class="orow_hat">
				        <th>Фото</th>
                <th>Наименования</th>
                <th>Кол-во</th>
                <th>Цена</th>
                <th>Сумма</th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>

        %items%

        </tbody>
    </table>
		<div class="info-cart-empty">Для того чтобы оформить заказ, добавьте хотя бы один товар из каталога</div>
END;

$FORMS['order_item'] = <<<END


<tr class="%element_id%">
	<td>
		<div>
			%data getProperty(%element_id%,'photo', 'photo')%
		</div>
	</td>
	<td style="text-align: left;">
		<a href="//%domain%%link%">%name%</a>
	</td>
	<td>
   1
	</td>
	<td>
		%price%
	</td>
	<td>
		%total-price%
	</td>
	<td>
	</td>
</tr>
END;

?>