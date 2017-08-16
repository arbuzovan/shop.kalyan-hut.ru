<?php
$FORMS = Array();

$FORMS['category_block'] = <<<END
    <div class="clear"></div>
    <div style="text-align: center;">
        <h3 style="margin-top:45px; margin-bottom: 11px; color: #DC9B36;">Популярные товары</h3>
    </div>
    <a href="#" class="top_sur_next"></a>
    <a href="#" class="top_sur_prev"></a>
    <ul id="topItemsSlider">
        %lines%
    </ul>
END;


$FORMS['category_block_empty'] = "";


$FORMS['objects_block'] = <<<END
<li style="position: relative; margin: 5px;">
        %custom makeThumbnail1(%photo%,'80','80', 'test', 0, false, %h1%)%
    <br>
        <a href="//%domain%%link%" target="_blank" style="text-decoration: none;">%name%</a>
    <br>
    <div style="margin-top: 7px;">%data getProperty(%id%,'price')%</div>
    <br>
</li>
END;

$FORMS['objects_block_search_empty'] = <<<END

<p>По Вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</p>

END;

?>