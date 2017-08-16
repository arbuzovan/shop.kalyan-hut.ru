<?php
$FORMS = array();

$FORMS['price_block'] = <<<END

<h5>Вывод цены</h5>
%price-original%
%price-actual%

%emarket discountInfo(%discount_id%)%

%currency-prices%


END;

$FORMS['price_original'] = <<<END
<p>
	<strike>%prefix%&nbsp;%original%&nbsp;%suffix%</strike>
</p>
END;

$FORMS['price_actual'] = <<<END
	%prefix%&nbsp;%actual%&nbsp;%suffix%
END;

$FORMS['order_block'] = <<<END
    <div style="">
        %customer%            
    </div>
    <div style="">
         %data getPropertyGroupOfObject(%delivery_address%,'common', 'adress')%
    </div>
    <h3 style="margin: 20px 0 10px 0; color: #7A500E;">Покупки в заказе</h3>
    <table style="text-align: left;" width="100%" border="0">
        <thead>
            <tr style="font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 2px;">
                <th>Наименования</th>
                <th>Кол-во</th>     
                <th>Цена</th>
                <th>Сумма</th>
            </tr>
        </thead>
        <tbody>
                %items%
                <tr style="border: none;">
                    <td colspan="3" style="padding-top: 20px; text-align:right; font-weight: bold;  padding-right: 10px;">
                        Доставка:
                    </td>
                    <td width="75px" style="padding-top: 20px;">
                        %delivery-price%
                    </td>
                </tr>
                <tr style="border: none; padding-top: 10px;">
                    <td colspan="3" style="padding-top: 10px; text-align:right; font-weight: bold; padding-right: 10px;" width="498">
                        <b>Итого:</b>
                    </td>
                    <td width="75px" style="padding-top: 10px;">
                        %total_price% руб
                    </td>
                </tr>
        </tbody>
    </table>
    <br />
END;

$FORMS['order_item'] = <<<END
<tr>
	<td style="text-align: left;">
		%name%
	</td>
	<td>
		%amount%
	</td>
	<td>
		%price%
	</td>
	<td>
		%total-price%
	</td>
</tr>
END;

$FORMS['options_block'] = <<<END
 %items%
END;

$FORMS['options_block_empty'] = "---";

$FORMS['options_item'] = <<<END
%name% +%price%%list-comma%
END;


?>