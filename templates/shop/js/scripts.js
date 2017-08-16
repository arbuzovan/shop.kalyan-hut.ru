function Init() {
    size(1, 950, 0);
    size(2, 292, 108);
    size(3, 370, 45);
    size(4, 250, 45);
    size(5, Math.max(((navigator.userAgent.indexOf('iP') > 0) ? w(1) + 30 : screen.availWidth - 17), w(1)), 48);
    size(6, 256, 70);
    size(7, w(6), 0);
    size(8, 720, 310);
    size(9, w(8), 350);
    size(10, w(7) - 40, 0);
    size(11, w(8), 0);
    size(12, w(10), 280);
    size(13, w(11), 0);
    size(14, w(13), 0);
    size(15, w(1), 0);
    size(16, w(1), 40);
    size(17, 350, 70);
    size(18, 185, 70);
    size(19, 385, 70);
    size(20, w(5), 0);
    size(21, w(5), 0);
    size(22, 30, 30);
    move(1, (screen.availWidth - w(1) - 17) >> 1, 0);
    move(2, befx(1), 0);
    move(3, aftx(2) + 65, 40);
    move(4, aftx(1) - w(4), befy(3));
    move(5, 0, afty(2) + 35);
    move(6, befx(1), afty(5) + 20);
    move(7, befx(6), afty(6));
    move(8, aftx(1) - w(8), befy(6) + 20);
    move(9, befx(8), afty(8) + 30);
    move(10, befx(7), Math.max(afty(7), afty(9)) + 30);
    move(11, befx(8), afty(9) + 40);
    move(12, befx(10), afty(10) + 25);
    move(13, befx(11), afty(11) + 40);
    move(14, befx(13), afty(13) + 50);
    move(15, befx(1), Math.max(afty(12), afty(14)) + 40);
    move(16, befx(1), afty(15) + 15);
    move(17, befx(1), afty(16));
    move(18, aftx(17) + 22, befy(17));
    move(19, aftx(1) - w(19), befy(17));
    move(20, 0, 0);
    move(21, 0, 0);
    move(22, befx(4) + w(4) - ($('#div4 a:eq(0)').width() + $('#div4 span.b').width()) - 37, befy(4));
    size(20, w(5), afty(19));
    size(21, w(5), afty(19));
    div(8).everyTime(5000, function() {
        slide1(parseInt($('div.slide_p a.now').html()) % 5)
    })
}

function slide1(i) {
    var w = $('.slider1').width();
    $('.slider1 ul').animate({
        'margin-left': -i * w + 'px'
    }, 1500);
    $('.slider1 .slide_p a').removeClass('now').eq(i).addClass('now');
}
anim = true;

