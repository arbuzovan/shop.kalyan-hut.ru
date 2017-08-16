<?php
$FORMS = Array();

$FORMS['category_block'] = <<<END
    <div class="clear"></div>
    <div style="text-align: center;">
        <h3 style="margin-top:45px; margin-bottom: 11px; color: #DC9B36;">Популярные товары</h3>
    </div>
    <div class="slick-carousel">
      %lines%
    </div>
    
    
END;


$FORMS['category_block_empty'] = "";


$FORMS['objects_block'] = <<<END
<div class="slick-carousel-item">
    %custom makeThumbnail1(%photo%,'80','80', 'test', 0, false, %h1%)%
    <a href="//%domain%%link%" target="_blank">%name%</a>
    <div>%emarket showPrice(%id%, 1)%</div>
</div>
END;

$FORMS['objects_block_search_empty'] = <<<END

<p>По Вашему запросу ничего не найдено. Попробуйте изменить параметры поиска.</p>

END;

?>