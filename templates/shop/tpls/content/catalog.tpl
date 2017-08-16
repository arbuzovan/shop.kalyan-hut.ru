<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
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
		<!--Openstat-->
		<span id="openstat2302267"></span>
		<script type="text/javascript">
		var openstat = { counter: 2302267, next: openstat };
		(function(d, t, p) {
		var j = d.createElement(t); j.async = true; j.type = "text/javascript";
		j.src = ("https:" == p ? "https:" : "http:") + "//openstat.net/cnt.js";
		var s = d.getElementsByTagName(t)[0]; s.parentNode.insertBefore(j, s);
		})(document, "script", document.location.protocol);
		</script>
		<!--/Openstat-->
		%system getOuterContent('./templates/shop/tpls/content/header.inc.tpl')%
		<div id="content_wrapper">
			%system getOuterContent('./templates/shop/tpls/content/left.inc.tpl')%
			<div id="content">
				%core navibar('default', 1, 0, 1)%
				<br />
				<h1 umi:element-id="%pid%" umi:field-name="h1" style="display: inline;">%header%</h1>
				%content%
			</div>
	</div>
	
	<div class="clear"></div>
	
	%system getOuterContent('./templates/shop/tpls/content/footer.inc.tpl')%

</body></html>