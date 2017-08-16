<?php

$FORM = Array();

$FORMS['menu_block_level1'] = <<<END
%lines%
END;

$FORMS['menu_line_level1'] = <<<END

END;

$FORMS['menu_line_level1_a'] = <<<END
%sub_menu%
END;



$FORMS['menu_block_level2'] = <<<END
<ul id="submenu"
                umi:element-id="%id%"
                umi:module="content"
                umi:method="menu"
                umi:sortable="sortable"
                umi:add-method="popup"
                umi:region="list"
                umi:button-position="top left"
>
    %lines%
</ul>
END;

$FORMS['menu_line_level2'] = <<<END
    <li><a href="http://%domain%%link%" umi:field-name="name">%text%</a></li>
END;

$FORMS['menu_line_level2_a'] = <<<END
    <li class="active"><a href="http://%domain%%link%" umi:field-name="name">%text%</a></li>
%sub_menu%

END;


$FORMS['menu_block_level3'] = <<<END
<ul
        umi:element-id="%id%"
        umi:module="content"
        umi:method="menu"
        umi:sortable="sortable"
        umi:add-method="popup"
        umi:region="list"
        umi:button-position="top left"
>
    %lines%
</ul>
END;

$FORMS['menu_line_level3'] = <<<END
<li
        umi:element-id="%id%"
        umi:field-name="name"
        umi:delete="delete"
        umi:region="row"
        umi:empty="Название страницы"
>
        <a href="http://%domain%%link%" umi:field-name="name">%text%</a>
</li>

END;

$FORMS['menu_line_level3_a'] = <<<END
<li class="active"
        umi:field-name="name"
        umi:element-id="%id%"
        umi:field-name="name"
        umi:delete="delete"
        umi:region="row"
        umi:empty="Название страницы"
>
        %text%
</li>
END;


?>