function slide2(b) {
    var max = 3;
    var count = $('.slider2 .slide ul li').length;
    var w = $('.slider2 .slide ul li:eq(0)').width();
    var now = parseInt($('.slider2 .slide ul').css('margin-left'));
    if (anim)
        if (b) {
            if (now >= -(count - max - 1) * w) {
                anim = false;
                $('.slider2 .slide ul').animate({
                    'margin-left': now - w + 'px'
                }, 1000, function() {
                    anim = true
                });
            }
        } else
    if (now < 0) {
        anim = false;
        $('.slider2 .slide ul').animate({
            'margin-left': now + w + 'px'
        }, 1000, function() {
            anim = true
        });
    }
}
var hwSlideSpeed = 700;
var hwTimeOut = 3000;
var hwNeedLinks = true;
var reccBuyArray = [];
$(document).ready(function(e) {
    $('.gallery').fancybox();
    $('.lic').live('click', function() {
        var pageId = $(this).attr('rel');
        $.ajax({
            url: "/content/getPageContent/",
            data: {
                'pageId': pageId
            },
            type: "POST",
            dataType: 'html',
            success: function(data) {
                $.fancybox({
                    content: data
                })
            }
        });
        return false;
    });
    $("#licence_doc").bind('click', function() {
        var pageId = $(this).attr('rel');
        $.ajax({
            url: "/content/getPageContent/",
            data: {
                'pageId': pageId
            },
            type: "POST",
            dataType: 'html',
            success: function(data) {
                if (data == 'lic') {
                    return false;
                }
                $.fancybox({
                    content: data
                })
            }
        });
        return false;
    });
    $('.gift-popup__close').click(function() {
        $('#gift-popup').hide(200);
        $.cookie('gift_modal', 'true', {
            expires: 1,
            path: '/'
        });
        return false;
    });
    if ($.cookie('allowview') == undefined && document.location.pathname != '/rules/') {
        var n = noty({
            text: "\
                    <div>\
                            <p style='font-size: 15px;'><strong>Просмотр данного сайта разрешен только лицам, достигшим возраста 18 лет.</strong></p>\
                             <br>\
                            <p>Нажав на кнопку &laquo;Продолжить&raquo; Вы подтверждаете, что Вам исполнилось 18 лет, принимаете&nbsp;условия <a href='/rules/'>пользовательского соглашения</a>, а также &nbsp;выражаете свое требование, в качестве&nbsp;Покупателя, на ознакомление с перечнем продаваемой продукции, содержащим табачные&nbsp;изделия. &nbsp;</p>\
                            <p style='font-size: 10px;'><em>(в соответствии с требованиями ст. 19 Федерального закона от 23.02.2013 года N 15-ФЗ &quot;Об охране здоровья&nbsp;граждан от воздействия окружающего табачного дыма и последствий потребления табака&quot;. )<em></p>\
                    </div>\
            ",
            type: 'warning',
            modal: true,
            layout: 'top',
            dismissQueue: true,
            buttons: [{
                addClass: 'btn btn-primary',
                text: 'Выйти',
                onClick: function($noty) {
                    window.document.location.href = 'https://yandex.ru/search/?text=здоровый%20образ%20жизни'
                    $noty.close();
                }
            }, {
                addClass: 'btn btn-danger',
                text: 'Продолжить',
                onClick: function($noty) {
                    $.cookie('allowview', 'true', {
                        path: '/'
                    });
                    $noty.close();
                }
            }],
            animation: {
                open: 'animated bounceInDown',
                close: 'animated bounceOutUp',
                easing: 'swing',
                speed: 500
            }
        });
    }
    $("#search_block").find('table:odd').each(function(element) {
        $(this).css('float', 'right');
    });
    $('#countElements').change(function() {
        var count = $(this).val();
        var loc = '' + window.location;
        var pos = loc.indexOf('?count');
        if (-1 < pos) {
            var location_new = loc.slice(0, pos);
            location_new += '?count=' + count;
        } else {
            var location_new = loc + '?count=' + count;
        }
        window.location.replace(location_new)
    });
    $.ajax({
        url: '/udata://emarket/cart/.json',
        type: 'POST',
        dataType: "json",
        success: function(data) {
            if (data.summary.price.actual < 2000) {
                $('#delivery_noty').remove()
                $('input[name=delivery-id][value=15631]').prop('disabled', true);
                $('input[name=delivery-id][value=15631]').parent().css('color', '#9d9d9d');
                $('input[name=delivery-id][value=15631]').parent().append('<div id="delivery_noty" style="color:#EA4921">Доставка в регионы возможна только при стоимости заказа от 2000 рублей.</div>')
            }
        }
    });
    $('#countElementsLinks > a').click(function() {
        var count = $(this).attr('rel');
        var loc = '' + window.location;
        var pos = loc.indexOf('?count');
        if (-1 < pos) {
            var location_new = loc.slice(0, pos);
            location_new += '?count=' + count;
        } else {
            var location_new = loc + '?count=' + count;
        }
        window.location.replace(location_new)
        return false;
    });
    $(document).on('click','.smallBuyBtn, .bigBuyBtnOrange, .smallBuyBtnOrange',function() {
        var buyBtn = $(this);
        var rel = $(buyBtn).attr('rel');
        $(buyBtn).find('.caption').toggle();
        $(buyBtn).find('.loader').toggle();
        $(buyBtn).find('.processImg').toggle();
        if ($('#amount_' + rel).length > 0) {
            amount = $('#amount_' + rel).val();
        } else {
            amount = 1;
        }
        
        yaCounter1717901.reachGoal('addToCart');
        
        $.ajax({
            url: '/udata' + $(this).attr('href') + '.json',
            type: 'POST',
            dataType: 'json',
            data: {
                'amount': amount
            },
            success: function(data) {
                $(buyBtn).find('.caption').toggle();
                $(buyBtn).find('.loader').toggle();
                $(buyBtn).find('.processImg').toggle();
                var TotalAmount = data['summary']['amount'];
                var Price = data['summary']['price']['actual'];
                var Suffix = data['summary']['price']['suffix'];
                TotalAmount_lastnum = parseInt(TotalAmount.toString().slice(-1));
                Price_lastnum = parseInt(Price.toString().slice(-1));
                var ending = '';
                var price_ending = '';
                if (TotalAmount_lastnum >= 2 && TotalAmount_lastnum <= 4) {
                    ending = 'а';
                }
                if (TotalAmount_lastnum >= 5 || TotalAmount_lastnum == 0) {
                    ending = 'ов';
                }
                if (Price_lastnum == 1) {
                    price_ending = 'рубль';
                }
                if (Price_lastnum >= 2 && Price_lastnum <= 4) {
                    price_ending = 'рубля';
                }
                if (Price_lastnum >= 5 || Price_lastnum == 0) {
                    price_ending = 'рублей';
                }
                Price = number_format(Price, '', '.', ' ');
                $("#container").notify("create", {
                    title: 'Товар добавлен в корзину',
                    text: 'В корзине <b>' + TotalAmount + '</b> товар' + ending + '<br />' + 'На сумму <b>' + Price + '</b> ' + price_ending
                });
                if (TotalAmount > 0 && $("#cart_text").text() != 'Ваша корзина') {
                    $("#cart_text").html('<a href="/emarket/cart/">Ваша корзина</a>');
                }
                $("#amount").text("( " + TotalAmount + " )");
            }
        });




        
        return false;
    });
    $(".no_stock, .bigBuyBtnGray").click(function() {
        var ItemId = $(this).attr('rel');
        var form = '';
        form += '<div style="text-align: center">';
        form += '<div>Укажите свой email и мы сообщим Вам, когда товар появится в наличии</div>';
        form += '<input id="notifycationSubscribeEmail" class="amount_input" style="width: 250px; text-align:center;" type="text">';
        form += '<br />';
        form += '<div><a class="notifycationSubscribe" style="position: relative; margin-top: 5px; top: 0px;" rel="' + ItemId + '" href="#">Отправить</a></div>';
        form += '</div>';
        $.fancybox({
            content: form,
            title: 'Подписаться на оповещение о поступлении'
        });
        return false;
    });
    $(".notifycationSubscribe").live('click', function() {
        var ItemId = $(this).attr('rel');
        var emailInput = $('#notifycationSubscribeEmail').val();
        var href = '/catalog/setReminder/' + ItemId + '/';
        $.ajax({
            'url': href,
            'data': {
                'id': ItemId,
                'email': emailInput
            },
            success: function(data) {
                $(".reminder_block").fadeOut();
                $(emailInput).val('');
                $.fancybox({
                    'content': '<center>Мы получили Вашу заявку.<br />Вы получите оповещение при поступлении данного товара на склад</center>'
                })
            }
        })
        return false;
    });
    $('#tab_wrapper > a').click(function() {
        var click_id = $(this).attr('id');
        if (click_id != $('#tab_wrapper a.active').attr('id')) {
            $('#tab_wrapper a').removeClass('active');
            $(this).addClass('active');
            $('#tab_wrapper div').removeClass('active');
            $('#con_' + click_id).addClass('active');
        }
        return false
    });
    $("#ya_fancy_map").bind('click', function() {
        var adress = 'Москва, ул. Нижняя Первомайская, д. 45';
        $("#YaMap").height(500);
        $("#YaMap").width(600);
        $("#YaMap").html('');
        $.fancybox({
            content: $("#YaMap"),
            title: 'Как нас найти',
            beforeLoad: function() {
                ymaps.ready(init);

                function init() {
                    ymaps.geocode(adress, {
                        results: 1
                    }).then(function(res) {
                        var firstGeoObject = res.geoObjects.get(0);
                        var myMap = new ymaps.Map("YaMap", {
                            center: firstGeoObject.geometry.getCoordinates(),
                            zoom: 15
                        });
                        ymaps.geocode(myMap.getCenter(), {
                            boundedBy: myMap.getBounds()
                        }).then(function(res) {
                            myMap.geoObjects.add(firstGeoObject);
                            myMap.controls.add('zoomControl').add('typeSelector').add('smallZoomControl', {
                                right: 5,
                                top: 75
                            }).add('mapTools');
                            myMap.controls.add(new ymaps.control.ScaleLine()).add(new ymaps.control.MiniMap({
                                type: 'yandex#publicMap'
                            }));
                        });
                    }, function(err) {
                        alert(err.message);
                    });
                }
            }
        })
        return false;
    });
    $('.slideb').css({
        "position": "absolute",
        "top": '0',
        "left": '0'
    }).hide().eq(0).show();
    if ($("#lname2").length > 0) {
        $("#lname2").attr('value', '_______');
        $("#lname2").hide();
        $("#lname2").parents('tr').hide();
    }
    $("input[name='data[new][data_dostavki]']").datepicker();
    $(".basket_amount").bind('keyup', function() {
        $.ajax({
            url: '/udata/emarket/cust_basket/modify/element/' + $(this).attr('rel') + '/.json?amount=' + this.value,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                window.setTimeout(function() {
                    javascript: window.location.reload();
                }, 5000)
            }
        });
    });
    var hideTimer = false;
    $("#basket_link").hover(function() {
        if (hideTimer) {
            clearTimeout(hideTimer);
        }
        $("#basket_items").show('fade', 'slow');
        $.ajax({
            url: '/emarket/basket_popup/',
            type: 'get',
            success: function(data) {
                $("#basket_items").html(data)
            }
        })
    }, function() {
        hideTimer = setTimeout(function() {
            $("#basket_items").hide('fade', 'fast')
        }, 900);
    })
    $("#basket_items").hover(function() {
        clearTimeout(hideTimer);
    }, function() {
        hideTimer = setTimeout(function() {
            $("#basket_items").hide('fade', 'fast')
        }, 900);
    })
    $("#container").notify({
        speed: 500,
        expires: 1500
    });
    $(".btn").bind('click', function() {
        var oLink = this;
        var oLink_innerHTML = $(oLink).clone().html();
        if ($(".btn").length > 1) {
            $(oLink).html('<img style="margin: 3px; padding: 0px;" src="/templates/shop/images/294.gif" />');
        } else {
            $(oLink).html('<img style="margin: 3px; padding: 0px;" src="/templates/shop/images/295.gif" />');
        }
        $.ajax({
            url: '/udata' + $(oLink).attr('href') + '/.json',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var TotalAmount = data['summary']['amount'];
                var Price = data['summary']['price']['actual'];
                var Suffix = data['summary']['price']['suffix'];
                TotalAmount_lastnum = parseInt(TotalAmount.toString().slice(-1));
                Price_lastnum = parseInt(Price.toString().slice(-1));
                var ending = '';
                var price_ending = '';
                if (TotalAmount_lastnum >= 2 && TotalAmount_lastnum <= 4) {
                    ending = 'а';
                }
                if (TotalAmount_lastnum >= 5 || TotalAmount_lastnum == 0) {
                    ending = 'ов';
                }
                if (Price_lastnum == 1) {
                    price_ending = 'рубль';
                }
                if (Price_lastnum >= 2 && Price_lastnum <= 4) {
                    price_ending = 'рубля';
                }
                if (Price_lastnum >= 5 || Price_lastnum == 0) {
                    price_ending = 'рублей';
                }
                Price = number_format(Price, '', '.', ' ');
                $("#container").notify("create", {
                    title: 'Товар добавлен в корзину',
                    text: 'В корзине <b>' + TotalAmount + '</b> товар' + ending + '<br />' + 'На сумму <b>' + Price + '</b> ' + price_ending
                });
                if (TotalAmount > 0 && $("#cart_text").text != 'Ваша корзина') {
                    $("#cart_text").text('Ваша корзина');
                    $("#cart_text").parent('a').removeAttr('nohref');
                    $("#cart_text").parent('a').attr('href', '/emarket/cart/');
                }
                $("#amount").text("( " + TotalAmount + " )");
                $(oLink).html('');
                $(oLink).html(oLink_innerHTML);
            }
        })
        return false;
    });
    var slideNum = 0;
    var slideTime;
    slideCount = $("#slider .slideb").size();
    var animSlide = function(arrow) {
        clearTimeout(slideTime);
        $('.slideb').eq(slideNum).fadeOut(hwSlideSpeed);
        if (arrow == "next") {
            if (slideNum == (slideCount - 1)) {
                slideNum = 0;
            } else {
                slideNum++;
            }
        } else if (arrow == "prew") {
            if (slideNum == 0) {
                slideNum = slideCount - 1;
            } else {
                slideNum -= 1;
            }
        } else {
            slideNum = arrow;
        }
        $('.slideb').eq(slideNum).fadeIn(hwSlideSpeed, rotator);
        $(".control-slide.active").removeClass("active");
        $('.control-slide').eq(slideNum).addClass('active');
    }
    if (hwNeedLinks) {
        var $linkArrow = $('<a id="prewbutton" href="#"></a><a id="nextbutton" href="#"></a>').prependTo('#slider');
        $('#nextbutton').click(function() {
            animSlide("next");
            return false;
        })
        $('#prewbutton').click(function() {
            animSlide("prew");
            return false;
        })
    }
    var $adderSpan = '';
    $('.slideb').each(function(index) {
        $adderSpan += '<span class = "control-slide">' + index + '</span>';
    });
    $('<div class ="sli-links">' + $adderSpan + '</div>').appendTo('#slider-wrap');
    $(".control-slide:first").addClass("active");
    $('.control-slide').click(function() {
        var goToNum = parseFloat($(this).text());
        animSlide(goToNum);
    });
    var pause = false;
    var rotator = function() {
        if (!pause) {
            slideTime = setTimeout(function() {
                animSlide('next')
            }, hwTimeOut);
        }
    }
    $('#slider-wrap').hover(function() {
        clearTimeout(slideTime);
        pause = true;
    }, function() {
        pause = false;
        rotator();
    });
    rotator();
    if ($("#new_adress_btn")) {
        $(".new_adress_input_fld").each(function(index, element) {
            $(element).bind('keyup', function() {
                if ($("#new_adress_btn").attr('checked') != 'checked') {
                    $("#new_adress_btn").attr('checked', true);
                }
            })
        })
    }

    $('input[name=delivery-id]').bind('click', function() {
        switch (this.value) {
            case '53976':
                $(".adress").slideUp();
                var fldArray = [];
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $("#street_fld_row").find('input').attr('value', 'Самовывоз Первомайская');
                $("#house_fld_row").find('input').attr('value', 'Самовывоз Первомайская');
                for (var i = 0; i < fldArray.length; i++) {
                    $("#" + fldArray[i] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][" + fldArray[i] + "]']").addClass('required');
                }
                break;
            case '273231':
                $(".adress").slideUp();
                var fldArray = [];
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $("#street_fld_row").find('input').attr('value', 'Самовывоз Багратионовская ');
                $("#house_fld_row").find('input').attr('value', 'Самовывоз Багратионовская ');
                for (var i = 0; i < fldArray.length; i++) {
                    $("#" + fldArray[i] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][" + fldArray[i] + "]']").addClass('required');
                }
                break;
            case '1543284':
                $(".adress").slideUp();
                var fldArray = [];
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $("#street_fld_row").find('input').attr('value', 'Самовывоз Савеловская ');
                $("#house_fld_row").find('input').attr('value', 'Самовывоз Савеловская ');
                for (var i = 0; i < fldArray.length; i++) {
                    $("#" + fldArray[i] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][" + fldArray[i] + "]']").addClass('required');
                }
                break;
            case '1801333':
                $(".adress").slideUp();
                var fldArray = [];
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $("#street_fld_row").find('input').attr('value', 'Самовывоз Водный стадион ');
                $("#house_fld_row").find('input').attr('value', 'Самовывоз Водный стадион ');
                for (var i = 0; i < fldArray.length; i++) {
                    $("#" + fldArray[i] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][" + fldArray[i] + "]']").addClass('required');
                }
                break;
            case '5036':
                $(".adress").slideDown();
                $("#city_fld_row").hide();
                $("#city_fld_row").find('input').attr('value', 'Москва');
                $("#street_fld_row").find('input').attr('value', '');
                $("#house_fld_row").find('input').attr('value', '');
                $("#index_fld_row").hide();
                var fldArray = [];
                fldArray.push('street');
                fldArray.push('house');
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $(fldArray).each(function(index, element) {
                    $("#" + fldArray[index] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][street]']").addClass('required');
                });
                break;
            case '5036':
                $(".adress").slideDown();
                $("#city_fld_row").show();
                $("#index_fld_row").hide();
                $("#street_fld_row").find('input').attr('value', '');
                $("#house_fld_row").find('input').attr('value', '');
                var fldArray = [];
                fldArray.push('street');
                fldArray.push('house');
                fldArray.push('fname');
                fldArray.push('phone');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $(fldArray).each(function(index, element) {
                    $("#" + fldArray[index] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][street]']").addClass('required');
                });
                break;
            case '15631':
                $(".adress").slideDown();
                $("#city_fld_row").show();
                $("#index_fld_row").show();
                $("#street_fld_row").find('input').attr('value', '');
                $("#house_fld_row").find('input').attr('value', '');
                var fldArray = [];
                fldArray.push('city');
                fldArray.push('index');
                fldArray.push('street');
                fldArray.push('house');
                fldArray.push('fname');
                fldArray.push('lname2');
                fldArray.push('phone');
                fldArray.push('e-mail');
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                for (var i = 0; i < fldArray.length; i++) {
                    $("#" + fldArray[i] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][" + fldArray[i] + "]']").addClass('required');
                }
                break;
            case '71409':
                $(".adress").slideDown();
                $("#city_fld_row").show();
                $("#index_fld_row").hide();
                var fldArray = [];
                fldArray.push('city');
                fldArray.push('street');
                fldArray.push('house');
                fldArray.push('fname');
                fldArray.push('phone');
                $("#city_fld_row").find('input').attr('value', '');
                $("#index_fld_row").hide();
                $('.required_asteriks').html('');
                $("input").removeClass('required');
                $(fldArray).each(function(index, element) {
                    $("#" + fldArray[index] + "_fld_row > td").eq(0).find('.required_asteriks').html('*');
                    $("input[name='data[new][street]']").addClass('required');
                });
                break;
            default:
                $("#city_fld_row").show();
                $("#index_fld_row").show();
                $(".adress").slideDown();
                break;
        }
    });
    $("#order_submit_btn").bind('click', function() {
        var flag = true;
        $(".required").each(function() {
            if ($(this).attr('value') == '') {
                alert($(this).parent('td').prev('td').text() + " не заполнено.");
                $(this).trigger('focus');
                flag = false;
                return false
            }
        });
        if (!flag) {
            return false;
        }
    })
    $('input[name=delivery-address]').bind('click', function() {
        if (this.id != 'new_adress_btn') {
            $("#new_adress_tbl").slideUp();
        } else {
            $("#new_adress_tbl").slideDown();
        }
    });
    if (getParameterByName('_err') != '') {
        var error_message = $("#errors_list").html();
        $.fancybox({
            title: 'Ошибка при заполнении полей',
            content: '<div id="fancy_error">' + error_message + '</div>'
        });
    }
    $("#dispatches_form").bind('submit', function() {
        $.ajax({
            url: '/dispatches/subscribe_for_gift/',
            data: $("#dispatches_form").serialize(),
            type: 'POST',
            success: function(data) {
                if (data == 'ok') {
                    $.fancybox({
                        content: '<center>Вы успешно подписаны на рассылку.<br />Свой подарок Вы можете забрать в любое время у нас в офисе по адресу: г. Москва, ул. Нижняя Первомайская, д. 45. Ждем Вас!</center>'
                    });
                    $("#dispatches_form").trigger('reset');
                } else {
                    $.fancybox({
                        content: data
                    });
                }
            }
        });
        return false;
    })
    if ($("input[value='5036']")) {
        $("input[value='5036']").click();
    };
    $(".unaviable").bind('click', function() {
        $(".reminder_block").fadeIn()
        return false;
    })
    $(".reminder_ok").bind('click', function() {
        var emailInput = $(this).prev('.unaviable_reminder');
        var email = $(this).prev('.unaviable_reminder').val();
        var id = $(this).prev('.unaviable_reminder').attr('rel');
        var href = '/catalog/setReminder/' + id + '/';
        $.ajax({
            'url': href,
            'data': {
                'id': id,
                'email': email
            },
            success: function(data) {
                $(".reminder_block").fadeOut();
                $(emailInput).val('');
                $.fancybox({
                    'content': '<center>Мы получили Вашу заявку.<br />Вы получите оповещение при поступлении данного товара на склад</center>'
                })
            }
        });
        return false;
    });
    $(".rememberLink").bind('click', function() {
        $.fancybox({
            content: '<p>Укажите свой E-mail и мы пришлем Вам письмо, как только товар появится у нас на складе.</p>\
								<input type="text" value="" id="emailInput" />\
								<a href="#" id="sndEmail">Отправить</a>\
								'
        });
        return false;
    });
    $("#sndEmail").live('click', function() {
        var email = $(this).prev().val();
        if (email == '') {
            alert('Указан пустой email');
        }
        var id = $('.btn').attr('rel');
        var href = '/catalog/setReminder/' + id + '/';
        $.ajax({
            'url': href,
            'data': {
                'id': id,
                'email': email
            },
            success: function(data) {
                $(".reminder_block").fadeOut();
                $(emailInput).val('');
                $.fancybox({
                    'content': '<center>Мы получили Вашу заявку.<br />Вы получите оповещение при поступлении данного товара на склад</center>'
                });
            }
        });
        return false;
    });
    var surrounding = $('.surrounding').lightSlider({
        item: 3,
        autoWidth: false,
        slideMove: 3,
        slideMargin: 10,
        keyPress: false,
        controls: true
    });
    
    /* Нажатие на кнопку отозваться */
    $(document).on('click','.vacancy_reply',function(){
        var vacancy_id = $(this).attr('rel');
        
        $.ajax({
            url:'/udata/content/getVacancyReplyForm/',
            type: 'POST',
            data:{
                'vacancy_id':vacancy_id
            },
            dataType: 'html',
            success:function(response){
                $.fancybox({
                    content:response
                });
            }
        });

        return false;
    });
    
    /* Нажатие на кнопку отправить */
    $(document).on('click','.vacReplySnd',function(){
        var vacancy_id = $(this).attr('rel');

        $.ajax({
            url:'/content/sendVacancyReplyForm/',
            type: 'POST',
            data:{
                'vacancy_id':vacancy_id,
                'soiskatel': $("#vacForm").serialize()
            },
            dataType: 'json',
            success:function(response){
                if(response.status == 'error'){
                    var n = noty({
                        text: response.message,
                        type: 'error',
                        modal: true,
                        layout: 'top',
                        dismissQueue: true,
                        timeout: 4000,
                        animation: {
                            open: 'animated bounceInDown',
                            close: 'animated bounceOutUp',
                            easing: 'swing',
                            speed: 500
                        }
                    });
                    $("#"+response.fld).trigger('focus');
                }else{
                    $.fancybox({
                        content:response.message
                    });
                }
            }
        });

        return false;
    });
    
    updateCartBlock();
});

