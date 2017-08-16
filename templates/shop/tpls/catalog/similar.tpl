<?php

$FORMS = Array();

$FORMS['objects_block'] = <<<END
<div class="clear"></div>
<div id="similar_goods">
    <h3>%block_title%</h3>
    %lines%
</div>
END;

$FORMS['objects_block_line'] = <<<END
<div style="min-height:300px;" class="item" umi:element-id="%id%">
	%data getProperty(%id%, 'new_good', 'new_good')%
	<div class="item_a" style="vertical-align:top;" umi:element-id="%id%" umi:field-name="photo">
		<a href="%link%">%data getProperty(%id%, 'photo', 'preview_image')%</a>
	</div>
	<div style="clear: both; margin-top: 10px; padding-bottom: 10px;">
		%data getProperty(%id%, 'price', 'catalog_preview')%<br />
		<a href="%link%" umi:element-id="%id%" umi:field-name="name" class="title">%h1%</a><br />
		<div style="margin-top: 6px;">
		%emarket basketAddLink(%id%)%
		</div>
	</div>
</div>
END;

$FORMS['objects_block_search_empty'] = <<<END

END;

?>