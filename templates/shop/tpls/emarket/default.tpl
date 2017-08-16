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
<!-- %currency_name% -->
<p>
	<strike>%prefix%&nbsp;%original%&nbsp;%suffix%</strike>
</p>
END;

$FORMS['price_actual'] = <<<END
<!-- %currency_name% -->
	%prefix%&nbsp;%actual%&nbsp;%suffix%
END;

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
                <tr>
                        <td style="text-align: right;" colspan="4">
                                Итого:
                        </td>
                        <td colspan="2" style="text-align: left;">
                                %total-price%
                        </td>
                </tr>
        </tbody>
    </table>
	<div style="color: #E29E37; margin-bottom: 10px; text-align: right;">%custom freeDelivery(%total_price%)%</div>
        <form id="webform" action="%pre_lang%/emarket/saveinfo/" onsubmit="saveFormData(this); return true;">
        <input type="hidden" name="system_form_id" value="" />
        <input type="hidden" name="system_template" value="" />
        %content showTabakContent('basket')%
        <div style="">
            <table cellspacing="1" cellpadding="1" width="100%" border="0">
                %emarket personalInfo('onestep_shop')%
            </table>
        </div>
        <div>
             %emarket deliveryList('onestep')%
        </div>
        <div>
            %emarket deliveryAddressesList('onestep')%
        </div>
        <div class="clear"></div>
        <div style="margin-left: 30px;">
            %emarket paymentsList('onestep')%
        </div>
        <input class="f_fld" type="text" name="fname_" value="" />
      <input id="order_submit_btn" type="submit" value="Оформить заказ" />
      
    </form>
	<div class="order_message">После оформления заказа с Вами свяжется наш менеджер.</div>
    <script type="text/javascript">
        restoreFormData(document.getElementById('webform'));
    </script>
END;

$FORMS['order_item'] = <<<END
<tr>
	<td>
		<div>
			%data getProperty(%element_id%,'photo', 'photo')%
		</div>
	</td>
	<td style="text-align: left;">
		<a href="//%domain%%link%">%name%</a>
	</td>
	<td>
    %emarket gift_true(%element_id%,'<input type="text" rel="%element_id%" class="basket_amount" value="%amount%" />', 1 )%
	</td>

	<td>
		%price%
	</td>

	<td>
		%total-price%
	</td>

	<td>
		<a class="del_item" rel="%id%" href="/emarket/basket/remove/item/%id%/">
			<img src="/templates/shop/images/icons/gtk-close.png" />
		</a>
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

$FORMS['order_block_empty'] = <<<END
<p>Корзина пуста</p>
END;


$FORMS['purchase'] = <<<END
%purchasing%
END;


$FORMS['orders_block'] = <<<END
<p><b>Список ваших заказов:</b></p>
<table cellpadding="0" cellspacing="0" style="text-align: left">
	<tbody>
		%items%
	</tbody>
</table>
END;

$FORMS['orders_block_empty'] = <<<END
<p>Заказов нет</p>
END;

$FORMS['orders_item'] = <<<END
	<tr>
		<td class="first">
			%name% (%id%)
		</td>
		<td>
			%order_items%
		</td>
		<td class="fix">
			%total_price% руб
		</td>
	</tr>
END;

$FORMS['basket_in_stock_block'] = <<<END
    <div class="itemMiniViewPriceWrapper">
        <div class="itemMiniViewBuyButton">
            <a href="/emarket/basket/put/element/%id%/" rel="%id%" class="smallBuyBtn">
                <span class="caption">В корзину</span>
                <img src="/templates/shop/images/addToBasket.gif" class="processImg" />
            </a>
        </div>
        <div class="itemMiniViewPrice">
            <span class="itemMiniViewPriceValue">%price%</span>&nbsp;<span>руб.</span>
        </div>
    </div>
END;

$FORMS['basket_out_stock_block'] = <<<END
    <div class="itemMiniViewPriceWrapper">
        <div class="itemMiniViewBuyButton">
            <a href="#" class="no_stock" rel="%id%">Узнать о поступлении</a>
        </div>
        <div class="itemMiniViewPrice price_no_stock">
            <span class="itemMiniViewPriceValue">%price%</span>&nbsp;<span>руб.</span>
        </div>
    </div>
END;

// Большая карточка товара
$FORMS['basket_in_stock_block_cart'] = <<<END
    <div class="shopping">
        <div class="priceBlock">
            Цена:
            <div class="currentPrice">
                <span itemprop="price" umi:field-name="price" umi:element-id="%id%">%price%</span> <span itemprop="priceCurrency" content="RUB">руб.</span>
            </div>
        </div>
        <div style="margin-bottom: 10px;" class="buyBlock">
            Количество:
            <input type="text" value="1" class="amount_input" name="amount" id="amount_%id%"><span>шт.</span>
        </div>
        <a rel="%id%" class="bigBuyBtnOrange" href="/emarket/basket/put/element/%id%/">
            <span class="caption">В корзину</span>
            <img src="/templates/shop/images/orangeBigLoader.gif" class="loader">
        </a>
    </div>
END;
// Большая карточка товара
$FORMS['basket_out_stock_block_cart'] = <<<END
    <div id="price_block_wrapper">
        <div class="shopping">
            <div class="priceBlock">
                Цена:
                <div class="currentPrice">
                    <span itemprop="price" umi:field-name="price" umi:element-id="%id%">%price%</span> <span itemprop="priceCurrency" content="RUB">руб.</span>
                </div>
            </div>
            <div style="margin-bottom: 10px;" class="buyBlock">
                Количество:
                <input type="text" value="0" class="amount_input" name="amount" id="amount_%id%" disabled><span>шт.</span>
            </div>
            <a rel="%id%" class="bigBuyBtnGray" href="#">
                <span class="caption">Узнать о поступлении</span>
            </a>
        </div>
    </div>
END;


$FORMS['purchase_successful'] = <<<END
<p>
Спасибо Вам за оформление заказа на нашем сайте.
</p>
<p>
Мы отправили Вам на почту письмо с номером и подробностями заказа.
</p>
<p>
Наши менеджеры свяжутся с Вами в ближайшее время, сразу после обработки заказа.
</p>
<br />
<p>----------------------------------------</p>
С уважением, отдел продаж Кальян-Хат<br />
г. Москва, Нижняя Первомайская, д. 45<br />
+7 (495) 210 17 79
END;

$FORMS['purchase_failed'] = <<<END
<p>Не удалось добавить заказ</p>
END;

$FORMS['personal'] = <<<END
	%emarket ordersList()%
END;

?>