function add_basket_btn(event) {
    var oLink = event.target;
    var oLink_innerHTML = $(oLink).clone().html();
    if ($(".btn").length > 1) {
        $(oLink).html('<img style="margin: 3px; padding: 0px;" src="/templates/shop/images/204.gif" />');
    } else {
        $(oLink).html('<img style="margin: 3px; padding: 0px;" src="/templates/shop/images/205.gif" />');
    }
    $(oLink).bind('click', function() {
        return false;
    });
    $.ajax({
        url: '/udata' + oLink.attr('href') + '/.json',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            var TotalAmount = data['summary']['amount'];
            var Price = data['summary']['price']['actual'];
            var Suffix = data['summary']['price']['suffix'];
            TotalAmount_lastnum = parseInt(TotalAmount.toString().slice(-1));
            Price_lastnum = parseInt(Price.toString().slice(-1));
            var ending = '';
            var price_ending = '';
            if (TotalAmount_lastnum >= 2 && TotalAmount_lastnum <= 4) {
                ending = 'а';
            }
            if (TotalAmount_lastnum >= 5 || TotalAmount_lastnum == 0) {
                ending = 'ов';
            }
            if (Price_lastnum == 1) {
                price_ending = 'рубль';
            }
            if (Price_lastnum >= 2 && Price_lastnum <= 4) {
                price_ending = 'рубля';
            }
            if (Price_lastnum >= 5 || Price_lastnum == 0) {
                price_ending = 'рублей';
            }
            Price = number_format(Price, '', '.', ' ');
            $("#container").notify("create", {
                title: 'Товар добавлен в корзину',
                text: 'В корзине <b>' + TotalAmount + '</b> товар' + ending + '<br />' + 'На сумму <b>' + Price + '</b> ' + price_ending
            });
            if (TotalAmount > 0 && $("#cart_text").text != 'Ваша корзина') {
                $("#cart_text").text = 'Ваша корзина';
            }
            $("#amount").text("( " + TotalAmount + " )");
            $(oLink).html(oLink_innerHTML);
            $(oLink).unbind('click');
            yaCounter1717901.reachGoal('addToCart');
        }
    })
    return false;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var i,
        j,
        kw,
        kd,
        km;
    if (isNaN(decimals = Math.abs(decimals))) {
        decimals = 2;
    }
    if (dec_point == undefined) {
        dec_point = ",";
    }
    if (thousands_sep == undefined) {
        thousands_sep = ".";
    }
    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
    if ((j = i.length) > 3) {
        j = j % 3;
    } else {
        j = 0;
    }
    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd;
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var results = regex.exec(window.location.search);
    if (results == null)
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function showLic() {}

