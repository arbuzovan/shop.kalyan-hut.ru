site.basket = {};

site.basket.replace = function(id) {
	return function(e) {
		var text, discount, goods_discount_price, goods_discount, item_total_price, item_discount, cart_item, basket, i, item,
			cart_summary = jQuery('.cart_summary'),
			cart_discount = jQuery('.cart_discount'),
			goods_discount_price = jQuery('.cart_goods_discount'),
			add_basket_button_text = 'В корзине',
			rem_item = true,
			detect_options = {};

		if (e.summary.amount > 0) {
			text = e.summary.price.actual + ' ' + e.summary.price.suffix;
			goods_discount = ((typeof e.summary.price.original == 'undefined') ? e.summary.price.actual : e.summary.price.original) + ' ' + e.summary.price.suffix;
			discount = ((typeof e.summary.price.discount != 'undefined') ? e.summary.price.discount : '0') + ' ' + e.summary.price.suffix;
			for (i in e.items.item) {
				item = e.items.item[i];
				if (item.id == id) {
					rem_item = false;
					item_total_price = item["total-price"].actual + ' ' + item["total-price"].suffix;
					item_discount = ((typeof item.discount != 'undefined') ? item.discount.amount : '0') + ' ' + item["total-price"].suffix;
				}
				if (item.page.id == id) {
					if (detect_options.amount) {
						detect_options.amount = detect_options.amount + item.amount;
					}
					else detect_options = {'id':id, 'amount':item.amount};
				}
			}
			if (detect_options.amount) {
				var add_basket_button = jQuery('#add_basket_' + detect_options.id);
				if (add_basket_button[0].tagName.toUpperCase() == 'A') {
					add_basket_button.text(add_basket_button_text + ' (' + detect_options.amount + ')');
				}
				else add_basket_button.val(add_basket_button_text + ' (' + detect_options.amount + ')');
			}
			if (rem_item) {
				if (cart_item = jQuery('.cart_item_' + id)) {
					cart_item.remove();
					cart_summary.text(text);
					cart_discount.text(discount);
					goods_discount_price.text(goods_discount);
				}
			}
			else {
				jQuery('.cart_item_price_' + id).text(item_total_price);
				jQuery('.cart_item_discount_' + id).text(item_discount);
				cart_summary.text(text);
				cart_discount.text(discount);
				goods_discount_price.text(goods_discount);
			}
			text = '<div class="total_products">Всего: <span>'+e.summary.amount+'</span> товаров</div><div class="total">на сумму: <span>'+text+'</span></div>';
		}
		else {
			text = 'В корзине пусто';
			if (basket = jQuery('.basket')) {
				basket.text(text);
			}
		}
		jQuery('.basket_info_summary').html(text);
	};
};

site.basket.add = function(id, form, popup) {
	var e_name, options = {};
	if (form) {
		var elements = jQuery(':radio:checked', form);
		for (var i = 0; i < elements.length; i++) {
			e_name = elements[i].name.replace(/^options\[/, '').replace(/\]$/, '');
			options[e_name] = elements[i].value;
		}
	}
	$.jGrowl('Товар добавлен в корзину.');
	basket.putElement(id, options, this.replace(id));
	if (popup) {
		//jQuery('#add_options_' + id).togglePopup2();
		$('#popup_reference').togglePopup2();
	}
};

site.basket.list = function(link) {
	var id = (link.id.indexOf('add_basket') != -1) ? link.id.replace(/^add_basket_/, '') : link;
	if (!id) return false;
	if (jQuery(link).hasClass('options_true')) {
		if (jQuery('#add_options_' + id).length == 0) {
			jQuery.ajax({
				url: '/upage//' + id + '?transform=modules/catalog/popup-add-options.xsl',
				dataType: 'html',
				success: function (data) {
					//site.message({
					//	id: 'add_options_' + id,
					//	header: 'Выбор опций',
					//	width: 400,
					//	content: data
					//});
					x = $('<div class="reference">').html('<a href="#" onclick="$(\'#popup_reference\').togglePopup2(); return false;" class="close"></a>'+data).wrap('<div>');
					x.togglePopup2();
				}
			});
		}
	}
	else this.add(id);
};
$('form.options').submit(function(){
	
})
site.basket.modify = function(id, amount_new, amount_old) {
	if (amount_new.replace(/[\d]+/) == 'undefined' && amount_new != amount_old) {
		basket.modifyItem(id, {amount:amount_new}, this.replace(id));
	}
};

site.basket.remove = function(id) {
	if (id == 'all') basket.removeAll(this.replace(id));
	else basket.removeItem(id, this.replace(id));
};

site.basket.init = function() {
	jQuery('.basket_list').click(function(){
		site.basket.list(this);
		return false;
	});
	jQuery('div.basket a.del').click(function(){
		site.basket.remove(this.id);
		return false;
	});
	jQuery('div.basket a.basket_remove_all').click(function(){
		site.basket.remove('all');
		return false;
	});
};

jQuery(document).ready(function(){site.basket.init()});