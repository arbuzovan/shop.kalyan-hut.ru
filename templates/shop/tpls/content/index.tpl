<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" xmlns:umi="http://www.umi-cms.ru/TR/umi">
	<head>

		%system getOuterContent('./templates/shop/tpls/content/head.inc.tpl')%

	</head>

	<body id="umi-cms-demo">
		%system getOuterContent('./templates/shop/tpls/content/inc/header.inc.tpl')%
		<div id="content_wrapper">
			%system getOuterContent('./templates/shop/tpls/content/inc/left.inc.tpl')%
			<div id="content">

                            <div class="owl-carousel owl-theme" id="slider1">
				%news custom_lastlist('bigslide','slide2',30,0)%

                            </div>
                            %custom slider_2()%
                            %catalog showSpecialOptionItems('new_good', 'new_goods', 18, '270',1,0)%
                            %catalog showAnotherCategoryItems(262, 'new_goods', 18)%
                            <div class="clear"></div>
			<div class="news">
                            <div class="h1text">Новости</div>
                            <div>
                                %news lastlist('new','kal',3,0)%
                            </div>
                            <a class="news" href="//shop.kalyan-hut.ru/new/">Все новости</a>
			</div>

			<div class="i txt">
				<h1  umi:element-id="%pid%" umi:field-name="h1">%h1%</h1>
				<div umi:element-id="%pid%" umi:field-name="content">
                                    %content%
				</div>
				<div style="margin-top: 15px; text-align: center;">
                                    <div class="social soc-responsive" style="text-align: center">
                                        <div class="h1text">Присоединяйтесь</div>
                                        <a href="//instagram.com/kalyan_hut/" target="_blank" style="font-size: 16px; line-height: 20px; text-decoration: none">
                                            <img src="/templates/shop/images/icons/instagram.png" />
                                        </a>
                                    </div>
				</div>
			</div>

		</div>
                </div>

                <div class="clear"></div>
	%system getOuterContent('./templates/shop/tpls/content/inc/footer.inc.tpl')%
	
	<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-37830942-1']);
		  _gaq.push(['_trackPageview']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		</script>
	<div id="vk_api_transport"></div>
		<script type="text/javascript">
			window.vkAsyncInit = function() {
				VK.init({
					apiId: 4184854,
					onlyWidgets: true
				});
			};

			setTimeout(function() {
				var el = document.createElement("script");
				el.type = "text/javascript";
				el.src = "//vk.com/js/api/openapi.js?105";
				el.async = true;
				document.getElementById("vk_api_transport").appendChild(el);
			}, 0);
		</script>
</body>
</html>