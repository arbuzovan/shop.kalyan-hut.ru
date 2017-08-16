<?php
$FORMS = Array();

$FORMS['lastlist_block'] = <<<END

<ul umi:module="news" umi:method="lastlist" umi:element-id="%id%">
%items%
</ul>
%system numpages(%total%, %per_page%)%

END;

$FORMS['lastlist_item'] = <<<END
<li style="margin-bottom: 20px;">
	
	<p>
		<a style="font-size: 18px; color: #7A500E" href="%link%" umi:element-id="%id%" umi:field-name="h1">%header%</a> <span umi:element-id="%id%" umi:field-name="publish_time" style="font-style:normal;">(%system convertDate(%publish_time%, 'd.m.Y')%)</span>
	</p>
	
	<p umi:element-id="%id%" umi:field-name="anons">%anons%</p>
</li>

END;

$FORMS['view'] = <<<END
%content%
	<h3 style="margin-bottom: 11px; color: #DC9B36;">Интересно? Поделись с друзьями!</h3>
	<script>
		/* uptolike share begin */
		(function(d,c){
			var up=d.createElement('script'),
					s=d.getElementsByTagName('script')[0],
					r=Math.floor(Math.random() * 1000000);
			var cmp = c + Math.floor(Math.random() * 10000);
			var url = window.location.href;
			window["__uptolike_widgets_settings_"+cmp] = {
					
					
			};
			d.write("<div id='"+cmp+"' class='__uptlk' data-uptlkwdgtId='"+r+"'></div>");
			up.type = 'text/javascript'; up.async = true;
			up.src = "//w.uptolike.com/widgets/v1/widgets.js?b=fb.tw.ok.vk.gp.mr&id=338115&o=1&m=1&sf=2&ss=2&sst=1&c1=ededed&c1a=0.0&c3=ff9300&c5=ffffff&mc=0&sel=0&fol=0&sel=0&c=" + cmp + "&url="+encodeURIComponent(url);
			s.parentNode.insertBefore(up, s);
		})(document,"__uptlk");
		/* uptolike share end */
	</script>
<div class="clear"></div>
%news related_links(%id%)%
END;

$FORMS['related_block'] = <<<END
<p>Похожие новости:</p>
<ul>
	%related_links%
</ul>

END;

$FORMS['related_line'] = <<<END
<li>
	<a href="%link%"><b>%name%</b> (%system convertDate(%publish_time%, 'Y-m-d')%)</a>
</li>
END;



$FORMS['listlents_block'] = <<<END
<p>Рубрики новостей:</p>
<ul>
	%items%
</ul>

END;

$FORMS['listlents_item'] = <<<END
<li>
	<a href="%link%">%header%</a>
</li>

END;

$FORMS['listlents_block_empty'] = "";
?>