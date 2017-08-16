<?php

$FORMS = Array();


$FORMS['menu_block_level1'] = <<<END
<div id="menu"
	umi:element-id="%id%"
	umi:module="content"
	umi:method="menu"
	umi:sortable="sortable"
	umi:add-method="popup"
	umi:region="list"
	umi:button-position="bottom right"
>
	%lines%
</div>

END;

$FORMS['menu_line_level1'] = <<<END
<a id="pid_%id%" href="//%domain%%link%"
	umi:element-id="%id%"
	umi:field-name="name"
	umi:delete="delete"
	umi:region="row"
	umi:empty="Название страницы"
>
	%text%
</a>

END;

$FORMS['menu_line_level1_a'] = <<<END
<a class="active" id="pid_%id%" href="//%domain%%link%" umi:element-id="%id%" umi:field-name="name" umi:delete="delete" umi:region="row" umi:empty="Название страницы">
    %text%
</a>
END;


?>