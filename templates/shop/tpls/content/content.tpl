<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" xmlns:umi="http://www.umi-cms.ru/TR/umi">
	<head>
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
            <div id="container">
                    <div id="content">
                            <div id="left" class="column">
                                    %content menu('sl')%

                                    %news lastlist('/akcii', 'akcii_inner', 1, 1)%
                            </div>
                            <div id="center" class="column">
                                    %core navibar('default', 1, 0, 1)%
                                    <h2 umi:element-id="%pid%" umi:field-name="h1">%header%</h2>
                                    %system listErrorMessages()%
                                    %core insertCut()%
                                    <div umi:element-id="%pid%" umi:field-name="content">
                                            %content%
                                    </div>
                            </div>
                            <div id="right" class="column">
                                    %search insert_form('home')%
                                    %catalog getCategoryList('inner', '/market/', '0', '1')%

                                    %emarket currencySelector()%
                                    %emarket cart('basket')%
                                    %emarket getCompareList('compare_list')%
                            </div>
                    </div>
                    <div id="footer">
                            &copy; ООО "Юмисофт", 2010
                    </div>
            </div>
	</body>
</html>