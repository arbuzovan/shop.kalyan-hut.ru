<?php

$FORMS = Array();


$FORMS['menu_block_level1'] = <<<END
<ul id="menu" umi:element-id="%id%" umi:module="content" umi:method="menu" umi:sortable="sortable" umi:add-method="popup" umi:region="list" umi:button-position="bottom right">
    %lines%
</ul>

END;

$FORMS['menu_line_level1'] = <<<END
<a style="margin-left: 0px; text-decoration: none;" href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
    <li>%text%</li>
</a>
%sub_menu%
END;

$FORMS['menu_line_level1_a'] = <<<END
<a style="margin-left: 0px; text-decoration: none;" href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
    <li>%text%</li>
</a>
    %sub_menu%
END;

$FORMS['menu_block_level2'] = <<<END
%lines%
END;

$FORMS['menu_line_level2'] = <<<END
<a style="margin-left:30px;" href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
    %text%
</a>
END;

$FORMS['menu_line_level2a'] = <<<END
<a style="margin-left:30px;" href="%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
    %text%
</a>
END;

?>