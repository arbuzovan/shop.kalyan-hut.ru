
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
	div(8).everyTime(5000, function () {
		slide1(parseInt($('div.slide_p a.now').html()) % 5)
	})
}

function slide1(i) {
	var w = $('.slider1').width();
	$('.slider1 ul').animate({
		'margin-left' :  - i * w + 'px'
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
			if (now >=  - (count - max - 1) * w) {
				anim = false;
				$('.slider2 .slide ul').animate({
					'margin-left' : now - w + 'px'
				}, 1000, function () {
					anim = true
				});
			}
		} else
			if (now < 0) {
				anim = false;
				$('.slider2 .slide ul').animate({
					'margin-left' : now + w + 'px'
				}, 1000, function () {
					anim = true
				});
			}
}
