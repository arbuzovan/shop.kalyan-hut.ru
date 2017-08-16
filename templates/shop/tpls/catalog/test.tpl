<?php
$FORMS = Array();

$FORMS['category'] = <<<END
<div umi:element-id="%id%" umi:field-name="descr">%descr%</div>
%catalog getCategoryList('default', '%category_id%', 100, 1)%
%catalog customGetObjectsList('default', '%category_id%', %custom getCount()%, 0, 3)%

END;


$FORMS['category_block'] = <<<END
<h2 style="margin: 30px 0 5px 0;">Разделы</h2>
%lines%
END;


$FORMS['category_block_empty'] = "";


$FORMS['category_block_line'] = <<<END
<a style="margin-right: 7px;" href="%link%"><b>%text%</b></a>

END;


$FORMS['objects_block'] = <<<END
<div class="clear"></div>
<div class="sortblock">
Ценовой диапозон (в руб.): 
<a href="?fields_filter%5Bprice%5D%5B0%5D=0&amp;fields_filter%5Bprice%5D%5B1%5D=1000">до 1000</a> | 
<a href="?fields_filter%5Bprice%5D%5B0%5D=1000&amp;fields_filter%5Bprice%5D%5B1%5D=2500">1000 - 2500</a> | 
<a href="?fields_filter%5Bprice%5D%5B0%5D=2500&amp;fields_filter%5Bprice%5D%5B1%5D=5000">2500 - 5000</a> | 
<a href="?fields_filter%5Bprice%5D%5B0%5D=5000&amp;fields_filter%5Bprice%5D%5B1%5D=100000">от 5000</a> 
<br>
Сортировать по: <a href="?&order_filter[price]=1">Цене</a> | 
<a href="?&order_filter[name]=1">Названию</a>
</div>

<div class="clear"></div>
<div>
    <div style="float: right">
        %system numpages(%total%, %per_page%)%
    </div>
    <div id="countElementsLinks">
        <a class="countElements%custom selected(30)%" rel="30" href="%system getCurrentURI()%?count=30">30</a>
        <a class="countElements%custom selected(40)%" rel="40" href="%system getCurrentURI()%?count=40">40</a>
        <a class="countElements%custom selected(50)%" rel="50" href="%system getCurrentURI()%?count=50">50</a>
    </div>
</div>
<div class="clear"></div>
<div style="clear: both;"></div>
<ul umi:method="catalog" umi:module="category" umi:element-id="%category_id%" itemscope itemtype="http://schema.org/ItemList">
    <link itemprop="url" href="//shop.kalyan-hut.ru%system getCurrentURI()%"/>
    %lines%
</ul>
<div style="clear: both;"></div>
%system numpages(%total%, %per_page%)%
<div style="clear: both;"></div>
END;


$FORMS['objects_block_search_empty'] = <<<END

<p>По Вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</p>

END;


$FORMS['objects_block_line'] = <<<END
<li class="itemMiniViewWrapper">
    <a class="itemMiniViewName" href="%link%">%h1%</a>
    <div class="itemMiniViewImageWrapper">
        <a href="%link%">
            %custom makeThumbnail1(%photo%,'120','160', 'default', 0, false, %h1%)%
        </a>
    </div>
    %emarket getBasketAddBtnBlock(%id%)%
</li>
END;


