<?php
$FORMS = Array();

$FORMS['category'] = <<<END
<div style="float: right; margin-left: 10px;" umi:element-id="%id%" umi:field-name="descr">%data getYoutubeVideo(%id%)%</div>
<div umi:element-id="%id%" umi:field-name="descr">%catalog showDescr(%id%)%</div>
<div class="clear"></div>
%catalog getCategoryList('default', '%category_id%', 100, 1)%
<!-- %catalog customGetObjectsList('default', '%category_id%', %custom getCount()%, 0, 2, 'price')% -->
%catalog customGetObjectsList('default', '%category_id%', %custom getCount()%, 0, 2, 'default')%
<div class="clear"></div>
%content showDopText(%pid%,'zagolovok')%
%content showDopText(%pid%,'descripton2')%
END;


$FORMS['category_block'] = <<<END
<h2 style="margin: 30px 0 5px 0;">%catalog getSubcategoryTitle(%pid%)%</h2>
%lines%
END;


$FORMS['category_block_empty'] = "";


$FORMS['category_block_line'] = <<<END
<a style="margin-right: 7px;" href="//%domain%%link%"><b>%text%</b></a>
END;


$FORMS['objects_block'] = <<<END
<div class="clear"></div>
%catalog customShowFilter(%category_id%)%
<div class="sortblock">
Сортировать по:
<!--a href="?order_filter[default]=0">По умолчанию</a> |
<a href="?&order_filter[price]=1">Цене</a> |
<a href="?&order_filter[name]=1">Названию</a-->
%catalog showSortParam(%category_id%)%
</div>
<div class="clear"></div>
<div>
    <div style="float: right" class="r5">
        %system numpages(%total%, %per_page%)%
    </div>
    <div class="r4">
    Показывать товаров
        <div id="countElementsLinks">
            <a class="countElements%custom is_sel(30)%" rel="30" href="%system getCurrentURI()%?count=30">30</a>
            <a class="countElements%custom is_sel(45)%" rel="45" href="%system getCurrentURI()%?count=45">40</a>
            <a class="countElements%custom is_sel(60)%" rel="60" href="%system getCurrentURI()%?count=60">50</a>
            <a class="countElements%custom is_sel(1000)% all" rel="1000" href="%system getCurrentURI()%?count=1000">Все</a>
        </div>
    </div>
</div>
<div class="clear"></div>
<link itemprop="url" href="//shop.kalyan-hut.ru%system getCurrentURI()%"/>
<span style="display:none;" itemprop="numberOfElements">%total%</span>
<ul class="text-center" umi:method="catalog" umi:module="category" umi:element-id="%category_id%" itemscope itemtype="http://schema.org/ItemList">
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
        <a class="itemMiniViewName" href="//%domain%%link%">%catalog getElementName(%id%)%</a>
        <div style="position: absolute; text-align: left;">
            %data getProperty(%id%, 'new_good', 'stars_label_small')%
            %data getProperty(%id%, 'top', 'stars_label_small')%
        </div>
        <div class="itemMiniViewImageWrapper">
            <a href="//%domain%%link%">
                %custom makeThumbnail1(%photo%,'120','160', 'default', 0, false, %h1%)%
            </a>
        </div>
        %emarket getBasketAddBtnBlock(%id%)%
    </li>
END;


/* Карточка товара */
$FORMS['view_block'] = <<<END
<div itemscope itemType = "http://schema.org/Product" class="itemCartWrapper">
    <meta itemprop="name" content="%h1%">
    <div style="position: relative;">
        <div style="float: left;" class="r6">
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
		<div class="r7" itemprop="offers" itemscope itemtype="http://schema.org/Offer" style="float: right;" umi:element-id="%pid%" umi:field-name="content">
        <div class="show_hide_button"></div>
                %data getPropertyGroup(%id%,'catalog_option_props','test')%
                %data getPropertyGroup(%id%,'opcionnye_svojstva_uglej','test')%
                %data getPropertyGroup(%id%,'opcionnye_svojstva_dlya_tabakov','test')%
                %data getPropertyGroup(%id%,'opcionnye_svojstva_aksessuarov','test')%
                %emarket getBasketAddBtnBlock(%id%, 'default',true)%
                <div class="clear"></div>
                %content showTabakContent('itemCart')%
                <div class="clear"></div>
                %data getProperty(%id%,'recommended_items', 'test')%
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
            <!-- Put this div tag to the place, where the Comments block will be -->
            <div id="vk_comments" style="display: block;"></div>
            <script type="text/javascript">
              window.vkAsyncInit = function() {
                VK.init({
                  apiId: 4184854,
                  onlyWidgets: true
                });
                VK.Widgets.Comments("vk_comments", {limit: 10, width: "596", attach: "*"});
              };
            </script>
        </div>
    </div>

    <h3 style="margin-bottom: 11px; color: #DC9B36;">Понравился товар? Поделись находкой с друзьями!</h3>


<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="#ebebeb" data-options="medium,square,line,horizontal,nocounter,theme=04" data-services="facebook,twitter,vkontakte,odnoklassniki,google,moimir,email"></div>

<div>

<div class="clear"></div>

%catalog showAnotherCategoryItems(%id%)%

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