function updateCartBlock() {
    $.ajax({
        url: "/emarket/getMiniCartBlock/",
        type: "POST",
        dataType: 'html',
        success: function(data) {
            $("#ajaxBlockUpdateWrapper").html(data);
        }
    });
    return '';
}
var getParams = function() {
        var query_string = {};
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            if (typeof query_string[pair[0]] === "undefined") {
                query_string[pair[0]] = pair[1];
            } else if (typeof query_string[pair[0]] === "string") {
                var arr = [query_string[pair[0]], pair[1]];
                query_string[pair[0]] = arr;
            } else {
                query_string[pair[0]].push(pair[1]);
            }
        }
        return query_string;
    }
    ();
$(document).ready(function() {
    if (typeof getParams.ym_island != 'undefined') {
        window.scrollTo(0, $('.sortblock').offset().top - 15);
    }
    $("a.gallery").fancybox();
    $("#slider1").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        autoPlay: 3000,
        navigation: true,
        items: 1,
        itemsDesktop: [991, 1],
        itemsDesktopSmall: [900, 1],
        itemsTablet: [768, 1],
        itemsMobile: [480, 1]
    });
    $('.gamburger').click(function() {
        $('.menu #menu').toggleClass('active');
        $(this).toggleClass('active');
    });
});
var mediaQuery = window.matchMedia('(max-width: 949px)');
if (mediaQuery.matches) {
    $(".bskt_lnk img").attr("src", "/templates/shop/images/cart-icon2.png");
    jQuery(document).ready(function($) {
        $(".search-but").click(function() {
            $("div#sidebar").toggle(0, function() {
                $('div.search input').focus();
                $(".search-but").toggleClass("active");
                $(".cats #menu").toggleClass("dp");
                $(".social").toggleClass("dp");
                $(".market").toggleClass("dp");
            });
            return false;
        });
    });
    jQuery(document).ready(function($) {
        $(".catalog-button").click(function() {
            $("div#sidebar").toggle(0, function() {
                $(".catalog-button").toggleClass("active");
                $(".search").toggleClass("dp");
                $(".social").toggleClass("dp");
                $(".market").toggleClass("dp");
            });
            return false;
        });
    });
    jQuery(document).ready(function($) {
        $("#cat_262 > .otkr , #cat_270 >  .otkr, #cat_271 >  .otkr , #cat_272  > .otkr , #cat_5171 >  .otkr ").click(function() {
            $(this).next().toggle(0, function() {
                $(this).parent().toggleClass("active");
            });
            return false;
        });
    });
    $('#search_block').click(function() {
        $('#search_block form').css('display', 'block');
        $(this).addClass('active');
    });
    jQuery(document).ready(function($) {
        $(".r7 table").click(function() {
            $(".r7 table tbody").toggle(500, function() {
                $(".r7 table").toggleClass("active");
            });
            return false;
        });
    });
}

