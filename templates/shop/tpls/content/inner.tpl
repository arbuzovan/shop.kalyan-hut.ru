<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" xmlns:umi="http://www.umi-cms.ru/TR/umi" prefix="ya: http://webmaster.yandex.ru/vocabularies/">
	<head>
            <meta property="ya:interaction" content="XML_FORM" />
            <meta property="ya:interaction:url" content="//shop.kalyan-hut.ru/shop.kalyan-hut-scheme.xml" />

            %system getOuterContent('./templates/shop/tpls/content/head.inc.tpl')%
	</head>

	<body id="umi-cms-demo">
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
		%system getOuterContent('./templates/shop/tpls/content/inc/header.inc.tpl')%
		<div id="content_wrapper">
                    %system getOuterContent('./templates/shop/tpls/content/inc/left.inc.tpl')%
                    <div id="content">
                        %core navibar('default', 1, 0, 1)%
                        <h1 umi:element-id="%pid%" umi:field-name="h1">%content getHeader()%</h1>
                        <div umi:element-id="%pid%" umi:field-name="content">
                                %system listErrorMessages()%
                                %content%
                        </div>
                    </div>
                </div>
        </div>

	<div class="clear"></div>
	%system getOuterContent('./templates/shop/tpls/content/inc/footer.inc.tpl')%
</body></html>
