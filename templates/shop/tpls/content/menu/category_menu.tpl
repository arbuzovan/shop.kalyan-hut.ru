<?php

$FORMS = Array();


$FORMS['menu_block_level1'] = <<<END
<div id="menu" umi:element-id="%id%" umi:module="content" umi:method="menu" umi:sortable="sortable" umi:add-method="popup" umi:region="list" umi:button-position="bottom right">
    %lines%
</div>

END;

$FORMS['menu_line_level1'] = <<<END
<div class="cat_header" id="cat_%id%">
    <a href="//%domain%%link%"
            umi:element-id="%id%"
            umi:field-name="name"
            umi:delete="delete"
            umi:region="row"
            umi:empty="Название страницы"
    >
        %text%
		
    </a><span class="otkr"></span>
    <div %custom ShowHideInCatalog(%pid%)% class="cat_header">%sub_menu%</div>
</div>

END;

$FORMS['menu_line_level1_a'] = <<<END
<div class="cat_header active" id="cat_%id%">
    <a href="//%domain%%link%"
            umi:element-id="%id%"
            umi:field-name="name"
            umi:delete="delete"
            umi:region="row"
            umi:empty="Название страницы"
   class="active" >
        %text%
    </a><span class="otkr"></span>
    %sub_menu%
</div>
END;

$FORMS['menu_block_level2'] = <<<END
<ul>%lines%</ul>
END;

$FORMS['menu_line_level2'] = <<<END
<li>
    <a style="margin-left:30px; font-size: 16px;" href="//%domain%%link%"
            umi:element-id="%id%"
            umi:field-name="name"
            umi:delete="delete"
            umi:region="row"
            umi:empty="Название страницы"
    >
        %text%
    </a>
</li>
END;

$FORMS['menu_line_level2_a'] = <<<END
<li>
    <span style="margin-left:30px; font-size: 15px; font-weight: bold" href="//%domain%%link%"
            umi:element-id="%id%"
            umi:field-name="name"
            umi:delete="delete"
            umi:region="row"
            umi:empty="Название страницы"
    >
        %text%
    </span>
</li>
END;

?>