var SEND_BASKET_SENDSAY = 0;
var SEND_BASKET_SENDSAY_INT = '';

jQuery(document).ready(function()
{
    setTimeout(function()
    {
        var order_id = $('#hd_order_id').val();
        if(parseInt(order_id) > 0)
        {
            clearBasketSendSay(order_id);
        }
        else
        {
            var phone_fld_row = $('#phone_fld_row');
            var email_fld_row = $('#e-mail_fld_row');
            var interval = 120000, NUMBER_ATTEMPTS_SS = 2;
            var email = '', phone = '';
            
            if(phone_fld_row.length > 0 && email_fld_row.length > 0)
            {
                email = email_fld_row.find('input:text:first').val();
                phone = phone_fld_row.find('input:text:first').val();
                interval = 10000;
                NUMBER_ATTEMPTS_SS = 10;
            }
            
            if(SEND_BASKET_SENDSAY > NUMBER_ATTEMPTS_SS)
            {
                try
                {
                    clearInterval(SEND_BASKET_SENDSAY_INT);
                }
                catch(e){}
            }
            
            SEND_BASKET_SENDSAY_INT = setInterval(function()
            {
                sendBasketSendSay(email, phone);
            }, interval);
        }
    }, 2000);
});

function sendBasketSendSay(_email, _phone)
{   
    jQuery.ajax(
    {
        url:'/udata/emarket/getOrderInfo/.json',
        dataType:'json',
        data:'order_id=0',
        success:function(response)
        {
            if(response['items'] != undefined)
            {
                ++SEND_BASKET_SENDSAY;
                var mas_items = [];
                var mas = {}, item = {};
                
                if(_email != undefined && _email != '')
                {
                    mas['email'] = _email;
                }
                else
                {
                    mas['email'] = response['email'];
                }
                
                if(_phone != undefined && _phone != '')
                {
                    mas['phone'] = _phone;
                }
                else
                {
                    mas['phone'] = response['phone'];
                }
                mas['order_id'] = response['order_id'];
                
                for(var i in response['items'])
                {
                    item = {'id': response['items'][i]['id'], 'name': response['items'][i]['name'], 'count': response['items'][i]['count'], 'price': response['items'][i]['price']};
                    mas_items.push(item);
                }

                if(typeof sndsyApi != 'undefined')
                {
                    sndsyApi.basketUpdate(mas_items, mas);
                    console.log('sndsyApi - ok');
                }
                else
                {
                    console.log('sndsyApi - not');
                }
            }
        }
    });
}

function clearBasketSendSay(order_id)
{
    if(parseInt(order_id) > 0)
    {
        $.ajax(
        {
            url:'/udata/emarket/getUserEmail_ClearBasket_SS/.json',
            dataType:'json',
            data:'order_id='+order_id,
            success:function(response)
            {
                if(typeof sndsyApi != 'undefined')
                {
                    try
                    {
                        sndsyApi.basketUpdate({}, {'email':response.email, 'order_id':response.order_id});
                    }
                    catch(e){}
                }
            }
        });
    }
}