/* Карточка товара */
$FORMS['view_block'] = <<<END
<div itemscope itemType = "http://schema.org/Product">
    <div style="position: relative;">
        <div style="float: right" umi:element-id="%pid%" umi:field-name="content">
                %data getPropertyGroup(%id%,'catalog_option_props','test')%
                %emarket getBasketAddBtnBlock(%id%, 'default',true)%
                <div class="clear"></div>
                %data getProperty(%id%,'recommended_items', 'test')%
        </div>
        <div style="float: left;">
            <div>
                <div style="position: absolute; width: 240px; text-align: right;">
                    %data getProperty(%id%, 'new_good', 'stars_label')%
                    %data getProperty(%id%, 'top', 'stars_label')%
                </div>
                <a itemprop="image" class="gallery" href="%photo%" title="%h1%">
                   %custom makeThumbnail1(%photo%,'200','213', 'test', 0, false, %h1%)%
                </a>
            </div>
            <div>
                <ul class="more_photos">
                    <li>
                        <a itemprop="image" class="gallery" href="%photo_2%" title="%h1%">
                            %custom makeThumbnail1(%photo_2%,'100','200', 'default', 0, false, %h1%)%
                        </a>
                    </li>
                    <li>
                        <a itemprop="image" class="gallery" href="%photo_3%" title="%h1%">
                            %custom makeThumbnail1(%photo_3%,'100','200', 'default', 0, false, %h1%)%
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div id="tab_wrapper">
        <a href="#" id="tab1" class="active">Описание</a>
        <a href="#" id="tab2">Комментарии</a>
        <div itemprop="description" id="con_tab1" class="tab_content active">
            %data getProperty(%id%, 'description')%
        </div>
        <div id="con_tab2" class="tab_content">
            <h3 style="margin-bottom: 11px; color: #DC9B36;">Оставьте свой комментарий</h3>

            <!-- Put this script tag to the <head> of your page -->
            <script type="text/javascript">
              VK.init({apiId: 4184854, onlyWidgets: true});
            </script>

            <!-- Put this div tag to the place, where the Comments block will be -->
            <div id="vk_comments"></div>
            <script type="text/javascript">
            VK.Widgets.Comments("vk_comments", {limit: 10, width: "596", attach: "*"});
            </script>
        </div>
    </div>

    <h3 style="margin-bottom: 11px; color: #DC9B36;">Понравился товар? Поделись находкой с друзьями!</h3>
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
<div>

<div class="clear"></div>

<!--%catalog similarGoods(%id%, 'similar', 3, 'С этим товаром так же покупают:')%-->

END;

$FORMS['search_block'] = <<<END

<form method="get" action="%content get_page_url(%category_id%)%">
		<div style="padding-bottom:5px;">Фильтр по товарам</div>

		%lines%
		
		<div style="clear:both;"></div>

	<input type="submit" class="filter_btn" value="Подобрать" />
	<input class="filter_btn" type="button" onclick="javascript: window.location = '%content get_page_url(%category_id%)%';" value="Сбросить" class="filter_btn" />
</form>


END;


$FORMS['search_block_line'] = <<<END
    <table border="0" cellpadding="0" cellspacing="0" style="float:left;" id="search_block" rules="rows">
        %selector%
    </table>

END;



$FORMS['search_block_line_relation'] = <<<END

<tr id="hat">
	<td style=" width: 100px;">
		%title%
	</td>
</tr>
<tr>
	<td>
		<select name="fields_filter[%name%]" class="textinputs" style="width:100px; height: 18px;"><option />%items%</select>
	</td>
</tr>
END;


$FORMS['search_block_line_text'] = <<<END

<tr id="hat">
	<td>
		%title%
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="fields_filter[%name%]" class="textinputs" value="%value%" />
	</td>
</tr>

END;

$FORMS['search_block_line_price'] = <<<END


<tr id="hat">
	<td>
		%title% от &nbsp;до
	</td>
</tr>
<tr>
	<td>
		<input type="text" name="fields_filter[%name%][0]" class="textinputs" style="width:40px;" value="%value_from%" size="12" /> <input type="text" name="fields_filter[%name%][1]" class="textinputs" style="width:40px;" value="%value_to%" size="12" />
	</td>
</tr>


END;

$FORMS['search_block_line_boolean'] = <<<END

<tr id="hat">
	<td>
		<label for="fields_filter[%name%]" style="">%title%</label>
	</td>
</tr>
<tr>
	<td>
		<input type="checkbox" name="fields_filter[%name%]" id="fields_filter[%name%]" %checked% value="1" /> 
	</td>
</tr>

END;

?>