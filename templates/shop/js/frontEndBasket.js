var frontEndBasket = {
	replaceBasket : function(id) {
		return function(e) {
			var text, rem_item = true, item_total_price;
			if (e.summary.amount > 0) {
				text = e.summary.price.actual + ' ' + e.summary.price.suffix + '.';
				for (var i in e.items.item) {
					var item = e.items.item[i];
					if (item.id == id) {
						rem_item = false;
						item_total_price = item["total-price"].actual + ' ' + item["total-price"].suffix + '.';
					}
				}
				if (rem_item) {
					if (jQuery('.cart_item_' + id)) {
						jQuery('.cart_item_' + id).remove();
						jQuery('.cart_summary').text(text);
					}
				}
				else {
					jQuery('.cart_item_price_' + id).text(item_total_price);
					jQuery('.cart_summary').text(text);
				}
				text = e.summary.amount + ' шт товаров на сумму ' + text;
			}
			else {
				text = 'В корзине нет ни одного товара.';
				if (jQuery('.basket')) {
					jQuery('.basket').text(text);
				}
			}
			jQuery('.basket_info_summary').text(text);
		};
	},
	add : function(id, form, popup) {
		var e_name, options = {};
		if (form) {
			var elements = jQuery(':radio:checked', form);
			for (var i = 0; i < elements.length; i++) {
				e_name = elements[i].name.replace(/^options\[/, '').replace(/\]$/, '');
				options[e_name] = elements[i].value;
			}
		}
		basket.putElement(id, options, frontEndBasket.replaceBasket(id));
		if (popup) jQuery('#add_options').remove();
	},
	addFromList : function(id, is_options) {
		if (is_options) {
			jQuery.ajax({
				url: '/upage//'+id+'?transform=modules/catalog/popup-add-options.xsl',
				dataType: 'html',
				success: function(data) {
					jQuery("<div/>", {
						"id": "add_options",
						"class": "infoblock",
						html: "<div class=\"title\">\
							<img src=\"/images/cms/eip/close.png\" alt=\"Закрыть\" title=\"Закрыть\" />\
							<h2>Выбор опций</h2></div><div class=\"body\">"+data+"</div>"}).appendTo("body");
					var popup = jQuery('#add_options');
					var windowHeight = window.innerHeight || window.document.documentElement.offsetHeight;
					var topPosition  = $(window.document.documentElement).scrollTop() || $(window.document).scrollTop();
					topPosition      = topPosition + (windowHeight - popup.height()) / 2;
					popup.css('top', topPosition+ 'px');
					jQuery('div.title img', '#add_options').click(function(){popup.remove();});
				}
			});
		}
		else {
			frontEndBasket.add(id);
		}
	},
	modify : function(id, amount_new, amount_old) {
		if (amount_new.replace(/[\d]+/) == 'undefined' && amount_new != amount_old) {
			basket.modifyItem(id, {amount:amount_new}, frontEndBasket.replaceBasket(id));
		}
	},
	remove : function(id) {
		basket.removeItem(id, frontEndBasket.replaceBasket(id));
	}
};